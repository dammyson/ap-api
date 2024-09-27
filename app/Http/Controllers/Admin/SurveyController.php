<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Option;
use App\Models\Admin\Survey;
use Illuminate\Http\Request;
use App\Models\Admin\Question;
use App\Http\Controllers\Controller;
use App\Models\Admin\SurveyUserResponse;
use App\Http\Requests\Admin\CreateSurveyRequest;

class SurveyController extends Controller
{
    //
    public function createSurvey(CreateSurveyRequest $request) {
        
        try {
            
            $title = $request->input('title');
            $questions = $request->input('questions');
            $duration_of_survey = $request->input('duration_of_survey');
            $points_awarded = $request->input('points_awarded');
            $image_url = $request->input('image_url');

            $survey = Survey::create([
                'title' => $title,
                // 'duration_of_survey' => now()->addMinutes($duration_of_survey),
                'duration_of_survey' => $duration_of_survey,
                'points_awarded' => $points_awarded,
                'image_url' => $image_url
            ]);

            foreach($questions as $question) {
                $quest = Question::create([
                    'question_text' => $question['question_text'],
                    'survey_id' => $survey->id 
                ]);

                foreach($question['options'] as $option) {
                    Option::create([
                        'question_id' => $quest->id,
                        'option_text' => $option['option_text']
                    ]);
                }

            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
        
        return response()->json([
            'error' => false,
            'message' => 'survey created successfully',
            'survey' => $survey

        ]);


    }

    public function surveyTable() {
        try {
            $surveyData = Survey::all();

        } catch(\Throwable $th) {
            return response()->json([
                'error' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        return response()->json([
            'error' => false,
            'survey_data' => $surveyData
        ], 200);


    }

    public function tooglePublishSurvey(Request $request, Survey $survey) {
        try {
            $survey->is_published = !$survey->is_published;
            
            // if survey is not published then it is in draft
           
            $survey->save();

            $message = $survey->is_published ? 'survey published successfully' 
                    : 'survey unpublished successfully';
            

            return response()->json([
                'error' => false,
                'message' => $message,
                'survey' => $survey
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function deleteSurvey(Request $request, Survey $survey) {
        try {
            $survey->delete();

            return response()->json([
                'error' => false,
                'message' => 'deleted',
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }

    }

    public function getSurveyResults(Survey $survey) {
        try {
            // Fetch the survey with its questions and options
            $survey = $survey->load(['questions.options']);
            

            // Prepare the data to return
            $results = [];

            foreach ($survey->questions as $question) {
                $questionResults = [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'options' => []
                ];

                // Get total votes for this question
                $totalVotesForQuestion = SurveyUserResponse::where('question_id', $question->id)->count();

                // For each option, calculate the percentage of votes
                foreach ($question->options as $option) {
                    $optionVotes = SurveyUserResponse::where('question_id', $question->id)
                                                    ->where('option_id', $option->id)
                                                    ->count();

                    $percentage = $totalVotesForQuestion > 0 
                        ? ($optionVotes / $totalVotesForQuestion) * 100 
                        : 0;

                    $questionResults['options'][] = [
                        'option_id' => $option->id,
                        'option_text' => $option->option_text,
                        'votes' => $optionVotes,
                        'percentage' => $percentage,
                    ];
                }

                $results[] = $questionResults;
            }

            // Return the survey results with percentage data
            return response()->json([
                'error' => false,
                'message' => 'Survey results retrieved successfully',
                'data' => $results
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function editSurvey (Request $request, Survey $survey) {      
        $title = $request->input('title');
        $duration_of_survey = $request->input('duration_of_survey');
        $points_awarded = $request->input('points_awarded');
        $image_url = $request->input('image_url');
        $requestQuestions = $request->input('questions');

        $survey->update([
            'title' => $title,
            'duration_of_survey' => $duration_of_survey,
            'points_awarded' => $points_awarded,
            'image_url' => $image_url
        ]);
       

        foreach($requestQuestions as $requestQuestion) {
            $question = Question::find($requestQuestion['id']) ?? new Question();
            $question->question_text = $requestQuestion['question_text'];

            $question->survey_id = $survey->id;
            $question->save();

            foreach($requestQuestion['options'] as $option) {
                $option = Option::find($option['id'])  ?? new Option();
                $option->question_id = $question->id;
                $option->option_text = $option['option_text'];
                $option->save();
            }
        }   

        $surveyData = $survey->load('questions.options');

        return response()->json(
            [
                'error' => false,
                'edited_survey' => $surveyData
            ]
        );
    
    }


    public function showSurvey(Survey $survey) {
        try {
            $survey = $survey->load('questions.options');

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()

            ], 500);
        }

        return response()->json([
            'error' => false,
            'survey' => $survey
        ], 200);

    }

    public function surveyParticipants($surveyId) {
        try {
            // $users = SurveyUserResponse::where('survey_id', $surveyId)
            //             ->whereHas('users', function($query) {
            //                 $query->with('users');
            //             })->select('user_id');

            $users = User::whereHas('surveyUserResponses', function($query) use($surveyId) {
                        $query->where('survey_id', $surveyId);
                    })->get();

            return response()->json([
                'error' => false,
                'users' => $users
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }

    }
}

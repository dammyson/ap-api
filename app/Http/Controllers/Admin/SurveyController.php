<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Option;
use App\Models\Admin\Survey;
use Illuminate\Http\Request;
use App\Models\Admin\Question;
use App\Models\PointAllocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\SurveyUserResponse;
use App\Http\Requests\Admin\CreateSurveyRequest;
use App\Http\Resources\SurveyCollection;
use Carbon\Carbon;

class SurveyController extends Controller
{
    //
    public function createSurvey(CreateSurveyRequest $request) {
        
        try {
            
            $title = $request->input('title');
            $questions = $request->input('questions');
            $duration_of_survey = $request->input('duration_of_survey');
            $points_awarded = $request->input('points_awarded');

            $survey = Survey::create([
                'title' => $title,
                // 'duration_of_survey' => now()->addMinutes($duration_of_survey),
                'duration_of_survey' => $duration_of_survey,
                'points_awarded' => $points_awarded,
            ]);

            foreach($questions as $question) {
                $quest = Question::create([
                    'question_text' => $question['question_text'],
                    'is_multiple_choice' => $question['is_multiple_choice'],
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

    public function updateSurveyImage(Request $request, Survey $survey) {        
        try {
            if ($request->file('image_url')) {
                // store the file in the admin-profile-images folder
                    $path = $request->file('image_url')->store('survey-images');
                    // store the path to the image
                    $survey->image_url = $path;

                    $imageUrlLink = Storage::url($path);

                    $survey->save();

                    return response()->json([
                        "error" => false,
                        "message" => "Survey image updated successfully",
                        "image_url_link" => $imageUrlLink
                    ], 200);
               }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
        

    }

    public function surveyTable(Request $request) {
        try {
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $title = $request->input('title');

            $query = Survey::query();
            
            if ($title) {
                $query->where('title', $title);
            }

            if ($to_date && $from_date) {
                $to_date = Carbon::parse($to_date)->endOfDay();
                $query->whereBetween('created_at', [$from_date, $to_date]);
            } else if ($from_date) {
                $query->where('created_at', '>=', $from_date);
            }

            $filteredSurveys = new SurveyCollection($query->get());

        } catch(\Throwable $th) {
            return response()->json([
                'error' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        return response()->json([
            'error' => false,
            'surveys' => $filteredSurveys
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
            $image_url = $survey->image_url;

            $image_url_link = Storage::url($image_url);

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
                "image_url_link" => $image_url_link,
                'results' => $results
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
        $requestQuestions = $request->input('questions');

        $survey->update([
            'title' => $title,
            'duration_of_survey' => $duration_of_survey,
            'points_awarded' => $points_awarded,
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
            $image_url = $survey->image_url;

            $image_url_link = Storage::url($image_url);

            $surveyData = [
                "image_url_link" => $image_url_link,
                "survey" => $survey
            ];

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()

            ], 500);
        }

        return response()->json([
            'error' => false,
            'surveyData' => $surveyData
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

    public function allocatePointToParticipant(Request $request, $surveyId, $participantId) {
        $points = $request->input('points');
        $reason = $request->input('reason_of_allocation');

        $admin = $request->user('admin');


        try {

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 


            $user = User::find($participantId);

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'user not found'
                ], 500);
            }
            $user->points += $points;
            $user->save();

            $userName = $user->first_name . ' '. $user->last_name;

            PointAllocation::create([
                'admin_id' => $admin->id,
                'admin_user_name' => $admin->user_name,
                'user_id' => $user->id,
                'user_name' => $userName,
                'point_allocated' => $points,
                'reason_of_allocation' => $reason,
                'survey_id' => $surveyId,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'points have been allocated to user successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }
}

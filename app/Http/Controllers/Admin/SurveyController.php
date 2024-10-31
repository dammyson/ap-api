<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminSurveyEvent;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Option;
use App\Models\Admin\Survey;
use Illuminate\Http\Request;
use App\Models\Admin\Question;
use App\Models\PointAllocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SurveyCollection;
use App\Models\Admin\SurveyUserResponse;
use App\Http\Requests\Admin\CreateSurveyRequest;
use App\Http\Requests\FilterSurveyRequest;
use App\Http\Requests\UpdateSurveyImageRequest;
use App\Http\Resources\SurveyResource;
use Illuminate\Support\Facades\DB;


class SurveyController extends Controller
{
    //
    public function createSurvey(CreateSurveyRequest $request) {
        
        try {

            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 
            
            $title = $request->input('title');
            $questions = $request->input('questions');
            $duration_of_survey = $request->input('duration_of_survey');
            $points_awarded = $request->input('points_awarded');  
            $image_url = $request->input('image_url');          
            $is_active = $request->input('is_active');

            if ($is_active) {
               $survey = Survey::where('is_active', true)->first();
               if ($survey) {
                    return response()->json([
                        "error" => true,
                        "message" => "A survey is currently active would you like to end and begin a new one"
                    ], 500);
               }

            }
         
            $survey = Survey::create([
                'title' => $title,
                // 'duration_of_survey' => now()->addMinutes($duration_of_survey),
                'duration_of_survey' => $duration_of_survey,
                'points_awarded' => $points_awarded,
                'is_active' => $is_active,
                'image_url' => $image_url
            ]);

            // $survey->image_url = $path;
            // // $imageUrlLink = Storage::url($path);
            // $survey->save();
            
            if ($request->file('image_url')) {
                $path = $request->file('image_url')->store('survey-images');
                // store the path to the image
                $survey->image_url = $path;
                // $imageUrlLink = Storage::url($path);
                $survey->save();

            }

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

            event(new AdminSurveyEvent($admin, $survey, "created"));

            $survey = new SurveyResource($survey);

            

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

    public function deActiveSurvey(Request $request) {
        try {
            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 
    
            $survey = Survey::where('is_active', true)->first();
            if ($survey) {
                $survey->is_active = false;
                $survey->save();

                event( new AdminSurveyEvent($admin, $survey, "deactived"));
    
                return response()->json([
                    'error' => false,
                    'message' => 'survey deactivated successfully'
                ], 200);
            }

            return response()->json([
                'error' => false,
                'message' => 'no current active survey'
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }


    public function createSurveyBanner(Request $request) {

        if ($request->file('image_url')) {
            $path = $request->file('image_url')->store('survey-images');

            $image_url_link = Storage::url($path);
    
            return response()->json([
                "error" => true,
                "image_url" => $path,
                "image_url_link" => $image_url_link
    
            ], 200);
        }
    }

    public function updateSurveyImage(UpdateSurveyImageRequest $request, Survey $survey) {        
        try {

            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 

            if ($request->file('image_url')) {
                // store the file in the admin-profile-images folder
                    $path = $request->file('image_url')->store('survey-images');
                    // store the path to the image
                    $survey->image_url = $path;

                    $imageUrlLink = Storage::url($path);

                    $survey->save();

                    event( new AdminSurveyEvent($admin, $survey, "updated banner for"));

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

    public function surveyTable(FilterSurveyRequest $request) {
        try {
          
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $title = $request->input('title');

            $query = Survey::query();
            
            if ($title) {
                $query->where('title', 'like', '%' . $title . '%');
            }

            if ($to_date && $from_date) {
                if ($to_date < $from_date) {
                    return response()->json([
                        "error" => true,
                        "message" =>  "End date cannot be earlier than start date"
                    ], 400);
                }
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
            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 

            $survey->is_published = !$survey->is_published;
            
            // if survey is not published then it is in draft
           
            $survey->save();

            
            $action = $survey->is_published ? 'published' 
                    : 'unpublished';
            

            event( new AdminSurveyEvent($admin, $survey, $action));

            return response()->json([
                'error' => false,
                'message' => "survey {$action} successfully",
                'survey' => $survey
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
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
                                                    ->whereHas('options', function($query) use($option) {
                                                        $query->where('option_id', $option->id);
                                                    })
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


    public function getSurveyResultByGender(Survey $survey) {

        $totalResultCount = SurveyUserResponse::where("survey_id", $survey->id)->get();

        // Return zero percentages if there are no responses
        if ($totalResultCount === 0) {
            return response()->json([
                "error" => false,
                "male_percentage" => 0,
                "female_percentage" => 0
            ]);
        }
        
        // Count responses by gender in a single query to improve performance
        // $genderCounts = SurveyUserResponse::where("survey_id", $survey->id)
        //     ->whereHas('user', function($query) {
        //         $query->whereIn('gender', ['Male', 'Female']);
        //     })
        //     ->selectRaw("SUM(CASE WHEN users.gender = 'Male' THEN 1 ELSE 0 END) as male_count")
        //     ->selectRaw("SUM(CASE WHEN users.gender = 'Female' THEN 1 ELSE 0 END) as female_count")
        //     ->first();

        // $malePercentage = ($genderCounts->male_count / $totalResultCount) * 100;
        // $femalePercentage = ($genderCounts->female_count / $totalResultCount) * 100;

        
        $maleResultCount = SurveyUserResponse::where("survey_id", $survey->id)->whereHas('user', function($query) {
            $query->where('gender', 'Male');
        })->count();

        $femaleResultCount = SurveyUserResponse::where("survey_id", $survey->id)->whereHas('user', function($query) {
            $query->where('gender', 'Female');
        })->count();

        $malePercentage = ($maleResultCount / $totalResultCount) * 100;

        $femalePercentage = ($femaleResultCount / $totalResultCount) * 100;

        

        return response()->json([
            "error" => false,
            "male_percentage" => $malePercentage,
            "female_percentage" => $femalePercentage
        ]);
        
    }

    public function editSurvey (Request $request, Survey $survey) {      
        $title = $request->input('title');
        $duration_of_survey = $request->input('duration_of_survey');
        $points_awarded = $request->input('points_awarded');
        $requestQuestions = $request->input('questions');

        $admin = $request->user('admin');

        $survey->update([
            'title' => $title,
            'duration_of_survey' => $duration_of_survey,
            'points_awarded' => $points_awarded,
        ]);
       

        foreach($requestQuestions as $requestQuestion) {
            if (array_key_exists('id', $requestQuestion)) {
                $question = Question::find($requestQuestion['id']); 
            } else {
                $question = new Question();
                // dump('i ')
            }
            $question->question_text = $requestQuestion['question_text'];
            $question->is_multiple_choice =  $requestQuestion['is_multiple_choice'];
            $question->survey_id = $survey->id;
            // dd($question);

            foreach($requestQuestion['options'] as $requestOption) {
                if (!array_key_exists('id', $requestOption)) {
                    $option  = new Option();
                } else {
                    $option = Option::find($requestOption['id']);

                }                
                $option->question_id = $question->id;
                $option->option_text = $requestOption['option_text'];
                $option->save();
            }

            $question->save();
        }   

        $survey->save();

        event(new AdminSurveyEvent($admin, $survey, "edited"));


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

    public function deleteSurvey(Request $request, Survey $survey) {
        try {
            $admin = $request->user('admin');

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 

            DB::transaction(function() use($survey){
                $survey->delete();

            });


            event(new AdminSurveyEvent($admin, $survey, "deleted"));

            return response()->json([
                "error" => false,
                "message" => "survey successfully deleted"
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function allocatePointToParticipant(Request $request, Survey $survey, $participantId) {
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
                'survey_id' => $survey->id,
            ]);

            $message = "allocated {$points} peace point to {$user->first_name} {$user->last_name} ({$user->peace_id} peace id) for";

            event(new AdminSurveyEvent($admin, $survey, $message));
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

    //////////// move the below to question controller

    public function deleteQuestion(Request $request, Survey $survey, Question $question) {
        try {
            
            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 

            // Use transaction with closure
            DB::transaction(function() use ($question) {
                $question->delete();
            });

            $message = "deleted question ({$question->text}) for ";

            event(new AdminSurveyEvent($admin, $survey, $message));

            return response()->json([
                "error" =>  false,
                "message" => "question delete successfully"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteOption(Request $request, Survey $survey, Question $question, Option $option) {
        try {
            
            $admin = $request->user('admin');
    
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'You are not authorized to carry out this action'
                ], 500);
            } 

            DB::transaction(function() use($option) {
                $option->delete();

            });

            $message = "deleted option ({$option->option_text}) in question {$question->question_text} for ";

            event(new AdminSurveyEvent($admin, $survey, $message));

            return response()->json([
                "error" =>  false,
                "message" => "question delete successfully"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

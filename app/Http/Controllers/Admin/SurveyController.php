<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Option;
use App\Models\Admin\Survey;
use Illuminate\Http\Request;
use App\Models\Admin\Question;
use App\Models\PointAllocation;
use App\Events\AdminSurveyEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\SurveyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SurveyCollection;
use App\Models\Admin\SurveyUserResponse;
use App\Http\Requests\FilterSurveyRequest;
use App\Http\Requests\UpdateSurveyImageRequest;
use App\Http\Requests\Admin\CreateSurveyRequest;


class SurveyController extends Controller
{
    //
    public function createSurvey(CreateSurveyRequest $request) {
        
        try {

            $admin = $request->user('admin');
    
            
            $title = $request->input('title');
            $questions = $request->input('questions');
            $duration_of_survey = $request->input('duration_of_survey');
            $points_awarded = $request->input('points_awarded');  
            $image_url = $request->input('image_url');          
            $is_active = $request->input('is_active');
            $is_published = $request->input('is_published');

            if ($is_active) {
                $activeSurvey = Survey::where('is_active', true)->first();
                // return $activeSurvey;
                if ($activeSurvey) {
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
                'is_published' => $is_published,
                'image_url' => $image_url,
                'end_time' => now()->addMinutes($duration_of_survey)
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
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
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
    
            $survey = Survey::where('is_active', true)->first();
            if ($survey) {
                $survey->is_active = false;
                $survey->is_completed = false;
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
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }
    }


    public function createSurveyBanner(Request $request) {

        try {
            // dd($request->file('image_url'));
            if ($request->file('image_url')) {
                $path = $request->file('image_url')->store('survey-images');
    
                $image_url_link = Storage::url($path);
        
                return response()->json([
                    "error" => false,
                    "image_url" => $path,
                    "image_url_link" => $image_url_link
        
                ], 200);
            }

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }
    }

    public function updateSurveyImage(UpdateSurveyImageRequest $request, Survey $survey) {        
        try {

            Gate::authorize('is-admin');
            $admin = $request->user('admin');

            if ($request->file('image_url')) {
                // store the file in the admin-profile-images folder
                    $file = $request->file('image_url');
                    $path = Storage::disk('cloudinary')->putFile('uploads', $file);
                    $url = Storage::disk('cloudinary')->url($path);
                    // store the path to the image
                    $survey->image_url = $url;

                    $survey->save();

                    event( new AdminSurveyEvent($admin, $survey, "updated banner for"));

                    return response()->json([
                        "error" => false,
                        "message" => "Survey image updated successfully",
                        "image_url_link" => $url
                    ], 200);
               }
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
            ], 500);
        }
        

    }

    public function surveyTable(FilterSurveyRequest $request) {
        try {
          
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $title = $request->input('title');
            // dd(now()->addMinutes(30));
            // return $surveys;    

            Survey::where('is_active', true)
                ->where('end_time', '<=', now()->toDateTimeString())
                ->update([
                    'is_active' => false,
                    'is_completed' => true,
                ]);

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


            
            return response()->json([
                'error' => false,
                'now' => now(),
                'surveys' => $filteredSurveys,
                'surveyTable' => Survey::get()
            ], 200);

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }      

    }


    public function tooglePublishSurvey(Request $request, Survey $survey) {
        try {

            $admin = $request->user('admin');
    
            // if this survey is not published check if there is an active survey
            if (!$survey->is_published) {
                $activeSurvey = Survey::where('is_active', true)->first();
                if ($activeSurvey) {
                    return response()->json([
                        "error" => true,
                        "message" => "A survey is currently active would you like to end and begin a new one"
                    ], 500);
                }

                $survey->is_published = true;
                $survey->is_active = true;
               

                // survey end time;
                $endTime = now()->addMinutes($survey->duration_of_survey);

                $survey->end_time = $endTime;
                
            } else {
                $survey->is_published = false;
                $survey->is_active = false;

            }   

            $survey->is_completed = false;
            $survey->save();


            
            
            

            // $survey->is_published = !$survey->is_published;
            
            // if survey is not published then it is in draft
           
            
             
            $action = $survey->is_published ? 'published' 
                : 'unpublished';
            

            $surveyAll = Survey::get();
            event( new AdminSurveyEvent($admin, $survey, $action));

            return response()->json([
                'error' => false,
                'message' => "survey {$action} successfully",
                'survey' => $survey,
                'survey_table' =>  $surveyAll
            ], 200);

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }

    }

    public function surveyFalse(Survey $survey) {
         
        $survey->is_completed = false;
        $survey->save();
        return $survey;
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

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }
    }


    public function getSurveyResultByGender(Survey $survey) {

        $totalResultCount = SurveyUserResponse::where("survey_id", $survey->id)->count();

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
       try { 
            $title = $request->input('title');
            $duration_of_survey = $request->input('duration_of_survey');
            $points_awarded = $request->input('points_awarded');
            $requestQuestions = $request->input('questions');
            $is_published = $request->input('is_published');
            $is_active = $request->input('is_active');

            $admin = $request->user('admin');        

            if ($is_active) {
                $activeSurvey = Survey::where('is_active', true)->first();
                if ($activeSurvey) {
                    return response()->json([
                        "error" => true,
                        "message" => "A survey is currently active would you like to end and begin a new one"
                    ], 500);
                }

            }

            $survey->update([
                'title' => $title,
                'duration_of_survey' => $duration_of_survey,
                'points_awarded' => $points_awarded,
                'is_active' => $is_active,
                'is_published' => $is_published,
                'is_completed' => false
            ]);
            $survey->is_active = $is_active;
            $survey->save();
        

            foreach($requestQuestions as $requestQuestion) {
                if (array_key_exists('id', $requestQuestion)) {
                    $question = Question::find($requestQuestion['id']); 
                
                    if (!$question) {
                        $question = new Question();
                    }
                } else {
                    $question = new Question();
                    
                    // dump('i ')
                }

                // dd($requestQuestion);
                $question->question_text = $requestQuestion['question_text'];
                $question->is_multiple_choice =  $requestQuestion['is_multiple_choice'];
                $question->survey_id = $survey->id;
                // dd($question);
                $question->save();

                foreach($requestQuestion['options'] as $requestOption) {
                    if (!array_key_exists('id', $requestOption)) {
                        $option  = new Option();
                    } else {
                        $option = Option::find($requestOption['id']);
                        if (!$option) {
                            $option  = new Option();
                        }
                    }                
                    $option->question_id = $question->id;
                    $option->option_text = $requestOption['option_text'];
                    $option->save();
                }

            }   

            $survey->save();

            event(new AdminSurveyEvent($admin, $survey, "edited"));


            $surveyData = $survey->load('questions.options');

            return response()->json([
                    'error' => false,
                    'edited_survey' => $surveyData
                ]
            );

       } catch (\Throwable $th) {
            
        Log::error($th->getMessage());

        return response()->json([
            "error" => true,            
            "message" => "something went wrong"
        ], 500);
    }
        
    
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

            return response()->json([
                'error' => false,
                'surveyData' => $surveyData
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }      

    }

    public function surveyParticipants($surveyId) {
        try {

            $users = User::whereHas('surveyUserResponses', function($query) use($surveyId) {
                        $query->where('survey_id', $surveyId);
                    })->get();

            return response()->json([
                'error' => false,
                'users' => $users
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
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
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
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
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }          
    }

    //////////// move the below to question controller

    public function deleteQuestion(Request $request, Survey $survey, Question $question) {
        try {
            
            Gate::authorize('is-admin');
            $admin = $request->user('admin');
    
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
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function deleteOption(Request $request, Survey $survey, Question $question, Option $option) {
        try {
            Gate::authorize('is-admin');
            $admin = $request->user('admin');
    
            DB::transaction(function() use($option) {
                $option->delete();

            });

            $message = "deleted option ({$option->option_text}) in question {$question->question_text} for ";

            event(new AdminSurveyEvent($admin, $survey, $message));

            return response()->json([
                "error" =>  false,
                "message" => "option delete successfully"
            ]);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
}

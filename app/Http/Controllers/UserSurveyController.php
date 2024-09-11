<?php

namespace App\Http\Controllers;

use App\Models\Admin\Survey;
use Illuminate\Http\Request;
use App\Models\Admin\Question;
use App\Http\Requests\FillSurveyRequest;
use App\Models\Admin\SurveyUserResponse;

class UserSurveyController extends Controller
{
    public function indexSurvey() {
        try {
    

            // $surveys = Survey::whereRaw('DATE_ADD(created_at, INTERVAL duration_of_survey MINUTE) >= ?', [now()])
            // ->with('questions.options') // Eager load questions and their options
            // ->get();

            $surveys = Survey::whereRaw('DATE_ADD(created_at, INTERVAL duration_of_survey MINUTE) >= ?', [now()])
            ->select(['id', 'title', 'is_published','created_at']) // Eager load questions and their options
            ->get();

            return response()->json([
                'error' => false,
                'message' => 'list of surveys',
                'surveys' => $surveys
            ]);
            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function showSurvey($surveyId) {
        try {

            $survey = Survey::where('id', $surveyId)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration_of_survey MINUTE) >= ?', [now()])
                ->with('questions.options')->first();

            return response()->json([
                'error' => false,
                'message' => 'survey data',
                'survey' => $survey
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function fillSurvey(FillSurveyRequest $request) {
        try {
            $survey_id = $request->input('survey_id');
            $user_id = $request->user()->id;
            $responses = $request->input('responses');

            foreach($responses as $response) {
                $questionId = $response['question_id'];

                foreach($response['option_ids'] as $optionId) {
                    SurveyUserResponse::create([
                        'survey_id' => $survey_id,
                        'user_id' => $user_id,
                        'question_id' => $questionId,
                        'option_id' => $optionId
                    ]);
                    
                }
            }



        } catch(\Throwable $th) {
           
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
            
        }

           // Return success response
        return response()->json([
            'error' => false,
            'message' => 'Survey responses saved successfully'
        ], 201);


    }   
}

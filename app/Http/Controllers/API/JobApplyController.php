<?php

namespace App\Http\Controllers\API;

use App\Models\Society;
use App\Models\JobVacancy;
use App\Models\Validation;
use Illuminate\Http\Request;
use App\Models\JobApplySociety;
use App\Models\JobApplyPosition;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class JobApplyController extends Controller
{
    public function jobApply(Request $request){  

        $user = Society::where('login_tokens', $request->token)->first();
        
        $validation = Validation::where('society_id', $user->id)->first();

        if ($validation->status != 'accepted') {
            # code...
            return response()->json([
                'message' => 'Your data validator must be accepted by validator before'
            ], 401);
        }
    
        $reqValidator = Validator::make($request->all(), [
            'vacancy_id' => 'required',
            'positions' => 'required'
        ], [
            'vacancy_id' => 'The vacancy id field is required.',
            'positions' => 'The position field is required.'
        ]);

        if ($reqValidator->fails()) {
            # code...
            return response()->json([
                'message' =>  'invalid field',
                'errors' => $reqValidator->errors()
            ], 401);
        }

        $check = JobApplySociety::where('society_id', $user->id)->first();

        if ($check) {
            # code...
            return response()->json([
                'message' => 'Application for a job can only be once'
            ], 401);
        }

        $jobApplySociety = JobApplySociety::create([
            'notes' => $request->notes,
            'date' => date('Y-m-d'),
            'society_id' => $user->id,
            'job_vacancy_id' => $request->vacancy_id
        ]);

        foreach(json_decode($request->positions) as $position){
            JobApplyPosition::create([
                'date' => date('Y-m-d'),
                'society_id' => $user->id,
                'job_vacancy_id' => $request->vacancy_id,
                'position_id' => $position,
                'job_apply_societies_id' => $jobApplySociety->id
            ]);

        }



        return response()->json([
            'message' => 'Applying for job successful'
        ], 200);
    }


    // Get all of society job applications
    public function societyJobApplication(Request $request){

        $user = Society::where('login_tokens', $request->token)->first(); 

        $vacancy = $user->jobApplies()->with(['vacancy.job_category'])->get()->map(function($jobAppply) {
            $result = $jobAppply->vacancy;
            $result->category = $result->job_category;
            $result->position = $jobAppply->jobApplyPositions->map(function($jobAppplyPosition) use ($jobAppply) {
                return (object) [
                    'position' => $jobAppplyPosition->available_positions->position,
                    'apply_status' => $jobAppplyPosition->status,
                    'notes' => $jobAppply->notes,
                ];
            });
            $result = collect($result)->except(['job_category'])->all();
            return $result;
        });


        return response()->json([
            'vacancies' => $vacancy
        ], 200);
    }
}

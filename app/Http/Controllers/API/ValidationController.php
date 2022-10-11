<?php

namespace App\Http\Controllers\API;

use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;
use App\Helpers\ResponseJSON;
use App\Http\Controllers\Controller;

class ValidationController extends Controller
{
    // Request data validations
    public function requestValidation(Request $request){
        $user = Society::where('login_tokens', $request->token)->first();

        if (!$user) {
            # code...
            return ResponseJSON::unauthorized();
        }

        Validation::create([
            'work_experience' => $request->work_experience,
            'society_id' => $user->id,
            'job_category_id' => $request->job_category_id,
            'job_position' => $request->job_position,
            'reason_accepted' => $request->reason_accepted
        ]);

        return response()->json([
            'message' => 'Request data validation sent successful'
        ], 200);
    }

    // get society validation
    public function getValidation(Request $request){
        $user = Society::where('login_tokens', $request->token)->first();

        if (!$user) {
            # code...
            return ResponseJSON::unauthorized();
        }

        $validation = Validation::where('society_id', $user->id)->with(['job_category', 'validator'])->first();

        if ($validation->job_category != null) {
            # code...
            $validation->category = $validation->job_category;
        }


        return response()->json($validation, 200);
    }
}

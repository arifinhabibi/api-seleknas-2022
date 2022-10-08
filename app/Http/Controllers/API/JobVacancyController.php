<?php

namespace App\Http\Controllers\API;

use App\Models\Society;
use App\Models\JobVacancy;
use App\Models\Validation;
use Illuminate\Http\Request;
use App\Helpers\ResponseJSON;
use App\Http\Controllers\Controller;

class JobVacancyController extends Controller
{
    // Get all job vacancy by chosen job category
    public function getJobVacancy(Request $request){
        $user = Society::where('login_tokens', $request->token)->first();
        if (!$user) {
            # code...
            return ResponseJSON::unathorized();
        }

        $validation = Validation::where('society_id', $user->id)->first();

        $job_vacancies = JobVacancy::where('job_category_id', $validation->job_category_id)->with(['job_category', 'available_position'])->get();
        $job_vacancies->makeHidden(['job_category_id']);

        return response()->json([
            'vacancies' => $job_vacancies
        ], 200);

    }

}

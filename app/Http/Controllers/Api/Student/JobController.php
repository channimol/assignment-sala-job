<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AppliedJob;
use App\Models\Job;

class JobController extends Controller
{
    public function apply()
    { }

    public function bookmark(Request $request)
    {
        $this->validate($request, [
            'job_id' => 'required'
        ]);
        $is_student = $request->user()->hasRole('student');
        if (!$is_student) {
            return 'You cannot applied for this job since you are not a student';
        }
        $applied_jobs = AppliedJob::create([
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
            'status' => 'pending'
        ]);
        return 'applied job successfully';
    }

    public function index()
    {
        $jobs = Job::all();
        return $jobs;
    }
}

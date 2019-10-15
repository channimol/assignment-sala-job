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
        $source_types = [1 => 'Internal', 2 => 'External'];
        $schedule_types = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Internship'];
        $jobs = Job::with('medias', 'publisher')->get();
        foreach ($jobs as $job) {
            if ($job->job_source_id) {
                $job->job_source_id = $source_types[$job->job_source_id];
            }
            if ($job->schedule_type_id) {
                $job->schedule_type_id = $schedule_types[$job->schedule_type_id];
            }
            $job->published_by = $job->publisher->email;
        }
        return $jobs;
        return $jobs;
    }
}

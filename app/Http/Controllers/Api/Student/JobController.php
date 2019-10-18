<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

use App\Models\Job;
use App\Models\User;
use App\Models\Media;
use Exception;

use PDF;

class JobController extends Controller
{
    private $source_types = [1 => 'Internal', 2 => 'External'];
    private $schedule_types = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Internship'];

    public function apply(Request $request)
    {
        try {
            $this->validate($request, [
                'job_id' => 'required'
            ]);
            $is_student = $request->user()->hasRole('student');
            if (!$is_student) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot apply for this job since you are not a student'
                ]);
            }
            $user = $request->user();
            $cv = Media::where([['mediable_type', CV::class], ['mediable_id', $user->id]])->first();
            // $apply = $user->applyJobs()->sync([$request->job_id], false);
            $job = Job::find($request->job_id);
            if ($request->apply_with == 'cv') {
                if (!$cv) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You need to upload cv file first',
                    ]);
                }
            } else {
                $profile = User::with('cv.workExperiences', 'cv.skills', 'cv.languages')->find($user->id);

                $pdf = $this->generatePDF($profile);
                $data = array(
                    'send_to' => $job->contact_email,
                    'title' => $job->title,
                    'attachments' => $pdf->output(),
                    'student' => $user
                );
                $this->sendMail($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'applied job successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not apply job',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function generatePDF($profile)
    {
        $pdf = PDF::loadView('email.cv', array('profile' => $profile));
        return $pdf;
    }

    public function sendMail($data)
    {
        $to = $data["send_to"];
        $title = 'Apply for ' . $data["title"];
        Mail::to($to)
            ->send(new SendMail($data));
    }

    public function bookmark(Request $request)
    {
        try {
            $this->validate($request, [
                'job_id' => 'required'
            ]);
            $is_student = $request->user()->hasRole('student');
            if (!$is_student) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot bookmark for this job since you are not a student'
                ]);
            }
            $user = $request->user();
            $bookmark = $user->bookmarkJobs()->sync([$request->job_id], false);
            return response()->json([
                'success' => true,
                'message' => 'bookmark job successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not bookmark job',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function index(Request $request)
    {
        $jobs = Job::where('title', 'ilike', '%' . $request->search . '%')->with('medias', 'publisher')->paginate(10);
        foreach ($jobs as $job) {
            if ($job->job_source_id) {
                $job->job_source_id = $this->source_types[$job->job_source_id];
            }
            if ($job->schedule_type_id) {
                $job->schedule_type_id = $this->schedule_types[$job->schedule_type_id];
            }
            $job->published_by = $job->publisher->email;
        }
        return $jobs;
    }

    public function listApplied(Request $request)
    {
        try {
            $user = $request->user();
            $applies = $user->applyJobs()->paginate(10);
            foreach ($applies as $apply) {
                if ($apply->job_source_id) {
                    $apply->job_source_id = $this->source_types[$apply->job_source_id];
                }
                if ($apply->schedule_type_id) {
                    $apply->schedule_type_id = $this->schedule_types[$apply->schedule_type_id];
                }
                $apply->published_by = User::select('email')->where('id', $apply->published_by)->get();
            }
            return $applies;
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not get applied list',
                'error' => $e->getMessage()
            ]);
        }
    }
    // $bookmark = $user->bookmarkJobs()->with(['medias']);
    public function listBookmarks(Request $request)
    {
        try {
            $user = $request->user();
            $bookmarks = $user->bookmarkJobs()->paginate(10);
            foreach ($bookmarks as $bookmark) {
                if ($bookmark->job_source_id) {
                    $bookmark->job_source_id = $this->source_types[$bookmark->job_source_id];
                }
                if ($bookmark->schedule_type_id) {
                    $bookmark->schedule_type_id = $this->schedule_types[$bookmark->schedule_type_id];
                }
                $bookmark->published_by = User::select('email')->where('id', $bookmark->published_by)->get();
            }
            return $bookmarks;
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not get bookmark list',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function removeBookmark(Request $request)
    {
        try {
            $user = $request->user();
            $user->bookmarkJobs()->detach($request->job_id);
            return response()->json([
                'success' => true,
                'message' => 'success remove bookmark job',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not remove bookmark',
                'error' => $e->getMessage()
            ]);
        }
    }
}

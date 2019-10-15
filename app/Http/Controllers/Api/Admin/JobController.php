<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use File;
use Auth;

use App\Models\Job;
use App\Models\Media;

class JobController extends Controller
{

    public function show($id)
    {
        try {
            $source_types = [1 => 'Internal', 2 => 'External'];
            $schedule_types = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Internship'];
            $job = Job::with('publisher', 'medias')->find($id);
            if ($job->job_source_id) {
                $job->job_source_id = $source_types[$job->job_source_id];
            }
            if ($job->schedule_type_id) {
                $job->schedule_type_id = $schedule_types[$job->schedule_type_id];
            }
            $job->published_by = $job->publisher->email;
            return $job;
        } catch (Exception $e) {
            return 'could not find job post';
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'published_by' => 'required',
                'title' => 'required',
                'contact_email' => 'required|email'
            ]);
            $job = Job::create($request->except(['photos']));
            if ($request->file('photos')) {
                if (count($request->photos) > 0) {
                    foreach ($request->file('photos') as $file) {
                        $this->uploadFiles($job, $file);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'create job post successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => 'could not create job post',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function uploadFiles($job, $file)
    {
        $original_extension = $file->getClientOriginalExtension();
        $filename = time() . '' . uniqid(rand()) . '.' . $original_extension;
        $storePath = "images/jobs/$filename";
        $contents = File::get($file);
        Storage::disk('public')->put($storePath, $contents);
        Media::create([
            "mediable_type" => Job::class,
            "mediable_id" => $job->id,
            "url" => asset(Storage::url($storePath))
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            $job = Job::find($id);
            if (Auth::user()->id !== $job->published_by) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your does not have the right to update this post'
                ]);
            } else {
                $job->update($request->except(['photos']));
                $oldImages = $request->oldImageIds;
                $medias = Media::where([['mediable_type', Job::class], ['mediable_id', $id]])->get();
                if ($oldImages && count($oldImages) > 0) {
                    for ($i = 0; $i < count($medias); $i++) {
                        $exist = in_array($medias[$i]->id, $oldImages);
                        if (!$exist) {
                            Media::find($medias[$i]->id)->delete();
                        }
                    }
                } else {
                    foreach ($medias as $media) {
                        $media->delete();
                    }
                }
                if ($request->file('photos')) {
                    if (count($request->photos) > 0) {
                        foreach ($request->file('photos') as $file) {
                            $this->uploadFiles($job, $file);
                        }
                    }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'update job post successfully'
                ]);
            }
        } catch (Exception $e) {
            return 'cannot update this job post';
        }
    }

    public function delete($id)
    {
        try {
            $job = Job::find($id);
            $job->delete();
            return response()->json([
                'success' => true,
                'message' => 'delete job post successfully'
            ]);
        } catch (Exception $e) {
            return "error " . $e->getMessage();
        }
    }

    public function getListJobs(Request $request)
    {
        $source_types = [1 => 'Internal', 2 => 'External'];
        $schedule_types = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Internship'];
        $user = Auth::user()->id;
        $jobs = Job::where('published_by', $user)->with('publisher', 'medias')->get();
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
    }
}

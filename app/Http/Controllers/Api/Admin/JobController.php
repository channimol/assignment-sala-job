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
            return Job::with('publisher', 'medias')->find($id);
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

            return 'create job post successfully';
        } catch (Exception $e) {
            return 'could not create job post';
        }
    }
    public function uploadFiles($job, $file)
    {
        $original_extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $original_extension;
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
            if ($job) {
                if (Auth::user() !== $job->published_by) {
                    throw 'Your does not have the right to update this post';
                } else {
                    $job->update($request->except(['photos']));
                    return $job;
                }
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
        } catch (Exception $e) {
            return "error " . $e;
        }
    }

    public function getListJobs()
    {
        $user = Auth::user()->id;
        $jobs = Job::where('published_by', $user)->with('publisher', 'medias')->get();
        return $jobs;
    }
}

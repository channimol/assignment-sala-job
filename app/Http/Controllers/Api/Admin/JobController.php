<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use File;
use Auth;

use App\Models\Job;

class JobController extends Controller
{
    public function index() {
        return view('admin.jobs.list');
    }
    
    public function create() {
        return view('admin.jobs.create');
    }

    public function view() {
        return view('admin.jobs.show');
    }

    public function edit() {
        return view('admin.jobs.create');
    }

    public function show($id) {
        try {
            $job = Job::find($id);
            if ($job) {
                return $job->with('users', 'medias')->first();
            }
        } catch(Exception $e) {
            return 'could not find job post';
        }
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'published_by' => 'required',
                'title' => 'required'
            ]);

            $job = Job::create($request->except(['photos']));

            if ($request->file('photos')) {
                foreach ($request->file('photos') as $file){
                    print_r($file);
                    $original_extension = $file->getClientOriginalExtension();
                    $filename = time() . '.'. $original_extension;
                    $storePath = "images/jobs/$filename";
                    $contents = File::get($file);
                    Storage::disk('public')->put($storePath, $contents);
                    
                    Media::create([
                        "mediable_type" => Job::class,
                        "mediable_id" => $job->id,
                        "url" => asset(Storage::url($storePath))
                    ]);
                }
            }
            return $job;

            return 'create job post successfully';
        } catch(Exception $e) {
            return 'could not create job post';
        }
    }

    public function update(Request $request, $id) {
        try {
            $job = Job::find($id);
            if ($job) {
                $job->update($request->all());
                return $job;
            }

        } catch(Exception $e) {
            return 'cannot update this job post';
        }
    }

    public function delete($id) {
        try {
            $job = Job::find($id);
            $job->delete();
        } catch(Exception $e) {
            return "error ". $e;
        }
    }

    public function getListJobs() {
        $user = Auth::user()->id;
        $jobs = Job::where('published_by', $user)->with('roles', 'department', 'media')->get();

        return $jobs;
    }
}

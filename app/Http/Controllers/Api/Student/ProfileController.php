<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Auth;
use App\Models\User;
use App\Models\CV;
use App\Models\Skill;
use Exception;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = User::with('cv.workExperiences', 'cv.skills', 'cv.languages')->find($user->id);
        return $profile;
    }

    public function uploadCV(Request $request)
    {
        $file = $request->file;
        $original_extension = $file->getClientOriginalExtension();
        $filename = time() . '' . uniqid(rand()) . '.' . $original_extension;
        $storePath = "file/cv/$filename";
        $contents = File::get($file);
        Storage::disk('public')->put($storePath, $contents);
        Media::create([
            "mediable_type" => CV::class,
            "mediable_id" => Auth::user()->id,
            "url" => asset(Storage::url($storePath))
        ]);
    }

    public function updateWorkExperience(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'company' => 'required',
                'start_date' => 'required',
                'end_date' => "required",
                'description' => 'required',
                'references' => 'required'
            ]);
            $role = Auth::user()->getRoleNames();
            $cv = Auth::user()->cv;
            if (!$cv) {
                $create_cv = CV::create([
                    "user_id" => Auth::user()->id,
                    "description" => null
                ]);
                $user_cv = $create_cv->id;
            } else {
                $user_cv = $cv->id;
            }
            if ($role[0] == 'student') {
                if (isset($request->id)) {
                    $id = Experience::find($request->id);
                    $experience = $id->update([
                        'title' => $request->title,
                        'company' => $request->company,
                        'location' => $request->location,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'description' => $request->description,
                        'references' => $request->references
                    ]);
                } else {
                    $experience = Experience::create([
                        "cv_id" => $user_cv,
                        'title' => $request->title,
                        'company' => $request->company,
                        'location' => $request->location,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'description' => $request->description,
                        'references' => $request->references
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'success update profile'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'requested user doesnt have profile to update'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not update user experience',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function updateBasicInformation(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required'
            ]);
            $role = Auth::user()->getRoleNames();
            $cv = Auth::user()->cv;
            if (!$cv) {
                $create_cv = CV::create([
                    "user_id" => Auth::user()->id,
                    "description" => null
                ]);
                $user_cv = $create_cv->id;
            } else {
                $user_cv = $cv->id;
            }
            if ($role[0] == 'student') {
                $user = User::find(Auth::user()->id);
                $info = $user->update([
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]);
                if (isset($request->description)) {
                    $description = CV::find($user_cv)->update([
                        'description' => $request->description
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'success update profile'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'requested user doesnt have profile to update'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not update user experience',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function updateSkills(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'level' => 'required'
            ]);
            $role = Auth::user()->getRoleNames();
            $cv = Auth::user()->cv;
            if (!$cv) {
                $create_cv = CV::create([
                    "user_id" => Auth::user()->id,
                    "description" => null
                ]);
                $user_cv = $create_cv->id;
            } else {
                $user_cv = $cv->id;
            }
            if ($role[0] == 'student') {
                if (isset($request->id)) {
                    $id = Skill::find($request->id);
                    $info = $id->update([
                        'name' => $request->name,
                        'level' => $request->level,
                        'cv_id' => $user_cv,
                    ]);
                } else {
                    $info = Skill::create([
                        'name' => $request->name,
                        'level' => $request->level,
                        'cv_id' => $user_cv,
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'success update profile'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'requested user doesnt have profile to update'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not update user skill',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function updateLanguage(Request $request)
    {
        try {
            $this->validate($request, [
                'language_id' => 'required',
                'level' => 'required'
            ]);
            $role = Auth::user()->getRoleNames();
            $cv = Auth::user()->cv;
            if (!$cv) {
                $create_cv = CV::create([
                    "user_id" => Auth::user()->id,
                    "description" => null
                ]);
                $user_cv = $create_cv->id;
            } else {
                $user_cv = $cv->id;
            }
            if ($role[0] == 'student') {
                $id = CV::find($user_cv);

                $language = $id->languages()->sync([$request->language_id => ['level' => $request->level]], false);
                return response()->json([
                    'success' => true,
                    'message' => 'success update profile'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'requested user doesnt have profile to update'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not update user language',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function removeSkill($id)
    {
        try {
            $skill = Skill::find($id);
            $skill->delete();
            return response()->json([
                'success' => true,
                'message' => 'success delete user skill',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not delete user skill',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function removeLanguage($id)
    {
        try {
            $cv = Auth::user()->cv;
            $cv->languages()->detach($id);
            return response()->json([
                'success' => true,
                'message' => 'success delete user language',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'could not delete user skill',
                'error' => $e->getMessage()
            ]);
        }
    }
}

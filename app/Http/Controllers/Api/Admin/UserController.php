<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Media;
use App\Models\CV;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function show($id)
    {
        try {
            return User::with('roles', 'department', 'media')->find($id);
        } catch (Exception $e) {
            return 'could not find user';
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $request['password'] = bcrypt($request->password);
            $user = User::create($request->except(['photo']));
            CV::create([
                "user_id" => $user->id,
                "description" => ""
            ]);
            $user->syncRoles($request->roles);

            if (count($user->roles) == 0) {
                $role_student = Role::select('name')->where('name', 'student')->first();
                $user->syncRoles($role_student->name);
            }

            if ($request->hasfile('photo')) {
                $this->uploadFile($user, $request);
            }

            return 'create user successfully';
        } catch (Exception $e) {
            return 'could not create user';
        }
    }

    public function uploadFile($user, $request)
    {
        $file = $request->photo;
        $original_extension = $request->file('photo')->getClientOriginalExtension();
        $filename = time() . '.' . $original_extension;
        $storePath = "images/users/$filename";
        $contents = File::get($file);
        Storage::disk('public')->put($storePath, $contents);

        Media::create([
            "mediable_type" => User::class,
            "mediable_id" => $user->id,
            "url" => asset(Storage::url($storePath))
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->update($request->all());
                $user->syncRoles($request->roles);

                if ($request->hasfile('photo')) {
                    $this->uploadFile($user, $request);
                }
                return $user;
            }
        } catch (Exception $e) { }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
        } catch (Exception $e) {
            return "error " . $e;
        }
    }

    public function getListUsers()
    {

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'administrator');
        })->with('roles', 'department', 'media', 'cv')->get();

        return $users;
    }
}

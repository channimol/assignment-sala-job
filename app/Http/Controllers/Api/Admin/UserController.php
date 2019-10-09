<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Media;
use App\Models\Role;

class UserController extends Controller
{
    public function show($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return $user->with('roles', 'department', 'media')->first();
            }
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
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            $request['password'] = bcrypt($request->password);
            $user = User::create($request->except(['photo']));

            if (count($user->roles) == 0) {
                $role_student = Role::select('id')->where('name', 'student')->first();
                $user->roles()->attach($role_student);
            }

            $file = $request->photo;

            if ($request->hasfile('photo')) {
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

            return 'create user successfully';
        } catch (Exception $e) {
            return 'could not create user';
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->update($request->all());
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
        })->with('roles', 'department', 'media')->get();

        return $users;
    }
}

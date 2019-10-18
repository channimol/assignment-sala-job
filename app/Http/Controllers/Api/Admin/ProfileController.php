<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   public function getProfile()
   { }
   public function updateBasicInformation(Request $request)
   {
      try {
         $this->validate($request, [
            'email' => 'required'
         ]);
         $role = Auth::user()->getRoleNames();
         if ($role[0] == 'admin') {
            $user = User::find(Auth::user()->id);
            $user->update([
               'phone' => $request->phone,
               'email' => $request->email,
            ]);
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
            'message' => 'could not update user profile',
            'error' => $e->getMessage()
         ]);
      }
   }
   public function resetPassword(Request $request)
   {
      try {
         $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:3|confirmed'
         ]);
         try {
            $user = $request->user();
            if (Hash::check($request['old_password'], $user->password)) {
               $user->update([
                  'password' => bcrypt($request['password'])
               ]);
               return response()->json([
                  'success' => true,
                  'message' => 'success reset password'
               ]);
            } else {
               return response()->json([
                  'success' => false,
                  'message' => 'could not reset password',
               ]);
            }
         } catch (\Exception $e) {
            // DB::rollback();
            return response()->json([
               'success' => false,
               'message' => 'could not reset password',
            ]);
         }
      } catch (ValidationException $e) {
         return validation_message($e);
      }
   }
}

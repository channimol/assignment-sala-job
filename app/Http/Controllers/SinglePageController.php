<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SinglePageController extends Controller
{
  public function index()
  {
    return view('app');
    // $profile = User::with('cv.workExperiences', 'cv.skills', 'cv.languages')->find(3);
    // return view('email.cv', compact('profile'));
  }
}

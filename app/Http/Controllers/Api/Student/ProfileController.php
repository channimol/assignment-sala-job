<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return Auth::user();
    }
}

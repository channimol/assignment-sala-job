<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function uploadImage(Request $r)
    { }
}

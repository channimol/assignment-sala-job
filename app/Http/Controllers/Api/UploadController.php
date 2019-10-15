<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadFileTrait;

class UploadController extends Controller
{
    use UploadFileTrait;
}

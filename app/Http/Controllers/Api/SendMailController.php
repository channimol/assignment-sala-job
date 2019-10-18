<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendMailController extends Controller
{
    public function sendMail()
    {
        $attachments = 'https://image.shutterstock.com/image-photo/bright-spring-view-cameo-island-260nw-1048185397.jpg';

        $data = array(
            "name" => "student name",
            "email" => "student email",
            "attachments" => $attachments
        );
        Mail::to('nimolsc@gmail.com')
            ->subject('Apply for')
            ->send(new SendMail($data));
        // Mail::send('email.mail', $data, function ($message) use ($cv) {
        //     $message->to('nimolsc@gmail.com', 'nimolSC')->subject('sending with attachment');
        //     $message->attach($cv);
        //     $message->from(config('mail.username'), 'sender mail');
        // });
    }
}

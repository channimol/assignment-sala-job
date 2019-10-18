<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        // dd($this->data);
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullname = $this->data['student']->first_name . ' ' . $this->data['student']->last_name;
        $phone = $this->data['student']->phone;
        $email = $this->data['student']->email;
        $job_title = $this->data["title"];

        $mail = $this->from(config('mail.username'), 'SALA JOB')
            ->subject($this->data["title"])
            ->view('email.mail')->with([
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'job_title' => $job_title,
            ])->attachData($this->data["attachments"], "curriculumn.pdf");
        // foreach ($this->data["attachments"] as $filePath) {
        //     $mail->attach($filePath);
        // }

        return $mail;
        // ->attach($this->data["cv"], [
        //     'as' => 'name.pdf',
        //     'mime' => 'application/pdf',
        // ]);;
    }
}

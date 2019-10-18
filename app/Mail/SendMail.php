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
        $isCv = $this->data["isCV"];

        $mail = $this->from(config('mail.username'), 'SALA JOB')
            ->subject($this->data["title"])
            ->view('email.mail')->with([
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'job_title' => $job_title,
            ]);
        if ($isCv) {
            $mail->attach($this->data["attachments"], [
                'as' => 'curriculumn.pdf',
                'mime' => 'application/pdf',
            ]);
        } else {
            $mail->attachData($this->data["attachments"], "curriculumn.pdf");
        }
        return $mail;
    }
}

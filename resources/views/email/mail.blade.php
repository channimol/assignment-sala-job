<p>Dear Mr./Mrs,</p>


<p>On behalf our student, {{$fullname}} has come accross your company job annoucement which on spreading in our school website and {{$fullname}} is interested in applying for the position {{$job_title}} and have sent his curriculumn vitae via our system. </p>
<p>
    Here are his contact information and attachment below:
    <ul>
        <li>Name: {{$fullname}}</li>
        <li>Email: {{$email}}</li>
        @if($phone)
        <li>Phone: {{$phone}}</li>
        @endif
    </ul>
</p>

Best regards,

SALA JOB

{{-- <img src="{{$message->embed($cv)}}"> --}}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmissionMail;


class MailController extends Controller
{
    public function sendEmail($email) {

        $details = [
            'title' => "Submisi baru",
            "body" => "Terimakasih telah mensubmisikan karyamu di ganffest 2022! Ikuti terus media sosial ganffest untuk info terupdate."
        ];

        Mail::to($email)->send(new SubmissionMail($details));
        return "Email sent";
    }
}

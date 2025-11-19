<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendEmail;

class SendEmailController extends Controller
{
    public function index()
    {
        $content = [
            'name' => 'Ini Nama Pengirim',
            'subject' => 'Ini subject email',
            'body' => 'Ini isi body email'
        ];

        Mail::to('6132314j@gmail.com')->send(new SendEmail($content));

        return "Email berhasil dikirim.";
    }
}


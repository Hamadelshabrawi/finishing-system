<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CustomerMail;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function contact(){
        $data = [
            'subject' => 'Test Subject',
            'body' => 'Message from customer',
            'path' => 'test.pdf' 
        ];
        Mail::to('hamadelshabrawi@gmail.com')->send(new CustomerMail($data));
        return 'Email Sent';
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Send Email')->only(['create', 'send']);
    }
    
    public function create()
    {
        return view('emails.email_form');
    }

    public function send(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'attachments.*' => 'file|max:10240',
        ]);
    
        $attachments = $request->file('attachments', []);
        $file = $request->file('attachments');
        $file = is_array($file) ? $file[0] : $file;
    
        Mail::to($request->to)->send(new SendEmail($request->subject, $request->message, $file));
    
        return back()->with('success', 'Email sent successfully!');
    }
    
    
    
}

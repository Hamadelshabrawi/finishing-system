<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Project; // Assuming you have a Project model

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Send Email')->only(['create', 'send']);
    }
    
    public function create(Request $request)
    {
        // If coming from a project, load project data
        $projectId = $request->input('project_id');
        $project = Project::with('client', 'files')->find($projectId);
        return view('emails.email_form', compact('project'));
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
        
        // If coming from a project, attach project files
        $projectId = $request->input('project_id');
        $projectFiles = [];
        
        if ($projectId) {
            $project = Project::with('files')->find($projectId);
            if ($project) {
                $projectFiles = $project->files;
            }
        }

        Mail::to($request->to)->send(new SendEmail(
            $request->subject, 
            $request->message, 
            array_merge($attachments, $projectFiles)
        ));
    
        return back()->with('success', 'Email sent successfully!');
    }
}
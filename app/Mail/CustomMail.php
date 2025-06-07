<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class CustomMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $attachments;

    public function __construct($subjectText, $bodyText, $attachments = [])
    {
        $this->subjectText = $subjectText;
        $this->bodyText = $bodyText;
        $this->attachments = $attachments; // no wrapping needed
    }
    

    protected function storeAttachments($attachments)
    {
        $storedAttachments = [];
        
        foreach ($attachments as $attachment) {
            $path = 'email-attachments/' . uniqid() . '_' . $attachment['name'];
            
            // Store the file in a permanent location
            Storage::put($path, file_get_contents($attachment['path']));
            
            $storedAttachments[] = [
                'storage_path' => Storage::path($path),
                'name' => $attachment['name'],
                'mime' => $attachment['mime']
            ];
        }
        
        return $storedAttachments;
    }

    public function build()
    {
        $email = $this->subject($this->subject)
                     ->view('emails.template')
                     ->with(['content' => $this->content]);
        
        foreach ($this->attachments as $attachment) {
            $email->attach($attachment['storage_path'], [
                'as' => $attachment['name'],
                'mime' => $attachment['mime']
            ]);
        }
        
        return $email;
    }
    
    public function __destruct()
    {
        foreach ($this->attachments as $attachment) {
            if (file_exists($attachment['storage_path'])) {
                unlink($attachment['storage_path']);
            }
        }
    }
}
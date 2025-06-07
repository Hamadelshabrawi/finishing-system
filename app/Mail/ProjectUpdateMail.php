<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProjectUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $existingAttachments;
    public $newAttachments;

    public function __construct($subject, $body, $existingAttachments, $newAttachments)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->existingAttachments = $existingAttachments;
        $this->newAttachments = $newAttachments;
    }

    public function build()
    {
        $email = $this->subject($this->subject)
                     ->html($this->body);
    
        // Attach existing files
        foreach ($this->existingAttachments as $filePath) {
            try {
                // Try public disk first
                if (Storage::disk('public')->exists($filePath)) {
                    $email->attachFromStorageDisk('public', $filePath, basename($filePath));
                }
                // Try default disk if not found in public
                elseif (Storage::exists($filePath)) {
                    $email->attachFromStorage($filePath, basename($filePath));
                }
                else {
                    Log::warning("Attachment not found: " . $filePath);
                }
            } catch (\Exception $e) {
                Log::error("Failed to attach file: " . $e->getMessage());
            }
        }
    
        // Attach new uploads
        foreach ($this->newAttachments as $file) {
            $email->attach($file['path'], [
                'as' => $file['name'],
                'mime' => $file['mime']
            ]);
        }
    
        return $email;
    }
}

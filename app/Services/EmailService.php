<?php

namespace App\Services;

use App\Mail\CustomMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    public function sendEmail($recipients, $subject, $content, $attachments = null)
    {
        try {
            // Normalize recipients to array
            $recipients = $this->normalizeRecipients($recipients);
            
            // Process attachments
            $processedAttachments = $this->processAttachments($attachments);
            
            // Send emails
            $this->sendEmails($recipients, $subject, $content, $processedAttachments);

            return ['success' => true, 'message' => 'Email sent successfully'];
        } catch (\Exception $e) {
            \Log::error('Error sending email: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    protected function normalizeRecipients($recipients)
    {
        if (is_string($recipients)) {
            return array_map('trim', explode(',', $recipients));
        }
        
        if (is_array($recipients)) {
            return array_map('trim', $recipients);
        }
        
        throw new \InvalidArgumentException('Recipients must be a string or array');
    }
    
    protected function processAttachments($attachments)
    {
        $processed = [];
        
        if (empty($attachments)) {
            return $processed;
        }
        
        if (!is_array($attachments)) {
            $attachments = [$attachments];
        }
        
        foreach ($attachments as $attachment) {
            if ($attachment instanceof \Illuminate\Http\UploadedFile) {
                $processed[] = [
                    'path' => $attachment->getRealPath(),
                    'name' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType()
                ];
            } else {
                Log::warning('Invalid attachment format', ['attachment' => $attachment]);
            }
        }
        
        return $processed;
    }
    
    protected function sendEmails($recipients, $subject, $content, $attachments)
    {
        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new CustomMail($subject, $content, $attachments));
        }
    }
}
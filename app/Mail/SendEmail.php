<?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Http\UploadedFile;

// class SendEmail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $subjectText;
//     public $bodyText;
//     public $attachments;

//     public function __construct($subjectText, $bodyText, $attachments = [])
//     {
//         $this->subjectText = $subjectText;
//         $this->bodyText = $bodyText;
    
//         // Normalize: if single UploadedFile passed, wrap it in array
//         if ($attachments instanceof \Illuminate\Http\UploadedFile) {
//             $this->attachments = [$attachments];
//         } elseif (is_array($attachments)) {
//             $this->attachments = $attachments;
//         } else {
//             $this->attachments = [];
//         }
//     }
//     public function build()
//     {
//         $email = $this->subject($this->subjectText)
//                       ->view('emails.general')
//                       ->with(['bodyText' => $this->bodyText]);
    
//         foreach ($this->attachments as $file) {
//             $email->attach($file->getRealPath(), [
//                 'as' => $file->getClientOriginalName(),
//                 'mime' => $file->getMimeType(),
//             ]);
//         }
    
//         return $email;
//     }
    
    
// }


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('codersbase@gmail.com'),
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.customer-email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->data['path'])
        ];
    }
}
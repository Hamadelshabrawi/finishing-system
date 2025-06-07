<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'recipients' => 'required|string',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'attachments.*' => 'file|max:10240',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'recipients' => is_array($this->recipients) 
                ? implode(',', $this->recipients) 
                : $this->recipients
        ]);
    }
}
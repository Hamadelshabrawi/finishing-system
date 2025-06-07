<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigRequest extends FormRequest
{
    public function rules()
    {
        return [
            'MAIL_MAILER' => 'required|string',
            'MAIL_HOST' => 'required|string',
            'MAIL_PORT' => 'required|numeric',
            'MAIL_USERNAME' => 'required|string',
            'MAIL_PASSWORD' => 'required|string',
            'MAIL_ENCRYPTION' => 'nullable|string',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_FROM_NAME' => 'required|string',
        ];
    }
}
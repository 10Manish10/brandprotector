<?php

namespace App\Http\Requests;

use App\Models\EmailTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmailTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_template_edit');
    }

    public function rules()
    {
        return [
            'subject' => [
                'string',
                'min:3',
                'max:255',
                'required',
            ],
            'email_body' => [
                'required',
            ],
            'priority' => [
                'required',
            ],
            'clients.*' => [
                'integer',
            ],
            'clients' => [
                'required',
                'array',
            ],
            'from_email' => [
                'required',
            ],
            'to_email' => [
                'required',
            ],
            'channels.*' => [
                'integer',
            ],
            'channels' => [
                'array',
            ],
        ];
    }
}

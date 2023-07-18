<?php

namespace App\Http\Requests;

use App\Models\Client;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('client_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'max:30',
                'required',
            ],
            'email' => [
                'required',
                'unique:clients',
            ],
            'logo' => [
                'required',
            ],
            'channels.*' => [
                'integer',
            ],
            'channels' => [
                'required',
                'array',
            ],
            'keywords' => [
                'required',
            ],
            'website' => [
                'string',
                'min:10',
                'max:80',
                'nullable',
            ],
            'brand_name' => [
                'string',
                'max:30',
                'required',
            ],
            'social_handle' => [
                'string',
                'nullable',
            ],
            'company_name' => [
                'string',
                'min:3',
                'max:50',
                'required',
                'unique:clients',
            ],
        ];
    }
}

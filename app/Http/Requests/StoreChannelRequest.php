<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_create');
    }

    public function rules()
    {
        return [
            'channel_name' => [
                'string',
                'min:3',
                'max:25',
                'required',
                'unique:channels',
            ],
            'subscription_plans.*' => [
                'integer',
            ],
            'subscription_plans' => [
                'required',
                'array',
            ],
        ];
    }
}

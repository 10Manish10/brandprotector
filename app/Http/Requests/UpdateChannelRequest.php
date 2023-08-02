<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_edit');
    }

    public function rules()
    {
        return [
            'channel_name' => [
                'string',
                'min:3',
                'max:25',
                'required',
                'unique:channels,channel_name,' . request()->route('channel')->id,
            ],
            'variables' => [
                'string',
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

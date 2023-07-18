<?php

namespace App\Http\Requests;

use App\Models\Subscription;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'max:20',
                'required',
                'unique:subscriptions,name,' . request()->route('subscription')->id,
            ],
            'plan_amount' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'array',
            ],
        ];
    }
}

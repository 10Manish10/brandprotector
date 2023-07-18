<?php

namespace App\Http\Requests;

use App\Models\Subscription;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscriptions,id',
        ];
    }
}

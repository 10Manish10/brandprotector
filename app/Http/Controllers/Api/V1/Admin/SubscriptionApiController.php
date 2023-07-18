<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\Admin\SubscriptionResource;
use App\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionResource(Subscription::with(['roles'])->get());
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->all());
        $subscription->roles()->sync($request->input('roles', []));

        return (new SubscriptionResource($subscription))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Subscription $subscription)
    {
        abort_if(Gate::denies('subscription_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionResource($subscription->load(['roles']));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->all());
        $subscription->roles()->sync($request->input('roles', []));

        return (new SubscriptionResource($subscription))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Subscription $subscription)
    {
        abort_if(Gate::denies('subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

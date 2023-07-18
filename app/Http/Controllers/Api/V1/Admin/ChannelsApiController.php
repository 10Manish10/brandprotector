<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Http\Resources\Admin\ChannelResource;
use App\Models\Channel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChannelResource(Channel::with(['subscription_plans'])->get());
    }

    public function store(StoreChannelRequest $request)
    {
        $channel = Channel::create($request->all());
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return (new ChannelResource($channel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChannelResource($channel->load(['subscription_plans']));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->all());
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return (new ChannelResource($channel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Channel $channel)
    {
        abort_if(Gate::denies('channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

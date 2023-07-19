<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\Channel;
use App\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = Channel::with(['subscription_plans'])->get();

        $subscriptions = Subscription::get();

        return view('frontend.channels.index', compact('channels', 'subscriptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription_plans = Subscription::pluck('name', 'id');

        return view('frontend.channels.create', compact('subscription_plans'));
    }

    public function store(StoreChannelRequest $request)
    {
        $channel = Channel::create($request->all());
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return redirect()->route('frontend.channels.index');
    }

    public function edit(Channel $channel)
    {
        abort_if(Gate::denies('channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription_plans = Subscription::pluck('name', 'id');

        $channel->load('subscription_plans');

        return view('frontend.channels.edit', compact('channel', 'subscription_plans'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->all());
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return redirect()->route('frontend.channels.index');
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->load('subscription_plans', 'channelsClients');

        return view('frontend.channels.show', compact('channel'));
    }

    public function destroy(Channel $channel)
    {
        abort_if(Gate::denies('channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->delete();

        return back();
    }

    public function massDestroy(MassDestroyChannelRequest $request)
    {
        $channels = Channel::find(request('ids'));

        foreach ($channels as $channel) {
            $channel->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

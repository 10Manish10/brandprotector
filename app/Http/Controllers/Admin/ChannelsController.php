<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\Channel;
use App\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ChannelsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Channel::with(['subscription_plans'])->select(sprintf('%s.*', (new Channel)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'channel_show';
                $editGate      = 'channel_edit';
                $deleteGate    = 'channel_delete';
                $crudRoutePart = 'channels';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('channel_name', function ($row) {
                return $row->channel_name ? $row->channel_name : '';
            });
            $table->editColumn('subscription_plan', function ($row) {
                $labels = [];
                foreach ($row->subscription_plans as $subscription_plan) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $subscription_plan->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'subscription_plan']);

            return $table->make(true);
        }

        $subscriptions = Subscription::get();

        return view('admin.channels.index', compact('subscriptions'));
    }

    public function create()
    {
        abort_if(Gate::denies('channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription_plans = Subscription::pluck('name', 'id');

        return view('admin.channels.create', compact('subscription_plans'));
    }

    public function store(StoreChannelRequest $request)
    {
        $data = $request->all();
        $names = $data['var']['name'];
        $datatypes = $data['var']['datatype'];
        $temp = array();
        for ($i = 0; $i < $data['rows']; $i++) { 
            $temp[] = array(
                'name' => $names[$i],
                'datatype' => $datatypes[$i],
            );
        }
        unset($data['var']);
        unset($data['rows']);
        $data['variables'] = serialize($temp);

        $channel = Channel::create($data);
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return redirect()->route('admin.channels.index');
    }

    public function edit(Channel $channel)
    {
        abort_if(Gate::denies('channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription_plans = Subscription::pluck('name', 'id');

        $channel->load('subscription_plans');

        return view('admin.channels.edit', compact('channel', 'subscription_plans'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $data = $request->all();
        $names = $data['var']['name'];
        $datatypes = $data['var']['datatype'];
        $temp = array();
        for ($i = 0; $i < $data['rows']; $i++) { 
            $temp[] = array(
                'name' => $names[$i],
                'datatype' => $datatypes[$i],
            );
        }
        unset($data['var']);
        unset($data['rows']);
        $data['variables'] = serialize($temp);

        $channel->update($data);
        $channel->subscription_plans()->sync($request->input('subscription_plans', []));

        return redirect()->route('admin.channels.index');
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->load('subscription_plans');

        return view('admin.channels.show', compact('channel'));
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

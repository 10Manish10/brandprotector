<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionRequest;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Role;
use App\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Subscription::with(['roles'])->select(sprintf('%s.*', (new Subscription)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'subscription_show';
                $editGate      = 'subscription_edit';
                $deleteGate    = 'subscription_delete';
                $crudRoutePart = 'subscriptions';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('plan_amount', function ($row) {
                return $row->plan_amount ? $row->plan_amount : '';
            });
            $table->editColumn('role', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'role']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('admin.subscriptions.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.subscriptions.create', compact('roles'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create($request->all());
        $subscription->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.subscriptions.index');
    }

    public function edit(Subscription $subscription)
    {
        abort_if(Gate::denies('subscription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $subscription->load('roles');

        return view('admin.subscriptions.edit', compact('roles', 'subscription'));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->all());
        $subscription->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.subscriptions.index');
    }

    public function show(Subscription $subscription)
    {
        abort_if(Gate::denies('subscription_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->load('roles', 'subscriptionPlanChannels');

        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function destroy(Subscription $subscription)
    {
        abort_if(Gate::denies('subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscription->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionRequest $request)
    {
        $subscriptions = Subscription::find(request('ids'));

        foreach ($subscriptions as $subscription) {
            $subscription->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

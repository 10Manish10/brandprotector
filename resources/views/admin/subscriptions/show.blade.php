@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subscription.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscriptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subscription.fields.id') }}
                        </th>
                        <td>
                            {{ $subscription->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscription.fields.name') }}
                        </th>
                        <td>
                            {{ $subscription->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscription.fields.plan_amount') }}
                        </th>
                        <td>
                            {{ $subscription->plan_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscription.fields.features') }}
                        </th>
                        <td>
                            {{ $subscription->features }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscription.fields.role') }}
                        </th>
                        <td>
                            @foreach($subscription->roles as $key => $role)
                                <span class="label label-info">{{ $role->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscriptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#subscription_plan_channels" role="tab" data-toggle="tab">
                {{ trans('cruds.channel.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="subscription_plan_channels">
            @includeIf('admin.subscriptions.relationships.subscriptionPlanChannels', ['channels' => $subscription->subscriptionPlanChannels])
        </div>
    </div>
</div>

@endsection
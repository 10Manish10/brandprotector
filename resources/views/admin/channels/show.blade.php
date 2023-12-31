@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.channel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.id') }}
                        </th>
                        <td>
                            {{ $channel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.channel_name') }}
                        </th>
                        <td>
                            {{ $channel->channel_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Channel Variables
                        </th>
                        <td>
                            <ul style="margin:0;">
                                @php
                                    $vars = unserialize($channel->variables);
                                @endphp
                                @foreach ($vars as $var)
                                <li>
                                    <b>Name:</b> {{ $var['name'] }} | <b>Type:</b> {{ $var['datatype'] }}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.subscription_plan') }}
                        </th>
                        <td>
                            @foreach($channel->subscription_plans as $key => $subscription_plan)
                                <span class="label label-info">{{ $subscription_plan->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
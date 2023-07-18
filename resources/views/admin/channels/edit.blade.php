@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.channel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.channels.update", [$channel->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="channel_name">{{ trans('cruds.channel.fields.channel_name') }}</label>
                <input class="form-control {{ $errors->has('channel_name') ? 'is-invalid' : '' }}" type="text" name="channel_name" id="channel_name" value="{{ old('channel_name', $channel->channel_name) }}" required>
                @if($errors->has('channel_name'))
                    <span class="text-danger">{{ $errors->first('channel_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.channel_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="subscription_plans">{{ trans('cruds.channel.fields.subscription_plan') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('subscription_plans') ? 'is-invalid' : '' }}" name="subscription_plans[]" id="subscription_plans" multiple required>
                    @foreach($subscription_plans as $id => $subscription_plan)
                        <option value="{{ $id }}" {{ (in_array($id, old('subscription_plans', [])) || $channel->subscription_plans->contains($id)) ? 'selected' : '' }}>{{ $subscription_plan }}</option>
                    @endforeach
                </select>
                @if($errors->has('subscription_plans'))
                    <span class="text-danger">{{ $errors->first('subscription_plans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.subscription_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
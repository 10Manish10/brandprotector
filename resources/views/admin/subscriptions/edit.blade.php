@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.subscription.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.subscriptions.update", [$subscription->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.subscription.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $subscription->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscription.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="plan_amount">{{ trans('cruds.subscription.fields.plan_amount') }}</label>
                <input class="form-control {{ $errors->has('plan_amount') ? 'is-invalid' : '' }}" type="number" name="plan_amount" id="plan_amount" value="{{ old('plan_amount', $subscription->plan_amount) }}" step="0.01" required>
                @if($errors->has('plan_amount'))
                    <span class="text-danger">{{ $errors->first('plan_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscription.fields.plan_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="features">{{ trans('cruds.subscription.fields.features') }}</label>
                <textarea class="form-control {{ $errors->has('features') ? 'is-invalid' : '' }}" name="features" id="features">{{ old('features', $subscription->features) }}</textarea>
                @if($errors->has('features'))
                    <span class="text-danger">{{ $errors->first('features') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscription.fields.features_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="roles">{{ trans('cruds.subscription.fields.role') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $subscription->roles->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscription.fields.role_helper') }}</span>
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
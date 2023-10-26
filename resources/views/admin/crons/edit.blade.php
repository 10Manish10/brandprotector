@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Cron Job
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.crons.update", [$cron->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
			<div class="form-group">
                <label class="required" for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $cron->name) }}" required>
                @if($errors->has('name'))
                	<span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
				<label class="required" for="command">Command (comma separated client id)</label>
				<input class="form-control {{ $errors->has('command') ? 'is-invalid' : '' }}" type="text" name="command" id="command" value="{{ old('command', $cron->command) }}" required>
				@if($errors->has('command'))
					<span class="text-danger">{{ $errors->first('command') }}</span>
				@endif
            </div>
            <div class="form-group">
				<label class="required" for="schedule">schedule</label>
				<input class="form-control {{ $errors->has('schedule') ? 'is-invalid' : '' }}" type="text" name="schedule" id="schedule" value="{{ old('schedule', $cron->schedule) }}" required>
				@if($errors->has('schedule'))
					<span class="text-danger">{{ $errors->first('schedule') }}</span>
				@endif
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
@section('scripts')
@endsection
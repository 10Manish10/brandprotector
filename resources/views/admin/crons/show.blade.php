@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">Cron Job</div>
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>
                            {{ $cron->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $cron->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Command
                        </th>
                        <td>
                            {{ $cron->command }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Schedule
                        </th>
                        <td>
                            {{ $cron->schedule }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Created By
                        </th>
                        <td>
                            {{ $cron->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Created At
                        </th>
                        <td>
                            {{ $cron->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
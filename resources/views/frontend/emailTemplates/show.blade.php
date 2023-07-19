@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.emailTemplate.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.email-templates.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $emailTemplate->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.subject') }}
                                    </th>
                                    <td>
                                        {{ $emailTemplate->subject }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.email_body') }}
                                    </th>
                                    <td>
                                        {!! $emailTemplate->email_body !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.priority') }}
                                    </th>
                                    <td>
                                        {{ App\Models\EmailTemplate::PRIORITY_RADIO[$emailTemplate->priority] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.clients') }}
                                    </th>
                                    <td>
                                        @foreach($emailTemplate->clients as $key => $clients)
                                            <span class="label label-info">{{ $clients->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.from_email') }}
                                    </th>
                                    <td>
                                        {{ $emailTemplate->from_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailTemplate.fields.to_email') }}
                                    </th>
                                    <td>
                                        {{ $emailTemplate->to_email }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.email-templates.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.client.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.clients.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $client->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $client->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.email') }}
                                    </th>
                                    <td>
                                        {{ $client->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.logo') }}
                                    </th>
                                    <td>
                                        @if($client->logo)
                                            <a href="{{ $client->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $client->logo->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.channels') }}
                                    </th>
                                    <td>
                                        @foreach($client->channels as $key => $channels)
                                            <span class="label label-info">{{ $channels->channel_name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.keywords') }}
                                    </th>
                                    <td>
                                        {!! $client->keywords !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.website') }}
                                    </th>
                                    <td>
                                        {{ $client->website }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.brand_name') }}
                                    </th>
                                    <td>
                                        {{ $client->brand_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.social_handle') }}
                                    </th>
                                    <td>
                                        {{ $client->social_handle }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.company_name') }}
                                    </th>
                                    <td>
                                        {{ $client->company_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.client.fields.multiple_emails') }}
                                    </th>
                                    <td>
                                        {!! $client->multiple_emails !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.clients.index') }}">
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
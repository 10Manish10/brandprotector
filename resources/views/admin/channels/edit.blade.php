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
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label class="required" for="">Channel Variables</label>
                        <div class="variables table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="success">
                                        <td></td>
                                        <td>Variable Name</td>
                                        <td>Variable Data Type</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $vars = unserialize($channel->variables);
                                        $ds = array(
                                            'array'    => 'Array (multi input)',
                                            'date'     => 'Date',
                                            'email'    => 'Email',
                                            'number'   => 'Number',
                                            'password' => 'Password',
                                            'text'     => 'Text',
                                            'url'      => 'URL',
                                        );
                                    @endphp
                                    @foreach ($vars as $var)
                                        <tr>
                                            <td><button type="button" class="btn btn-xs btn-danger remove">✗</button></td>
                                            <td><input type="text" class="form-control" name="var[name][]" value="{{ $var['name'] }}" required></td>
                                            <td>
                                                <select class="form-select form-control" aria-label="Select Data Type" name="var[datatype][]" required>
                                                    <option value="" selected>Select DataType</option>
                                                    @foreach ($ds as $k => $v)
                                                        <option value="{{$k}}" {{ $k==$var['datatype'] ? 'selected' : '' }}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <input type="hidden" name="rows" id="rows" value="1">
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success addvar">+</button>
                        </div>
                    </div>
                </div>
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
@parent
<script>
    try {
        $(document).on("click", "button.addvar", function(){
            var rows = $("#rows").val();
            var tr = `
                <tr>
                    <td><button type="button" class="btn btn-xs btn-danger remove">\✗</button></td>
                    <td><input type="text" class="form-control" name="var[name][]" required></td>
                    <td>
                        <select class="form-select form-control" aria-label="Select Data Type" name="var[datatype][]" required>
                            <option value="" selected>Select DataType</option>
                            <option value="array">Array (multi input)</option>
                            <option value="date">Date</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="password">Password</option>
                            <option value="text">Text</option>
                            <option value="url">URL</option>
                        </select>
                    </td>
                </tr>
            `;
            rows++;
            $("#rows").val(rows);
            $(".variables table tbody").append(tr);
        });
        $(document).on("click", "button.remove", function(){
            console.log("remove");
            var rows = $("#rows").val();
            rows--;
            $("#rows").val(rows);
            $(this).closest("tr").remove();
        });
    } catch (e) {
        console.error(`Error in adding variables - ${e}`)
    }
</script>
@endsection
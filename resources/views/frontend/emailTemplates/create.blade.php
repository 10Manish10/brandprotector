@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.emailTemplate.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.email-templates.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="subject">{{ trans('cruds.emailTemplate.fields.subject') }}</label>
                            <input class="form-control" type="text" name="subject" id="subject" value="{{ old('subject', '') }}" required>
                            @if($errors->has('subject'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('subject') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.subject_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="email_body">{{ trans('cruds.emailTemplate.fields.email_body') }}</label>
                            <textarea class="form-control ckeditor" name="email_body" id="email_body">{!! old('email_body') !!}</textarea>
                            @if($errors->has('email_body'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email_body') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.email_body_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.emailTemplate.fields.priority') }}</label>
                            @foreach(App\Models\EmailTemplate::PRIORITY_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="priority_{{ $key }}" name="priority" value="{{ $key }}" {{ old('priority', 'low') === (string) $key ? 'checked' : '' }} required>
                                    <label for="priority_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('priority'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('priority') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.priority_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="clients">{{ trans('cruds.emailTemplate.fields.clients') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="clients[]" id="clients" multiple required>
                                @foreach($clients as $id => $client)
                                    <option value="{{ $id }}" {{ in_array($id, old('clients', [])) ? 'selected' : '' }}>{{ $client }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('clients'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('clients') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.clients_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="from_email">{{ trans('cruds.emailTemplate.fields.from_email') }}</label>
                            <input class="form-control" type="email" name="from_email" id="from_email" value="{{ old('from_email') }}" required>
                            @if($errors->has('from_email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('from_email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.from_email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="to_email">{{ trans('cruds.emailTemplate.fields.to_email') }}</label>
                            <input class="form-control" type="email" name="to_email" id="to_email" value="{{ old('to_email') }}" required>
                            @if($errors->has('to_email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('to_email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.emailTemplate.fields.to_email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.email-templates.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $emailTemplate->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
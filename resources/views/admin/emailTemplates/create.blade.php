@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.emailTemplate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.email-templates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="subject">{{ trans('cruds.emailTemplate.fields.subject') }}</label>
                <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text" name="subject" id="subject" value="{{ old('subject', '') }}" required>
                @if($errors->has('subject'))
                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emailTemplate.fields.subject_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_body">{{ trans('cruds.emailTemplate.fields.email_body') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('email_body') ? 'is-invalid' : '' }}" name="email_body" id="email_body">{!! old('email_body') !!}</textarea>
                @if($errors->has('email_body'))
                    <span class="text-danger">{{ $errors->first('email_body') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emailTemplate.fields.email_body_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.emailTemplate.fields.priority') }}</label>
                @foreach(App\Models\EmailTemplate::PRIORITY_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('priority') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="priority_{{ $key }}" name="priority" value="{{ $key }}" {{ old('priority', 'low') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="priority_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('priority'))
                    <span class="text-danger">{{ $errors->first('priority') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emailTemplate.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="channels">Channel</label>
                <select class="form-control select2 {{ $errors->has('channels') ? 'is-invalid' : '' }}" name="channels[]" id="channels" required>
                    <option value="" selected disabled>Select Channel</option>
                    @foreach($channels as $id => $client)
                        <option value="{{ $id }}" {{ in_array($id, old('channels', [])) ? 'selected' : '' }}>{{ $client }}</option>
                    @endforeach
                </select>
                @if($errors->has('channels'))
                    <span class="text-danger">{{ $errors->first('channels') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="from_email">{{ trans('cruds.emailTemplate.fields.from_email') }}</label>
                <input class="form-control {{ $errors->has('from_email') ? 'is-invalid' : '' }}" type="text" name="from_email" id="from_email" value="{{ old('from_email') }}" required>
                @if($errors->has('from_email'))
                    <span class="text-danger">{{ $errors->first('from_email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emailTemplate.fields.from_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="to_email">{{ trans('cruds.emailTemplate.fields.to_email') }}</label>
                <input class="form-control {{ $errors->has('to_email') ? 'is-invalid' : '' }}" type="text" name="to_email" id="to_email" value="{{ old('to_email') }}" required>
                @if($errors->has('to_email'))
                    <span class="text-danger">{{ $errors->first('to_email') }}</span>
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
                xhr.open('POST', '{{ route('admin.email-templates.storeCKEditorImages') }}', true);
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
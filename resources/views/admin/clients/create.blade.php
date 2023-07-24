@extends('layouts.admin')
@section('content')
<style>
    .currentform:not(.loading) .loader {
        display: none !important;
    }
    .currentform.loading .loader {
        display: block;
        position: absolute;
        top: 50%;
        left:50%;
        transform:translate(-50%, -50%);
        z-index: 99999;
    }
    .currentform.loading {
        opacity: 0.5;
    }
</style>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.client.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.clients.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.client.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.client.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="logo">{{ trans('cruds.client.fields.logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <span class="text-danger">{{ $errors->first('logo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="channels">{{ trans('cruds.client.fields.channels') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('channels') ? 'is-invalid' : '' }}" name="channels[]" id="channels" multiple required>
                    @foreach($channels as $id => $channel)
                        <option value="{{ $id }}" {{ in_array($id, old('channels', [])) ? 'selected' : '' }}>{{ $channel }}</option>
                    @endforeach
                </select>
                @if($errors->has('channels'))
                    <span class="text-danger">{{ $errors->first('channels') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.channels_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="keywords">{{ trans('cruds.client.fields.keywords') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('keywords') ? 'is-invalid' : '' }}" name="keywords" id="keywords">{!! old('keywords') !!}</textarea>
                @if($errors->has('keywords'))
                    <span class="text-danger">{{ $errors->first('keywords') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.client.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', '') }}">
                @if($errors->has('website'))
                    <span class="text-danger">{{ $errors->first('website') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.website_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="brand_name">{{ trans('cruds.client.fields.brand_name') }}</label>
                <input class="form-control {{ $errors->has('brand_name') ? 'is-invalid' : '' }}" type="text" name="brand_name" id="brand_name" value="{{ old('brand_name', '') }}" required>
                @if($errors->has('brand_name'))
                    <span class="text-danger">{{ $errors->first('brand_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.brand_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="social_handle">{{ trans('cruds.client.fields.social_handle') }}</label>
                <input class="form-control {{ $errors->has('social_handle') ? 'is-invalid' : '' }}" type="text" name="social_handle" id="social_handle" value="{{ old('social_handle', '') }}">
                @if($errors->has('social_handle'))
                    <span class="text-danger">{{ $errors->first('social_handle') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.social_handle_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="company_name">{{ trans('cruds.client.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}" required>
                @if($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="multiple_emails">{{ trans('cruds.client.fields.multiple_emails') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('multiple_emails') ? 'is-invalid' : '' }}" name="multiple_emails" id="multiple_emails">{!! old('multiple_emails') !!}</textarea>
                @if($errors->has('multiple_emails'))
                    <span class="text-danger">{{ $errors->first('multiple_emails') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.multiple_emails_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="document_proof">{{ trans('cruds.client.fields.document_proof') }}</label>
                <div class="needsclick dropzone {{ $errors->has('document_proof') ? 'is-invalid' : '' }}" id="document_proof-dropzone">
                </div>
                @if($errors->has('document_proof'))
                    <span class="text-danger">{{ $errors->first('document_proof') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.document_proof_helper') }}</span>
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
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.clients.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 1024,
      height: 1024
    },
    success: function (file, response) {
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($client) && $client->logo)
      var file = {!! json_encode($client->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
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
                xhr.open('POST', '{{ route('admin.clients.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $client->id ?? 0 }}');
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

<script>
    var uploadedDocumentProofMap = {}
Dropzone.options.documentProofDropzone = {
    url: '{{ route('admin.clients.storeMedia') }}',
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document_proof[]" value="' + response.name + '">')
      uploadedDocumentProofMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentProofMap[file.name]
      }
      $('form').find('input[name="document_proof[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($client) && $client->document_proof)
          var files =
            {!! json_encode($client->document_proof) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="document_proof[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection
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
        {{ trans('global.edit') }} {{ trans('cruds.client.title_singular') }}
    </div>

    <div class="card-body currentform">
        <form method="POST" action="{{ route("admin.clients.update", [$client->id]) }}" enctype="multipart/form-data">
            <div class="loader d-flex justify-content-center">
				<div class="spinner-border spinner-border-lg" role="status">
					<span class="sr-only">Loading...</span>
				</div>
            </div>
            @method('PUT')
            @csrf
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="required" for="name">{{ trans('cruds.client.fields.name') }}</label>
						<input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $client->name) }}" required>
						@if($errors->has('name'))
							<span class="text-danger">{{ $errors->first('name') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.name_helper') }}</span>
					</div>
					<div class="form-group">
						<label class="required" for="email">{{ trans('cruds.client.fields.email') }}</label>
						<input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $client->email) }}" required>
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
						<label for="keywords">{{ trans('cruds.client.fields.keywords') }}</label>
						<textarea class="form-control ckeditor {{ $errors->has('keywords') ? 'is-invalid' : '' }}" name="keywords" id="keywords">{!! old('keywords', $client->keywords) !!}</textarea>
						@if($errors->has('keywords'))
							<span class="text-danger">{{ $errors->first('keywords') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.keywords_helper') }}</span>
					</div>
					<div class="form-group">
						<label for="website">{{ trans('cruds.client.fields.website') }}</label>
						<input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $client->website) }}">
						@if($errors->has('website'))
							<span class="text-danger">{{ $errors->first('website') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.website_helper') }}</span>
					</div>
					<div class="form-group">
						<label class="required" for="brand_name">{{ trans('cruds.client.fields.brand_name') }}</label>
						<input class="form-control {{ $errors->has('brand_name') ? 'is-invalid' : '' }}" type="text" name="brand_name" id="brand_name" value="{{ old('brand_name', $client->brand_name) }}" required>
						@if($errors->has('brand_name'))
							<span class="text-danger">{{ $errors->first('brand_name') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.brand_name_helper') }}</span>
					</div>
					<div class="form-group">
						<label for="social_handle">{{ trans('cruds.client.fields.social_handle') }}</label>
						<input class="form-control {{ $errors->has('social_handle') ? 'is-invalid' : '' }}" type="text" name="social_handle" id="social_handle" value="{{ old('social_handle', $client->social_handle) }}">
						@if($errors->has('social_handle'))
							<span class="text-danger">{{ $errors->first('social_handle') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.social_handle_helper') }}</span>
					</div>
					<div class="form-group">
						<label class="required" for="company_name">{{ trans('cruds.client.fields.company_name') }}</label>
						<input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $client->company_name) }}" required>
						@if($errors->has('company_name'))
							<span class="text-danger">{{ $errors->first('company_name') }}</span>
						@endif
						<span class="help-block">{{ trans('cruds.client.fields.company_name_helper') }}</span>
					</div>
					<div class="form-group">
						<label for="multiple_emails">{{ trans('cruds.client.fields.multiple_emails') }}</label>
						<textarea class="form-control ckeditor {{ $errors->has('multiple_emails') ? 'is-invalid' : '' }}" name="multiple_emails" id="multiple_emails">{!! old('multiple_emails', $client->multiple_emails) !!}</textarea>
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
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="required">Choose Subscription Plan</label>
						@foreach($subscription as $id => $sub)
							<div class="custom-control custom-radio">
								<input class="custom-control-input" data-subid="{{$sub->id}}" type="radio" id="subid-{{$sub->id}}" name="subplan">
								<label for="subid-{{$sub->id}}" class="custom-control-label">{{$sub->name}} ({{$sub->plan_amount}})</label>
							</div>
						@endforeach
					</div>
					<div class="form-group">
						<div id="plan-channels"></div>
					</div>
					<div id="variables"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn btn-danger" type="submit">
							{{ trans('global.save') }}
						</button>
					</div>
				</div>
			</div>
        </form>
    </div>
</div>



@endsection

@section('scripts')

<script>
	$('input[name=subplan]').change(function(){
		$("#variables").empty()
		var thisform = $(".currentform")
		thisform.addClass("loading")
		let value = $(this).data('subid')
		$.ajax({
			method: "GET",
			url: `/admin/clients/channels/${value}`,
			success: (x) => {
				localStorage.setItem('channelData', JSON.stringify(x))
				$("#plan-channels").empty()
				let channelDiv = `<label class="required">Choose Channel</label>`
				x.forEach(channel => {
					channelDiv += `
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" data-cname="${channel.channel_name}" data-cid="${channel.id}" name="channel[]" id="channel[${channel.id}]">
						<label class="custom-control-label" for="channel[${channel.id}]">${channel.channel_name}</label>
					</div>
					`
					thisform.removeClass("loading")
				})
				$("#plan-channels").append(channelDiv)
			},
			error: (e) => {
				localStorage.removeItem('channelData')
				$("#plan-channels").append(`<p style="color:red;">some error occured, please retry after some time.</p>`)
				thisform.removeClass("loading")
			}
		})
	});
	$(document).on("change", "#plan-channels input[type='checkbox']", function() {
		var thisform = $(".currentform")
		thisform.addClass("loading")
		if (this.checked) {
			let cid = $(this).data('cid')
			let cname = $(this).data('cname')
			let channelData = JSON.parse(localStorage.getItem('channelData'))
			let selectedChannelData = channelData.filter(ch => ch.id === cid)
			let variables = selectedChannelData[0].variables
			let variableHtml = `
				<div class="card" id="chvar-${cid}"><div class="card-header"><b>Enter ${cname} Variables</b></div><div class="card-body">
			`
			variables.forEach(v => {
				variableHtml += `
				<div class="form-group">
					<label class="required" for="${cname}.${v.name}">${v.name}</label>
					<input class="form-control" type="${v.datatype}" name="${cname}.${v.name}" id="${cname}.${v.name}" required>
				</div>
				`
			})
			variableHtml += `</div></div>`
			$("#variables").append(variableHtml)
			thisform.removeClass("loading")
		} else {
			let cid = $(this).data('cid')
			$("#variables").find(`#chvar-${cid}`).remove()
			thisform.removeClass("loading")
		}
	})
	$("form").submit(function(e){
        $(this).find("input[type='submit']").attr("disabled", true);
    })
</script>

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
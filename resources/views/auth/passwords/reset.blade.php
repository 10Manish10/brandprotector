@extends('layouts.app')
@section('content')
<div class="login-box" style="width:100%;">
    <div class="login-logo" style="display:none;">
        <div class="login-logo">
            <a href="{{ route('admin.homee') }}">
                {{ trans('panel.site_title') }}
            </a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body login-card-body">
                    <img src="https://cdn.shopify.com/s/files/1/0631/3410/5829/files/logo.png?v=1690990710" alt="Brand Protection Enforcement" style="height:80px;margin-bottom:15px;display:block;margin-left:auto;margin-right:auto;">
                        <p class="login-box-msg">
                            {{ trans('global.reset_password') }}
                        </p>

                        <form method="POST" action="{{ route('password.request') }}">
                            @csrf

                            <input name="token" value="{{ $token }}" type="hidden">

                            <div>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}">

                                    @if($errors->has('email'))
                                        <span class="text-danger">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ trans('global.login_password') }}">

                                    @if($errors->has('password'))
                                        <span class="text-danger">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ trans('global.login_password_confirmation') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-flat btn-block">
                                        {{ trans('global.reset_password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="login-box" style="width:100%;">
    <div class="login-logo" style="display:none;">
        <div class="login-logo">
            <a href="{{ route('admin.home') }}">
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
                            {{ trans('global.login') }}
                        </p>

                        @if(session()->has('message'))
                            <p class="alert alert-info">
                                {{ session()->get('message') }}
                            </p>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}">

                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ trans('global.login_password') }}">

                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>


                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="remember" id="remember">
                                        <label for="remember">{{ trans('global.remember_me') }}</label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                        {{ trans('global.login') }}
                                    </button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>


                        @if(Route::has('password.request'))
                            <p class="mb-1">
                                <a href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                            </p>
                        @endif
                        <p class="mb-1">
                            <a class="text-center" href="{{ route('register') }}">
                                {{ trans('global.register') }}
                            </a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return false;
    }
    var themee = getCookie("themee");
    if (themee === 'light') {
        document.body.classList.remove('dark-mode');
    }
    if (themee === 'dark') {
        document.body.classList.add('dark-mode');
    }
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        const ns = e.matches ? "dark" : "light";
        var now = new Date();
        var time = now.getTime();
        time += 3600 * 24000 * 30;
        now.setTime(time);
        if (ns === 'light') {
            document.body.classList.remove('dark-mode');
            document.cookie = 'themee=' + ns + '; expires=' + now.toUTCString() + '; path=/';
        }
        if (ns === 'dark') {
            document.body.classList.add('dark-mode');
            document.cookie = 'themee=' + ns + '; expires=' + now.toUTCString() + '; path=/';
        }
    });
    if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark-mode');
    }
</script>
@endsection
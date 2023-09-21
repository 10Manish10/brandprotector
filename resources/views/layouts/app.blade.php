<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/adminltev3.css') }}" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    @yield('styles')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    @yield('content')
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
    @yield('scripts')
    <script>
      if (document.body.classList.contains('dark-mode')) {
        var element = document.getElementById('btn-dark-mode');
        if (typeof(element) != 'undefined' && element != null) {
          document.getElementById('btn-dark-mode').checked = true;
        }
      } else {
        var element = document.getElementById('btn-light-theme');
        if (typeof(element) != 'undefined' && element != null) {
          document.getElementById('btn-light-theme').checked = true;
        }
      }
      function handleThemeChange(src) {
        // var event = document.createEvent('Event');
        // event.initEvent('themeChange', true, true);

        if (src.value === 'light') {
          document.body.classList.remove('dark-mode');
        }
        if (src.value === 'dark') {
          document.body.classList.add('dark-mode');
        }

        var now = new Date();
        var time = now.getTime();
        time += 3600 * 24000 * 30;
        now.setTime(time);
        document.cookie = 'themee=' + src.value + '; expires=' + now.toUTCString() + '; path=/';
        document.body.dispatchEvent(event);
      }
    </script>
</body>

</html>
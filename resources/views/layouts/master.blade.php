<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>TrocaLivro {{ isset($title) ? $title : "" }}</title>
        <link rel="shortcut icon" href="http://res.cloudinary.com/trocalivrosenac/image/upload/v1448120477/tl_favicon_qbbmxp.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/system.css') }}">
        <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/select2.min.js') }}"></script>

  </head>
  <body>

        @include('layouts.header')
        <div class="jumbotron">
        @yield('content')
        </div>




      <?php if(Auth::check()){ ?>
            @include('layouts.notifications')
      <?php } ?>

        @include('layouts.footer')

  </body>
</html>

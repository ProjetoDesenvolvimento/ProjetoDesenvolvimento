<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,700,300italic,400italic,500italic' rel='stylesheet' type='text/css'>
        <title>TrocaLivro {{ isset($title) ? $title : "" }}</title>
        <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/system.css') }}">
        <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/select2.min.js') }}"></script>



        <!--
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
      -->
  </head>
  <body>

        @include('layouts.header')
        <div class="jumbotron">
        @yield('content')
        </div>




      <?php if(session()->get("usuariologeado" )=="SIM"):?>
            @include('layouts.notifications');
      <?php endif;?>




        @include('layouts.footer')

  </body>
</html>

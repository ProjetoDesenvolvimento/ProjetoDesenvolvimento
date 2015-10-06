<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TrocaLivro {{ isset($title) ? $title : "" }}</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/select2.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">

        <!--
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
      -->
  </head>
  <body>
      <div class="container">
          @yield('content')
      </div>


  </body>
</html>
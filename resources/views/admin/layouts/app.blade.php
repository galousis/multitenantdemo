<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>


    {{--<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">--}}
    {{--<link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet" type="text/css">--}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" type="text/css"
          href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?></script>
</head>
<body>
<div id="app">
    <example></example>
</div>
<!-- Scripts -->
<script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>

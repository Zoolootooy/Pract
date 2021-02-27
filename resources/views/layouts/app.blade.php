<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Happy Youtube Search</title>
    @include('partials/links')
</head>
<body>

<div class="container" >
{{--    @include('partials/menu')--}}
    @yield('content')
</div>
</body>
<footer>
    @include('partials/scripts')
</footer>
</html>

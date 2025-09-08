</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">



    <title>@yield('title') - Auth</title>
    @include('include.head')
    <link rel="icon" href="{{ asset('/assets/img/public/logo.png') }}" type="image/png">
</head>

<body>
    @yield('content')
    @include('include.footer')
    @stack('scripts')
</body>

</html>

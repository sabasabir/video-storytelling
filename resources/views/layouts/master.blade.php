<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title') - StoryTelling</title>
    <link rel="icon" href="{{ asset('/assets/img/public/logo.png') }}" type="image/png">
    @include('include.head')
    @yield('style')
</head>

<body class="bg-light">
    @include('include.navbar')
    <main>
        @yield('content')
    </main>
    @include('include.footer')
    @stack('scripts')
</body>

</html>

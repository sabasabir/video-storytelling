<!DOCTYPE html>
<html lang="en">
{{-- Designed And Developed By Ahsan Danish --}}

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Dynamic Meta Tags --}}
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Prime Minister Youth Loan Program AJK') - PMYP</title>
    <meta name="description" content="@yield('meta_description', 'Prime Minister Youth Loan Program. Empowering youth through accessible business loan under the vision of the Prime Minister.')">
    <meta name="keywords" content="@yield('meta_keywords', 'AJK, Youth Loan, PMYLP, AK Small Industries')">

    {{-- Open Graph for Social Sharing --}}
    <meta property="og:title" content="@yield('og_title', 'Prime Minister Youth Loan Program AJK ')">
    <meta property="og:description" content="@yield('og_description', 'Prime Minister Youth Loan Program. Empowering youth through accessible business loan under the vision of the Prime Minister.')">
    <meta property="og:image" content="@yield('og_image', asset('/assets/img/public/banner.webp'))">
    <meta property="og:url" content="{{ url()->current() }}/">
    <link rel="canonical" href="{{ url()->current() }}/">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Prime Minister Youth Loan Program AJK ')">
    <meta name="twitter:description" content="@yield('og_description', 'Prime Minister Youth Loan Program. Empowering youth through accessible business loan under the vision of the Prime Minister.')">
    <meta name="twitter:image" content="@yield('og_image', asset('/assets/img/public/banner.webp'))">



    <link rel="icon" href="{{ asset('/assets/img/public/logo.png') }}" type="image/png">
    @include('include.head-public')
    @yield('style')
</head>

<body>
    @include('include.topStrip-public')
    @include('include.navbar-public')
    <div class="print-area">
        @yield('content')
    </div>
    @include('include.footer-public')
    @include('include.foot-public')
    @stack('scripts')
</body>

</html>

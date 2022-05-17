<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HPVK.com | the Swiss army knife of tiny web tools</title>
    <meta name="description" content="HPVK.com the Swiss army knife of tiny web tools, Free URL shortener shortens your unwieldly links into more manageable and useable URLs">
    <meta name="keywords" content="hpvk tinyurl url save share shorten analyze web tools">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 font-sans">

<div style="display:none;">HPVK.com the Swiss army knife of tiny web tools, Free URL shortener shortens your unwieldly links into more manageable and useable URLs</div>
<div id="app">
    <video autoplay="" loop="" muted="" poster="https://www.pexels.com/assets/videos/free-videos-7daa2ef41a140f70c757ce91913a4ecb90570b7d7cd2b401bae868350e02c83a.jpg">
        <source src="https://static.pexels.com/lib/videos/free-videos.mp4" type="video/mp4">
        <source src="https://static.pexels.com/lib/videos/free-videos.webm" type="video/webm">
    </video>
    @guest()
        <navigation-bar :user="''"></navigation-bar>
    @else
        <navigation-bar :user="{{ auth()->user()->toJson() }}"></navigation-bar>
    @endguest

    <main role="main" class="container mt-10 mx-auto">
        @yield('content')
    </main>
</div>
</body>

<style>
    video {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        background: #232a34;
    }
</style>

</html>


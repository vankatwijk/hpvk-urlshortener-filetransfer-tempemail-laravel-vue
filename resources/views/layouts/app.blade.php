<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <html lang = "en">
    <meta name="theme-color">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tiny web tools | URL shortener | File transfer | Link tracking</title>
    <meta name="description" content="Tiny web tools, URL shortener, shortens your links into more manageable and useable URLs with tracking and file transfer / upload all you need in one place">
    <meta name="keywords" content="hpvk tinyurl url save share shorten analyze web tools file transfer upload url tracking email tracking">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link hreflang="en" href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link hreflang="en" rel="icon" href="https://hpvk.com/favicon.ico">
    <link hreflang="en" rel="manifest" href="manifest.json">
    <link hreflang="en" rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png" />
    <link hreflang="en" rel="icon" sizes="192x192" href="/img/android-chrome-192x192.png" />

    <!-- Fonts -->
    <link hreflang="en" rel="dns-prefetch" href="//fonts.gstatic.com">
    <link hreflang="en" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    
</head>
<body class="bg-gray-200 font-sans">

<div style="display:none;">



    <h1>Tiny web tools | URL shortener | File transfer | Link tracking</h1><p>Free URL shortener shortens your unwieldly links into more manageable and useable URLs</p>
    <p>Shorten URLs and and track when and where they were clicked</p>
    <p>hpvk is the simplest way to send your files around the world. Share large files and photos. Transfer up to 2GB free. File sharing made easy!</p>

    <div>
        <form type="post" action="/api/shorten">
            <label for="url">URL to shorten</label><br>
            <input type="text" id="url" name="url" value=""><br>
            <input type="submit" value="Submit">
          </form> 
    </div>

    <div class="blog">

        <div class="post">
            <span><img src="/img/post/short_link.webp" alt="shorten link"></span>
            <h2>Track your shortened link</h2>
            <p>No more, I didnt see your link. Login to our Dashboard first then generate a link, once the link has been opened you will be able to view where and when it was opened.</p>
            <p><a href="{{env('APP_URL')}}'/login'" target="_blank">Start shortening</a></p>
        </div>

        <div class="post">
            <span><img src="/img/post/link_tree.webp" alt="link tree"></span>
            <h2>Link Tree</h2>
            <p>What the hell is a link tree, This is your custom Page on the internet containing your image and some links to your social media , everytime a link is clicked you will get usefull insight into your socials.</p>
            <p><a href="{{env('APP_URL')}}'/login'" target="_blank">Start building a link tree</a></p>
        </div>

        <div class="post">
            <span><img src="/img/post/email_tracking.webp" alt="email tracking"></span>
            <h2>Email Tracking</h2>
            <p>Upload an image png/jpeg and use the generated tinyurl within your email as a url image attachment, when the email is openned we will track it and you can view all the information in your dashboard.</p>
            <p><a href="{{env('APP_URL')}}'/login'" target="_blank">Start tracking emails</a></p>
        </div>

        <div class="post">
            <span><img src="/img/post/file_transfer.webp" alt="file transfer"></span>
            <h2>Transfer files</h2>
            <p>Need to transfer a file to a friend or to yourself in a snap, then use our file transfer system with no upload limits, we will keep the file on our servers for 48hrs then it will be deleted forever from our servers.</p>
            <p><a href="{{env('APP_URL')}}'/login'" target="_blank">Start transfering</a></p>
        </div>

    </div>

</div>

<div id="app">
    
    {{-- <video autoplay="" loop="" muted="" poster="https://www.pexels.com/assets/videos/free-videos-7daa2ef41a140f70c757ce91913a4ecb90570b7d7cd2b401bae868350e02c83a.jpg">
        <source src="https://static.pexels.com/lib/videos/free-videos.mp4" type="video/mp4">
        <source src="https://static.pexels.com/lib/videos/free-videos.webm" type="video/webm">
    </video> --}}

    @guest()
        <navigation-bar :user="''"></navigation-bar>
    @else
        <navigation-bar :user="{{ auth()->user()->toJson() }}"></navigation-bar>
    @endguest

    <main role="main" class="container mt-10 mx-auto">
        @yield('content')
    </main>
</div>

<div class="footer-links">
    <a href="{{env('APP_URL')}}'/policy'" target="_blank">policy <i class="fab fa-fingerprint"></i></a>
    <a href="{{env('APP_URL')}}'/terms'" target="_blank">Terms <i class="fab fa-file"></i></a>
    <a href="{{env('APP_URL')}}'/blog'" target="_blank">Blog <i class="fab fa-file"></i></a>
    <a href="https://vanniks.com" target="_blank">Vanniks <i class="fab fa-egg"></i></a>
    <a href="https://vanniks.com" target="_blank">created by hendrikus pieter van katwijk<i class="fab fa-egg"></i></a>
</div>

</div>
</body>

<style>
    .footer-links {
        display: none;
    }
    video {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        background: #232a34;
        position: absolute;
        z-index: -1;
        filter: blur(15px);
    }
</style>
<script>
    // we check if the browser supports ServiceWorkers
    if ('serviceWorker' in navigator) {
        navigator
            .serviceWorker
            .register(
                // path to the service worker file
                './service-worker.js'
            )
            // the registration is async and it returns a promise
            .then(function(reg) {
                console.log('Registration Successful');
            });
    }
</script>

</html>


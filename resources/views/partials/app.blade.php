<!DOCTYPE html>
<html>
<head>
    <title>TromBoy Admin Panel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>

    @include('partials.notify')
    <div class="container">
        @yield('content')
    </div>

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @yield('script')
</body>
</html>
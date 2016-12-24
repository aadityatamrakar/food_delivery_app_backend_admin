<!DOCTYPE html>
<html>
<head>
    <title>TromBoy Admin Panel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" />
    @yield('style')
</head>
<body>
@include('partials.nav')
@include('partials.notify')
<div class="container">
    @yield('content')
</div>

<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/notify.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
@yield('script')
</body>
</html>
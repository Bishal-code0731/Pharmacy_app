<!DOCTYPE html>
<html>
<head>
    @include('layouts.header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('layouts.footer')
</div>
</body>
</html>
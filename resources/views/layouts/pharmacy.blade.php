<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pharmacy App')</title>
    <!-- Add your CSS and JS links here -->
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @include('layouts.header')
        
        <main class="content">
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
    
    @stack('scripts')
</body>
</html>
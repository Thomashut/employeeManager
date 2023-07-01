<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Employee Manager - @yield('title')</title>
</head>
<body>
    <div class="titleBar">
        <h3>Employee Manager</h3>
    </div>
    <div class="contentContainer">
        <div class="content">
        @yield('body')
        </div>
    </div>
</body>
</html>
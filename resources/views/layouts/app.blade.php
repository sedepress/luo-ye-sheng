<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>
<style>
    body {
        height: 100%;
        min-height: auto;
        background-color: #f8f8f8;
    }
</style>
<body>
<div id="app">
@yield('content')
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') </title>
    {{-- scripts  --}}
    <script src="{{ asset('js/app.js') }}" defer></script>  {{-- assetはpublic配下 そのファイルのパス--}}
    <!-- CSS only -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    @yield('stylesheet')
</head>
@yield('content')
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログインフォーム</title>
    {{-- scripts  --}}
    <script src="{{ asset('js/app.js') }}" defer></script>  {{-- assetはpublic配下 そのファイルのパス--}}
    <!-- CSS only -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    {{-- <link href="{{ asset(' css/signin.css') }}" rel="stylesheet"> --}}
    <style type="text/css">
    form {min-width: 300px;}
    </style>

    

</head>
<body class='text-center container bg-dark bg-opacity-10'>
    <div class='pt-5'><a href="{{ route('showLogin') }}" class='link-dark text-decoration-none'>
        <img class='' src="{{ asset('img/mailbox2.svg') }}" alt="#" width='102' height='87'>
        <h1 class='pt-3'>Yaruki Clear</h1></a>
    </div>
    @if ($errors->any())
    <div class='alert alert-danger'>
        <ul>
        @foreach ($errors->all() as $error)
            <li class='list-unstyled'>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    <main class='form-signin'>
        <form class='pt-3 w-25 container ' action="{{ route('login') }}" method='POST'>
            @csrf
            <h1 class='h3'>L o g i n</h1>

            <div class='form-floating'>
                <input class='form-control' id='floatingInput' type="email" placeholder='メールアドレスを記入して下さい' name='email' required autofocus>
                <label for="floatingInput">メールアドレス</label>
            </div>

            <div class='form-floating'>
                <input class='form-control' id='floatingPassword' type="password" placeholder='パスワードを記入して下さい' name='password' required>
                <label for="floatingPassword">パスワード</label>
            </div>

            <div class='pt-3'>
                <input class='btn btn-lg btn-success w-100' type='submit' value='Log in'></input>
                <h5 class='pt-5'>{{ \Carbon\Carbon::today()->format("y/m/d") }}</h5>
            </div>

        </form>
</main>
</body>
</html>
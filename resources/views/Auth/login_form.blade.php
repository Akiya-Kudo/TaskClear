@extends('layout.layout')

@section('title','ログインフォーム')

@section('stylesheet')
<link href="{{ asset('css/signin.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='text-center container bg-dark bg-opacity-10'>

    {{-- ロゴ --}}
    <div class='pt-5'><a href="{{ route('login.show') }}" class='link-dark text-decoration-none'>
        <img class='' src="{{ asset('img/mailbox2.svg') }}" alt="#" width='102' height='87'>
        <h1 class='pt-3'>DeKi Router</h1></a>
    </div>

    {{-- エラー表示 --}}
    @if ($errors->any())
    <div class='alert alert-danger'>
        <ul>
        @foreach ($errors->all() as $error)
            <li class='list-unstyled'>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    {{-- ログアウトセッションメッセージ --}}
    <x-alert type='success' :session="session('logout_success')"/>
    <x-alert type='success' :session="session('sample_user')"/>

    {{-- 入力フォーム --}}
    <main class='form-signin'>
        <form class='pt-3 w-25 container ' action="{{ route('login') }}" method='POST'>
            @csrf
            <h1 class='h3'>L o g i n</h1>

            <div class='form-floating'>
                <input class='form-control' id='floatingInput' type="email" placeholder='メールアドレスを記入して下さい' name='email' required autofocus>
                <label class='text-black-50' for="floatingInput">メールアドレス</label>
            </div>

            <div class='form-floating'>
                <input class='form-control' id='floatingPassword' type="password" placeholder='パスワードを記入して下さい' name='password' required>
                <label class='text-black-50' for="floatingPassword">パスワード</label>
            </div>

            <div class='pt-3'>
                <button type="submit" class="btn btn-outline-success w-100 btn-lg" >Log in</button>
                <p class='pt-3'><a href="{{ route('register.show') }}" class='link-success'>新規登録する</a></p>
                <h5 class='pt-3'>{{ \Carbon\Carbon::today()->format("y/m/d") }}</h5>
            </div>

        </form>
    </main>
</body>
@endsection
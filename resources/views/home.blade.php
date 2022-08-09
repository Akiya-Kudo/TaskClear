@extends('layout.layout')

@section('title', 'ホーム画面')

@section('stylesheet')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    <nav class="navbar navbar-light bg-light" >
        <div>
            <a class="navbar-brand ps-3" href="{{ route('login.show') }}">
                <img class='mx-2' src="{{ asset('img/mailbox2.svg') }}" alt="#" width='30' height='30'>
                <span class='h5 mx-2'>DeKi Router</span>
            </a>
            <button class="btn btn-outline-success px-4 me-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">メニュー</button>
        </div>
        <form action="{{ route('logout') }}" method="POST" >
            @csrf
            <button type="submit" class="btn btn-outline-success px-4 me-4" >Log out</button>
        </form>
    </nav>

    {{-- サイドバー --}}
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdroped with scrolling</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h5>DeKiRoute 選択</h5>
            <p>目標を決めよう</p>
            <div class="btn-group btn-group-vertical w-100" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-success">1</button>
                <button type="button" class="btn btn-outline-success">2</button>
                <button type="button" class="btn btn-outline-success">3</button>
                <button type="button" class="btn btn-outline-success">4</button>
                <button type="button" class="btn btn-outline-success">+</button>
            </div>
        </div>
    </div>

    {{-- メインコンテンツ --}}
    <div class='container'>
        <div class='mt-5'>
            <x-alert type='success' :session="session('login_success')"/>
            <h3>プロフィール</h3>
            <ul>
                <li class='h4'>user name : {{ Auth::user()->username }}</li>
                <li class='h4'>email : {{ Auth::user()->email }}</li>
            </ul>
        </div>
    </div>
</body>
@endsection
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
                <span class='h2 mx-2'>DeKi Router</span>
            </a>
            <button class="btn btn-outline-success px-4 me-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">メニュー</button>
        </div>

        <div class="btn-group dropstart">
            <button class="btn btn-outline-success px-4 me-5 dropdown-toggle" type="button" id="dropdownMenuClickableOutside" 
            data-bs-toggle="dropdown" data-bs-auto-close="inside" aria-expanded="false" style="width: 106px; height: 36px;" data-bs-offset="5,5">
                {{ Auth::user()->username }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableOutside">
              <li><a class="dropdown-item" href="#">Plofile</a></li>
              <li>
                <form name="sample_form_name" method="POST" action="/logout">
                @csrf
                    <a class="dropdown-item" href="javascript:sample_form_name.submit()">Log out</a>
                </form>
              </li>
            </ul>
        </div>
          
        </nav>

    {{-- サイドバー --}}
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">{{ Auth::user()->username }}</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h5>目標選択</h5>
            <div class="btn-group btn-group-vertical w-100" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-success">1</button>
                <button type="button" class="btn btn-outline-success">2</button>
                <button type="button" class="btn btn-outline-success">3</button>
                <button type="button" class="btn btn-outline-success">4</button>
                <button type="button" class="btn btn-outline-success">新しい目標を立てる</button>
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
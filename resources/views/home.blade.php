@extends('layout.layout')


@section('title', 'ホーム画面')

@section('stylesheet')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    {{-- サイドバー --}}
    <x-menu type='{{ Auth::user()->username }}' :items="$items" />
    

    {{-- メインコンテンツ --}}
    <div class='container'>
        <x-alert type='success' :session="session('login_success')"/>
        <div class='d-flex flex-wrap mt-5'>

            @foreach($items as $item)
            <div class="card border-success m-3" style="max-width: 25rem;"><a class='link-success text-decoration-none' href="/home/{{$item['id']}}">
                <div class="card-header bg-transparent border-success">{{ $item['tag'] }}</div>
                <div class="card-body text-success">
                    <h5 class="card-title">{{ $item['title'] }}</h5>
                    <p class="card-text">{{ $item['memo'] }}</p>
                </div>
                <div class="card-footer bg-transparent border-success">{{ $item['complete_date'] }} Last:2days</div></a>
            </div>
            @endforeach

            <div class='card border-success m-3 d-flex align-items-center' style='max-width: 12rem;max-height: 4rem;'>
                <a href="/home/make" class='link-success text-decoration-none d-flex flex-column'><div class='card-body'>新しい目標を立てる</div></a>
            </div>

        </div>


            {{-- <h3>プロフィール</h3>
            <ul>
                <li class='h4'>user name : {{ Auth::user()->username }}</li>
                <li class='h4'>email : {{ Auth::user()->email }}</li>
            </ul> --}}
            {{-- <h3> あなたの Goal</h3>
            <ul>
                @foreach ($items as $item)
                <li class='h4'>{{ $item['title'] }}</li>
                <li class='h4'>{{ $item['memo'] }}</li>
                <li class='h4'>{{ $item['complete_date'] }}</li>
                @endforeach

            </ul> --}}
        </div>
    </div>
</body>
@endsection
@extends('layout.layout')


@section('title', 'ホーム画面')

@section('stylesheet')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    {{-- サイドバー --}}
    <x-menu :goals="$goals" />
    

    {{-- メインコンテンツ --}}
    <div class='container'>
        {{-- アラートメッセージ --}}
        <x-alert type='success' :session="session('alert_success')"/>

        <h2 class='mt-3 ms-3 text-success'>Your Goals</h2>
        <hr class="text-success">
        <div class='d-flex flex-wrap mt-3 justify-content-center'>

            @foreach($goals as $goal)
            <div class="card hov-func-{{ $comps[$goal['id']] }} hov-size border-{{ $comps[$goal['id']] }} m-4 bg-light shadow" style="max-width: 25rem;">
                <a class='link-{{ $comps[$goal['id']] }} text-decoration-none' href="/home/{{$goal['id']}}">
                    <div class="card-header bg-transparent border-{{ $comps[$goal['id']] }}">{{ $goal['tag'] }}</div>
                    <div class="card-body text-{{ $comps[$goal['id']] }}">
                        <h5 class="card-title">{{ $goal['title'] }}</h5>
                        <p class="card-text" style='margin: 5px;'>{{ $goal['memo'] }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-{{ $comps[$goal['id']] }} d-flex justify-content-between flex-wrap">
                        <div>
                            {{ $goal['complete_date'] }}
                        </div>
                        {{-- <object class='d-bottun d-block border border-danger rounded-2 d-flex align-items-center' style="height: 30px; width: 30px;">
                            <a href="/deletegoal" class='text-center text-decoration-none flex-fill d-url'>×</a>
                        </object> --}}
                        <div class='d-flex'>
                            <form action="/editgoal" method='POST'>
                                @csrf
                                <input type="hidden" value='{{ $goal['id'] }}' name='goalid'>
                                <button type='submit' class="btn btn-outline-primary ms-3 mx-1">Edit</button>
                            </form>
                            <form action="/deletegoal" method='POST'>
                                @csrf
                                <input type="hidden" value='{{$goal['id']}}' name='goalid'>
                                <input type="hidden" value='{{$goal['title']}}' name='title'>
                                <button type='submit' class="btn btn-outline-danger mx-1">×</button>
                            </form>
                            <form action="/donegoal" method='POST'>
                                @csrf
                                <input type="hidden" value='{{$goal['id']}}' name='goalid'>
                                <input type="hidden" value='{{$goal['title']}}' name='title'>
                                <button type='submit' class="btn btn-outline-{{ $comps[$goal['id']] }} mx-1">Achieved</button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            <div class='card hov-func-success hov-size border-success m-3 d-flex align-items-center' style='max-width: 12rem;max-height: 4rem;'>
                <a href="/makegoal" class='link-success text-decoration-none d-flex flex-column'><div class='card-body'>新しい目標を立てる</div></a>
            </div>
        </div>


            {{--{{ Auth::user()->username }}--}}
        </div>
    </div>
</body>
@endsection
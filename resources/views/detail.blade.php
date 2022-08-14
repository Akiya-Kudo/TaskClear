@extends('layout.layout')

@section('title', '詳細画面')

@section('stylesheet')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    {{-- サイドバー --}}
    <x-menu :goals="$goals" />

    {{-- メインコンテンツ --}}
    <div class="d-flex flex-column ">

        {{-- タイトル --}}
        <div class='goal bg-success bg-opacity-75 shadow  border-success rounded-4 m-3 p-3 d-flex flex-column justify-content-evenly align-items-center'>
            <div class='leftcontent my-2 min-m-item'>
                <div>{{ $cer_goal['tag'] }}</div>
                <h1>{{ $cer_goal['title'] }}</h1>
            </div>
            <p class='middlecontent m-2 fs-5'>memo : {{ $cer_goal['memo'] }}</p>
            <div class='rightcontent m-2 fs-5'>Limit : {{ $cer_goal['complete_date'] }}</div>
        </div>

        {{-- 作成時のアラートメッセージ --}}
        <x-alert type='success' :session="session('subgoal_make_success')"/>
        <x-alert type='success' :session="session('goal_make_success')"/>
        <x-alert type='success' :session="session('success_delete_sub')"/>
        
        {{-- サブコンテント --}}
        <div class='subgoal d-flex flex-wrap justify-content-center'>

            {{-- Subgoals表示 --}}
            @foreach($subs as $sub)
            <div class="card hov-size border-success m-3 bg-light shadow" style="max-width: 30rem;">
                {{-- ナンバー --}}
                <div class="card-header bg-success bg-opacity-50 text-light border-success fw-bolder text-center">{{ $sub['subnumber'] }}</div>
                {{-- コンテンツ内容 --}}
                <div class='d-flex'>
                    {{-- サブゴール名・メモ --}}
                    <div class="card-body text-success" style="max-width: 15rem;">
                        <h5 class="card-title">{{ $sub['title'] }}</h5>
                        <p class="card-text"  style='margin: 5px;'>memo : {{ $sub['memo'] }}</p>
                    </div>
                    {{-- リスト --}}
                    <div class='m-2'>
                        <div class='text-success mx-3'>to do list : <a href="/home" class='text-success mx-2'>Edit List</a></div>
                        <ul class="list-group list-group-flush">
                        {{-- リストが存在する場合のみ --}}
                        @isset($lists[$sub['id']])
                            @foreach($lists[$sub['id']] as $list)
                            {{-- リスト数が５未満の時表示ストップ --}}
                            @empty ($list)
                                @break
                            @endempty
                                <li class="list-group-item bg-light text-success text-decoration-line-none" style='font-size: x-small;'><input class='mx-1' type="checkbox">{{ $list }}</li>
                            @endforeach
                        @endisset
                        </ul>
                    </div>                 
                </div>

                <div class="card-footer bg-transparent border-success text-success d-flex justify-content-between">
                    <div class='text-nowrap'>limit : {{ $sub['complete_date'] }}</div>
                    <div class='d-flex'>
                        <form action="/deletesubgoal" method='POST'>
                            @csrf
                            <input type="hidden" value='{{ $sub['id'] }}' name='subgoalid'>
                            <input type="hidden" value='{{ $sub['title'] }}' name='title'>
                            <input type="hidden" value='{{ $cer_goal['id'] }}' name='goalid'>
                            <button type='submit' class="btn btn-outline-danger mx-2">×</button>
                        </form>
                        {{-- <button type="button" class="btn btn-outline-danger mx-2" onclick="location.href='/deletesubgoal'">×</button> --}}
                        <button type="button" class="btn btn-outline-success ">Upload</button>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- 新規作成ボタン --}}
            <div class='card hov-func hov-size border-success m-3 d-flex align-items-center' style='max-width: 12rem;max-height: 4rem;'>
                <a href="/makesubgoal/{{ $cer_goal['id'] }}" class='link-success text-decoration-none d-flex flex-column'><div class='card-body'>新しい中間目標を立てる</div></a>
            </div>
        </div>
    </div>
</body>
@endsection
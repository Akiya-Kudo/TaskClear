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
        <x-alert type='success' :session="session('alert_success')"/>
        
        {{-- サブコンテント --}}
        <div class='subgoal d-flex flex-wrap justify-content-center'>

            {{-- Subgoals表示 --}}
            @foreach($subs as $sub)
            <div class="card hov-size border-{{ $sub_colors[$sub['id']] }} m-3 bg-light shadow" style="max-width: 30rem;">
                {{-- ナンバー --}}
                <div class="card-header bg-{{ $sub_colors[$sub['id']] }} bg-opacity-50 text-light border-{{ $sub_colors[$sub['id']] }} fw-bolder text-center">{{ $loop->iteration }}</div>
                {{-- コンテンツ内容 --}}
                <div class='d-flex flex-wrap justify-content-center'>
                    {{-- サブゴール名・メモ --}}
                    <div class="card-body text-{{ $sub_colors[$sub['id']] }} text-center" style="max-width: 15rem;">
                        <h5 class="card-title">{{ $sub['title'] }}</h5>
                        <p class="card-text text-start"  style='margin: 5px;'>memo : {{ $sub['memo'] }}</p>
                    </div>
                    {{-- リスト --}}
                    <div class='m-2' style="max-width: 13.5rem;">
                        <div class='text-{{ $sub_colors[$sub['id']] }} mx-3'>to do list : </div>
                        {{-- リストが存在する場合のみ --}}
                        @isset($lists[$sub['id']])
                        
                        {{-- complete変更フォーム --}}
                        <form action="/donelist" method='POST' id="fm{{ $sub['id'] }}">
                        @csrf
                            <ul class="list-group list-group-flush">
                            {{-- フォームname属性値設定の変数 --}}
                            @php
                                $i = 1;
                                $complete = $completes[$sub['id']];
                            @endphp

                            {{-- リスト要素を繰り返し表示 --}}
                            @foreach($lists[$sub['id']] as $list)

                            {{-- リスト数が５未満の時表示ストップ --}}
                                @empty ($list)
                                    @break
                                @endempty

                                <li class="list-group-item bg-light text-{{ $complete["complete$i"]["color"] }}" style='font-size: x-small;'>
                                    <label class="{{ $complete["complete$i"]["style"] }}">
                                        <input class='mx-1' type="checkbox" value="checked" name="complete{{ $i }}">
                                        {{ $list }}
                                    </label>
                                </li>

                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            </ul>
                            <input type="hidden" value='{{ $sub['id'] }}' name='subgoalid'>
                        </form>
                        @endisset
                    </div>                 
                </div>
                {{-- リミット表示 --}}
                <div class="card-footer bg-transparent border-{{ $sub_colors[$sub['id']] }} text-{{ $sub_colors[$sub['id']] }} d-flex justify-content-between flex-wrap">
                    <div class='text-nowrap'>limit : {{ $sub['complete_date'] }}</div>
                    {{-- Buttons --}}
                    <div class='d-flex'>
                        {{-- Edit Button --}}
                        <form action="/editsubgoal" method='POST'>
                            @csrf
                            <input type="hidden" value='{{ $sub['id'] }}' name='subgoalid'>
                            <button type='submit' class="btn btn-outline-primary mx-1">Edit</button>
                        </form>
                        {{-- delete Button --}}
                        <form action="/deletesubgoal" method='POST'>
                            @csrf
                            <input type="hidden" value='{{ $sub['id'] }}' name='subgoalid'>
                            <input type="hidden" value='{{ $sub['title'] }}' name='title'>
                            <input type="hidden" value='{{ $cer_goal['id'] }}' name='goalid'>
                            <button type='submit' class="btn btn-outline-danger mx-2">×</button>
                        </form>
                        {{-- <button type="button" class="btn btn-outline-danger mx-2" onclick="location.href='/deletesubgoal'">×</button> --}}
                        {{-- Upload Button --}}
                        <button type=”submit” class="btn btn-outline-{{ $sub_colors[$sub['id']] }}" form="fm{{ $sub['id'] }}">Upload</button>
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
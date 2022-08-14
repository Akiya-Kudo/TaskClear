@extends('layout.layout')

@section('title', 'サブゴール入力フォーム')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    {{-- サイドバー --}}
    <x-menu :goals="$goals" />

    {{-- 入力フォーム --}}
    <main class='form-signin pt-3'>

        {{-- タイトル --}}
        <div class=''>
            <h1 class='h2 text-center text-success fw-bolder'>Decide Intermidiate Goals</h1>
            <h3 class='h4 text-center text-success'> 中間目標を決める ~好きな数設定しよう~</h3>
            {{-- ゴール名 --}}
            <div class='goal bg-success bg-opacity-50 shadow  border-success rounded-4 m-3 p-2 d-flex flex-column justify-content-evenly align-items-center'>
                <div class='leftcontent my-2 min-m-item'>
                    <h1>{{ $cer_goal['title'] }}</h1>
                </div>
                <div class='rightcontent m-2 fs-5'>Limit : {{ $cer_goal['complete_date'] }}</div>
            </div>
        </div>

        <hr class="text-success">

        {{-- 入力フォーム --}}
        <form class=' w-100 ' action="/makesubgoal" method='POST'>
            @csrf
            <div class='d-flex flex-wrap justify-content-evenly'>
                <div class='form-a flex-fill my-2 mx-5'>
                    <h5 class='text-success text-center'>中間目標を設定する</h5>
                    {{-- サブゴール --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text"  name='subgoal' required autofocus>
                        <label class='text-success fw-bolder' for="floatingInput">Your Sub Goal</label>
                    </div>
                    {{-- メモ --}}
                    <div class='form-floating mt-3'>
                        <textarea class='form-control' id='floatingInput' name='memo' cols="20" rows="5"></textarea>
                        <label class='text-success fw-bolder' for="floatingInput">Memo</label>
                    </div>
                    {{-- タイムリミット --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="date" name='complete_date' required>
                        <label class='text-success fw-bolder' for="floatingInput">Limit</label>
                    </div>
                </div>

                {{-- リスト入力 --}}
                <div class='form-a flex-fill my-2 mx-5 d-flex flex-column flex-wrap'>
                    <h5 class='text-success text-center'>To Do List を登録する</h5>
                    {{-- To Do list 1 --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text"  name='list1'>
                        <label class='text-success fw-bolder' for="floatingInput">List 1</label>
                    </div>
                    {{-- To Do list 2 --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text" name='list2'>
                        <label class='text-success fw-bolder' for="floatingInput">List 2</label>
                    </div>
                    {{-- To Do list 3 --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text" name='list3'>
                        <label class='text-success fw-bolder' for="floatingInput">List 3</label>
                    </div>
                    {{-- To Do list 4 --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text" name='list4'>
                        <label class='text-success fw-bolder' for="floatingInput">List 4</label>
                    </div>
                    {{-- To Do list ５ --}}
                    <div class='form-floating mt-3'>
                        <input class='form-control' id='floatingInput' type="text" name='list5'>
                        <label class='text-success fw-bolder' for="floatingInput">List 5</label>
                    </div>

                </div>
            </div>

            <input type="hidden" value="{{ $cer_goal['id'] }}" name='goalid'>
            <button type="submit" class="btn btn-outline-success w-100 btn-lg" >登録する</button>

        </form>

        {{-- today日付 --}}
        <div class='pt-1'>
            <h5 class='pt-3 m-2'>today : {{ \Carbon\Carbon::today()->format("y/m/d") }}</h5>
        </div>
    </main>
</body>
@endsection
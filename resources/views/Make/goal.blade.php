@extends('layout.layout')

@section('title', 'ゴール入力フォーム')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10'>

    {{-- トップバー --}}
    {{-- サイドバー --}}
    <x-menu :goals="$goals" />

    {{-- 入力フォーム --}}
    <main class='form-signin'>
        <form class='pt-3 w-75 container ' action="/makegoal" method='POST'>
            @csrf

            {{-- タイトル --}}
            <h1 class='h2 text-center text-success fw-bolder'>What is your Goal</h1>
            <hr class="text-success">

            {{-- ゴール --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="text" placeholder='Goal' name='goal' required autofocus>
                <label class='text-success fw-bolder' for="floatingInput">Your Goal</label>
            </div>
            {{-- タグ --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="text" placeholder='tag' name='tag' required>
                <label class='text-success fw-bolder' for="floatingInput">Tag</label>
            </div>
            {{-- メモ --}}
            <div class='form-floating mt-3'>
                <textarea class='form-control' id='floatingPassword' placeholder='memo' name='memo' cols="20" rows="5" required></textarea>
                <label class='text-success fw-bolder' for="floatingPassword">Memo</label>
            </div>
            {{-- タイムリミット --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="date" name='complete_date' required>
                <label class='text-success fw-bolder' for="floatingPassword">Limit</label>
            </div>

            {{-- Today日付 --}}
            <div class='pt-3'>
                <button type="submit" class="btn btn-outline-success w-100 btn-lg" >次へ</button>
                <h5 class='pt-3'>today : {{ \Carbon\Carbon::today()->format("y/m/d") }}</h5>
            </div>

        </form>
    </main>
</body>
@endsection
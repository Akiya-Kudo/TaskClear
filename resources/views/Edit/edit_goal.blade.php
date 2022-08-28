@extends('layout.layout')

@section('title', 'ゴール編集フォーム')

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
        <form class='pt-3 w-75 container ' action="/editgoal/submit" method='POST'>
            @csrf

            {{-- タイトル --}}
            <h1 class='h2 text-center text-success fw-bolder'>Edit your Goal</h1>
            <hr class="text-success">

            {{-- ゴール --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="text" placeholder='Goal' name='goal' value="{{ $goal['title'] }}" required autofocus>
                <label class='text-success fw-bolder' for="floatingInput">Your Goal</label>
            </div>
            {{-- タグ --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="text" placeholder='tag' name='tag' value="{{ $goal['tag'] }}" required>
                <label class='text-success fw-bolder' for="floatingInput">Tag</label>
            </div>
            {{-- メモ --}}
            <div class='form-floating mt-3'>
                <textarea class='form-control' id='floatingPassword' placeholder='memo' name='memo' cols="20" rows="5" required>{{ $goal['memo'] }}</textarea>
                <label class='text-success fw-bolder' for="floatingPassword">Memo</label>
            </div>
            {{-- タイムリミット --}}
            <div class='form-floating mt-3'>
                <input class='form-control' id='floatingInput' type="date" name='complete_date' value="{{ $goal['complete_date'] }}" required>
                <label class='text-success fw-bolder' for="floatingPassword">Limit</label>
            </div>
            {{-- color選択 --}}
            <select class="form-select form-select-sm mt-3" id='color' name='color' aria-label=".form-select-sm example" required>
                <option class="text-success" value="">select the Color</option>
                <option class="" value="success">Green</option>
                <option class="" value="danger">Wine Red</option>
                <option class="" value="primary">Ocean Blue</option>
                <option class="" value="warning">Cheese</option>
                <option class="" value="info">Peach</option>
            </select>
        
            {{-- Today日付 --}}
            <div class='pt-3'>
                <input type="hidden" value="{{ $goal['id'] }}" name='goalid'>
                <button type="submit" class="btn btn-outline-success w-100 btn-lg" >次へ</button>
                <h5 class='pt-3'>today : {{ \Carbon\Carbon::today()->format("y/m/d") }}</h5>
            </div>

        </form>
    </main>
    <script>
        const color = '{{ $goal['color'] }}';

        if (color === 'success') {
            colorNumber = 1;
        } else if (color === 'danger') {
            colorNumber = 2;
        } else if (color === 'primary') {
            colorNumber = 3;
        } else if (color === 'warning') {
            colorNumber = 4;
        } else if (color === 'info') {
            colorNumber = 5;
        }

        window.onload = function() {
            document.getElementById('color').options[colorNumber].selected = true;
        }
    </script>
</body>
@endsection
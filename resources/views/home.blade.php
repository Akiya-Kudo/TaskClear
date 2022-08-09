@extends('layout.layout')
@section('title', 'ホーム画面')
@section('content')
<body>
    <div class='container'>
        <div class='mt-5'>
            <x-alert type='success' :session="session('login_success')"/>
            <h3>プロフィール</h3>
            <ul>
                <li class='h4'>user name : {{ Auth::user()->username }}</li>
                <li class='h4'>email : {{ Auth::user()->email }}</li>
            </ul>
            <form action="{{ route('logout') }}" method='POST'>
                @csrf
                <input class='btn btn-lg btn-success' type="submit" value='Log out'>
            </form>
        </div>
    </div>
</body>
@endsection
@extends('layout.layout')

@section('title', '５００エラー')

@section('stylesheet')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<body class='bg-dark bg-opacity-10 d-flex justify-content-center align-items-center' style="height: 500px; ">
    <div class='d-flex flex-column justify-content-center align-items-center'>
        <h3 class='fw-lighter'>何かしらのエラーが発生しました。Homeに戻ってやり直してください</h3>
        <h5><a class='text-decoration-none text-alert' href="/home">Home</a></h5>
</div>
</body>
@endsection
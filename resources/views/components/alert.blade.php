    {{-- ログアウトセッションメッセージ --}}
    @if ($session)
        <div class='alert alert-{{ $type }} m-3'>
            {{ $session }}
        </div>
    @endif
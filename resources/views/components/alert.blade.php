    {{-- ログアウトセッションメッセージ --}}
    @if ($session)
        <div class='alert alert-{{ $type }} mt-5'>
            {{ $session }}
        </div>
    @endif
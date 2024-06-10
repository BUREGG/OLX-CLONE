@extends('layouts.app')
@section('content')
<head>
    <title>Wiadomosci</title>
</head>
<body>
    <h1>Twoje wiadomości</h1>
<?php
?>
    @foreach ($conversations as $conversation)
        <p>
            <a href="{{ route('conversations.show', $conversation) }}">
                Rozmowa z {{ $conversation->users->where('id', '!=', Auth::id())->first()->name }}
                @if ($conversation->products->isNotEmpty())
                odnośnie "{{ $conversation->products->first()->name }}"
            @endif
            </a>
        </p>
    @endforeach
</body>
</html>
@endsection

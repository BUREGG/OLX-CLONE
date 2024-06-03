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
    <form action="{{ route('conversations.create') }}" method="POST">
        @csrf
        <label for="receiver_id">Napisz wiadomość do:</label>
        <select name="receiver_id" required>
            @foreach ($users as $user)
                @if ($user->id !== Auth::id())
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
            @endforeach
        </select>
        <button type="submit">Start</button>
    </form>
</body>
</html>
@endsection

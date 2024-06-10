@extends('layouts.app')
@section('content')
<head>
    <title>Konwersacja</title>
</head>
<body>
    <h1>Konwersacja z {{ $conversation->users->where('id', '!=', Auth::id())->first()->name }} {{$conversation->name}}</h1>

    <div>
        @foreach ($messages as $message)
            <p>
                <strong>{{ $message->sender->name }}:</strong> 
                {{ $message->content }} <br>
                <small>{{ $message->created_at }}</small>
            </p>
        @endforeach
    </div>

    <form action="{{ route('messages.store', $conversation) }}" method="POST">
        @csrf
        <textarea name="content" rows="3" required></textarea><br>
        <button type="submit">Send</button>
    </form>

    <a href="{{ route('conversations.index') }}">Cofnij do moich wiadomości</a>
</body>
</html>
@endsection

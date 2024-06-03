@extends('layouts.app')
@section('content')
<head>
    <title>Chat</title>
</head>
<body>
    <h1>Chat</h1>

    @if (Auth::check())
        <form action="{{ route('chat.store') }}" method="POST">
            @csrf
            <textarea name="content" rows="3" required></textarea><br>
            <label for="receiver_id">To:</label>
            <select name="receiver_id" required>
                @foreach ($users as $user)
                    @if ($user->id !== Auth::id())
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select><br>
            <button type="submit">Send</button>
        </form>
    @else
        <p>You need to <a href="{{ route('login') }}">login</a> to send messages.</p>
    @endif

    <hr>

    <div>
        @foreach ($messages as $message)
            <p>
                <strong>{{ $message->sender->name }} to {{ $message->receiver->name }}:</strong> 
                {{ $message->content }} <br>
                <small>{{ $message->created_at }}</small>
            </p>
        @endforeach
    </div>
</body>
@endsection

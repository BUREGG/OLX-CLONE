@extends('layouts.app')
@section('content')

    <head>
        <title>Chat Laravel Pusher | Edlin App</title>
        <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

        <link rel="stylesheet" href="{{ asset('js/style.css') }}">


    </head>

    <body>
        <div class="chat">
            <div class="top">
                <img src="{{ asset('js/3551739.jpg') }}" alt="Avatar" width="100" height="100">
                <div>
                    <p>{{ Auth::user()->name }}</p>                    
                    <small>Online</small>
                </div>
            </div>
            <div class="messages">
                @include('receive', ['message' => ''])

            </div>
            <div class="bottom">
                <form>
                    <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                    <button type="submit"></button>
                </form>
            </div>
        </div>
    </body>

    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'eu'
        });
        const channel = pusher.subscribe('public');
        channel.bind('chat', function(data) {
            $.post("/receive", {
                    _token: '{{ csrf_token() }}',
                    message: data.message,
                })
                .done(function(res) {
                    $(".messages > .message").last().after(res);
                    $(document).scrollTop($(document).height());
                });
        });
        $("form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("form #message").val(),
                }
            }).done(function(res) {
                $(".messages > .message").last().after(res);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
            });
        });
    </script>
@endsection

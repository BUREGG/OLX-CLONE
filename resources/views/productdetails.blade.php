@extends('layouts.app')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }

        h1,
        h2 {
            text-align: center;
        }

        .ogloszenie {
            margin-top: 20px;
        }

        .ogloszenie img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif

    <body>
        <div class="container">
            <h1>{{ $product->name }}</h1>
            <div class="ogloszenie">

                <h2>Cena: {{ $product->price }}</h2>
                <p>Opis produktu: {!! $product->description !!}</p>
                <p>Lokalizacja: {{ $product->address }}</p>
                @if (auth()->check())
                    <p>Kontakt: {{ $product->user->phone_number }}</a></p>
                @else
                    <p>Kontakt: Zaloguj się, aby odsłonić numer</p>
                @endif
                @foreach ($product->images as $item)
                    <img src="{{ asset('storage/images/' . $item->image) }}" alt="Zdjęcie produktu">
                @endforeach
            </div>
            <a>Wyświetleń:{{$product->views}}</a>

        </div>
        <a href="{{ route('conversations.start', ['id' => $product->id]) }}">Napisz wiadomość</a>

    </body>
    @endsection

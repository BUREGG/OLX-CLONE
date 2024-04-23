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
    h1, h2 {
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
  <?php
  //dd($product);
  ?>
  </head>
  <body>
    <div class="container">
      <h1>{{$product->name}}</h1>
      <div class="ogloszenie">
        <img src="{{ asset('storage/images/'. $product->images->first()->image) }}" alt="Zdjęcie produktu">
        <h2>Cena: {{$product->price}}</h2>
        <p>Opis produktu: {{$product->description}}</p>
        <p>Lokalizacja: {{$product->address}}</p>
        <p>Kontakt: 123-456-789</a></p>
      </div>
    </div>
@endsection
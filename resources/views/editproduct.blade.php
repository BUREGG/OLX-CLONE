@extends('layouts.app')

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <form action="{{ url('/updateproduct/' . $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="">Opis</label>
            <input type="text" name="description" value="{!! $product->description !!}" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="">Cena</label>
            <input type="text" name="price" value="{{ $product->price }}" class="form-control" />
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Aktualizuj</button>
        </div>
    @endsection

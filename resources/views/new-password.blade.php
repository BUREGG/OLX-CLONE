@extends('layouts.app')

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <form action="{{ route('password.resetpost') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
       
        <input type="text" name="token" hidden value="{{ $token }}">
        <div class="mb-3">
            <label for="">email</label>
            <input type="email" name="email" class="form-control" id="email"/>
        </div>
        <div class="mb-3">
            <label for="">nowe haslo</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="mb-3">
            <label for="">powtórz hasło</label>
            <input type="password" name="password_confirmation" class="form-control"/>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Wyslij</button>
        </div>
    @endsection

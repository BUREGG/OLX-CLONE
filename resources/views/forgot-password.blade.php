@extends('layouts.app')
 
@section('content')

<form action="{{route('password.post')}}" method="POST">
    @csrf
    @method('POST')


<div class="mb-3">
    <label for="">email</label>
    <input type="email" name="email" class="form-control" />
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-primary">Wyslij</button>
</div>

@endsection
    
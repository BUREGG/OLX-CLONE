@extends('layouts.app')
@section('content')
<form action="{{route('editprofile.post')}}" method="POST">
    @csrf
    @method('PUT')
<h1 style="margin-top:50px">Edytuj dane</h1>
    <div class="mb-3">
        <label for="">Nazwa</label>
        <input type="text" name="name" class="form-control" style="width: 15%;" />
    </div>
    <div class="mb-3">
        <label for="">Numer telefonu</label>
        <input type="phone_number" name="phone_number" class="form-control" style="width: 15%;"/>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Zapisz</button>
    </div>
@endsection

@extends('layouts.app')
 
@section('content')

<style>
.spacer {
    height: 200px;
}


    </style>
    <div class="spacer"></div>

    
    <form method="POST" action="{{route('register.post')}}">
        @csrf
        <div class="mb-3">
            @if(session()->has("success"))
            <div class="alert alert-success">
                {{session()->get("success")}}
            </div>
            @endif
            @if(session()->has("error"))
            <div class="alert alert-danger">
                {{session()->get("error")}}
            </div>
            @endif
            <label for="exampleInputEmail1" class="form-label">Nazwa</label>
          <input type="text" class="form-control" id="name" aria-describedby="NameHelp" name="name" autofocus required>
          <label for="exampleInputEmail1" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Hasło</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Telefon</label>
          <input type="phone_number" class="form-control" id="phone_number" name="phone_number" required>
        </div>
       
        <button type="submit" action="POST" class="btn btn-primary">Zaloguj</button>

      </form>



@endsection
@extends('layouts.app')

@section('content')
    <style>
        .spacer {
            height: 200px;
        }

        .spacer2 {
            height: 20px;
        }
    </style>
    <div class="spacer"></div>

    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-error">
                    {{ session()->get('error') }}
                </div>
            @endif
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"
                autofocus required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Hasło</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Zaloguj</button>
        <div class="spacer2"></div>
        </div>
        <div class="spacer2"></div>

        <p><a class="link-opacity-100" href="{{ url('/register') }}">Nie masz konta? Zarejestruj się już teraz klikając w
                ten link!</a></p>
    </form>
    {{-- <button type="submit" class="btn btn-primary" href={{url('/auth/google/redirect')}}>google</button>  --}}
    <a href={{ url('auth/redirect') }}>Zaloguj za pomocą google</a>
    <div style="margin-top:10px">
        <a href={{ url('forgot-password') }}>Nie pamiętasz hasła ? Zresetuj je!</a>
    </div>
@endsection

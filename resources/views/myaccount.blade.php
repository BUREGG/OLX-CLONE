@extends('layouts.app')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <a href="{{ url('/editprofile') }}" class="btn btn-primary" style="margin-top: 50px">Edytuj profil</a>
    <a href="{{ url('/chart') }}" class="btn btn-primary" style="margin-top: 50px">Statystyki</a>
    <h1 style="  text-align: center; margin-top:100px">Moje ogłoszenia</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> ID </th>
                <th> Tytuł </th>
                <th> Opis </th>
                <th> Cena </th>
                <th> Zdjecie </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                @if ($item->user_id == Auth::user()->id)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{{ $item->price }}</td>
                        <td>

                            @foreach ($item->images as $image)
                                <img src="{{ asset('storage/images/' . $image->image) }}" width="170px" height="170px"
                                    alt="Zdjecie">
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('product.delete', [$item->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-2">Usun</button>
                            </form>
                            <a href="{{ url('/editproduct/' . $item->id) }}" class="btn btn-success mx-2"
                                style=margin-top:10px>Edytuj</a>
                            <form action="{{ route('product.refresh', [$item->id]) }}" method="POST"
                                style="margin-top:10px">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success mx-2">Odśwież</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('product.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn {{ $item->is_active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $item->is_active ? 'Dezaktywuj' : 'Aktywuj' }}
                                </button>
                            </form>
                            
                        </td>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection

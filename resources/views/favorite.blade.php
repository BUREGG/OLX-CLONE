@extends('layouts.app')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> Tytuł </th>
                <th> Cena </th>
                <th> Zdjecie </th>

            </tr>
        </thead>
        <tbody>

            @foreach ($products as $item)
                @php
                    $is_favorite = $item->product_users
                        ->where('user_id', Auth::user()->id)
                        ->contains('product_id', $item->id);
                @endphp
                @if ($is_favorite)
                    <tr>
                    <tr onclick="window.location='{{ url('/productdetails/' . $item->id) }}';" style="cursor:pointer;">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <img src="{{ asset('storage/images/' . $item->images->first()->image) }}" width="170px"
                                height="170px" alt="Zdjecie">
                        </td>
                        <td style="vertical-align: bottom;">Dodano: {{ $item->created_at->format('Y-m-d H:i') }}
                        <td>
                            @php
                                $is_favorite = $item->product_users
                                    ->where('user_id', Auth::user()->id)
                                    ->contains('product_id', $item->id);
                            @endphp

                            @if ($is_favorite)
                                <form action="{{ route('deletefavorite', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit">Usuń z ulubionych</button>
                                </form>
                            @else
                                <form action="{{ route('addfavorite', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit">Dodaj do ulubionych</button>
                                </form>
                            @endif
                        </td>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection

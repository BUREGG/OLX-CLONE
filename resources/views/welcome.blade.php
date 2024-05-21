@extends('layouts.app')
@if (Session::has('error'))
    <div class="alert alert-danger mt-2">{{ Session::get('error') }}
    </div>
@endif
@section('content')
    <div style="margin-top:50px; max-width: 400px;" class="list-group" id="myList" role="tablist">
        @foreach ($categories as $category)
            <div class="category">
                <a style="margin-top:5px" class="list-group-item list-group-item-action" data-toggle="list"
                    href="{{ url('/category/' . $category->id) }}" role="tab">{{ $category->name }}</a>
                <ul class="subcategory">
                    @foreach ($category->children as $child)
                        <a style="margin-top:5px" class="list-group-item list-group-item-action" data-toggle="list"
                            href="{{ url('/category/' . $child->id) }}" role="tab">{{ $child->name }}</a>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    <table class="table table-bordered table-striped">
    <tbody>
    <div>
        @foreach ($products as $item)
        <tr>
        <tr onclick="window.location='{{ url('/productdetails/' . $item->id) }}';" style="cursor:pointer;">
            <td>Tytuł: {{ $item->name }}</td>
            <td>Cena: {{ $item->price }}</td>
            <td>


                @if ($item->images->isNotEmpty())
                    <img src="{{ asset('storage/images/' . $item->images->first()->image) }}" width="170px"
                        height="170px" alt="Zdjecie">
                @endif
            </td>
            <td style="vertical-align: bottom;">Dodano: {{ $item->refresh->format('Y-m-d H:i') }} Lokalizacja:
                {{ $item->address }}
                <td>
                    @if (auth()->check())
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
                    @endif
                </td>
             
    @endforeach
    </div>
</tbody>
    </table>
    <style>
        .subcategory {
            display: none;
        }

        .category:hover .subcategory {
            display: block;
        }
    </style>
@endsection

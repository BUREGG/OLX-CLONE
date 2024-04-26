@extends('layouts.app')
@section('content')
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
            <?php
            //dump($product)
            ?>

            @foreach ($product as $item)
                @if ($item->user_id == Auth::user()->id)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->price }}</td>
                        <td>

                            @foreach ($item->images as $image)
                                <img src="{{ asset('storage/images/' . $image->image) }}" width="170px" height="170px"
                                    alt="Zdjecie">
                            @endforeach
                        </td>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection

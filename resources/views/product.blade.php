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
       
        @foreach ($product as $item)
        <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->price}}</td>
                <td>
                @php
                    $images = DB::table('images')->where('product_id', $item->id)->get();
                @endphp
    
                @foreach ($images as $image)
                    <img src="{{ asset('storage/images/'. $image->image) }}" width="170px" height="170px" alt="Zdjecie">
                @endforeach
            </td>
        @endforeach
    </tbody>
</table>

@endsection
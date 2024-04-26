@extends('layouts.app')
@section('content')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> Tytuł </th>
                <th> Cena </th>
                <th> Zdjecie </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $items = $category->product;
            $items = $category->products->reverse();
            ?>
            @foreach ($items as $item)
                <tr>
                <tr onclick="window.location='{{ url('/productdetails/' . $item->id) }}';" style="cursor:pointer;">
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>


                        @foreach ($item->images as $image)
                            <img src="{{ asset('storage/images/' . $image->image) }}" width="170px" height="170px"
                                alt="Zdjecie">
                        @endforeach
                    </td>
            @endforeach
        </tbody>
    </table>
@endsection

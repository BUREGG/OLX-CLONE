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
      $product=$product->reverse();
      ?>
        @foreach ($product as $item)
        <tr>
                    <tr onclick="window.location='{{ url('/productdetails/'.$item->id) }}';" style="cursor:pointer;">
                <td>{{$item->name}}</td>
                <td>{{$item->price}}</td>
                <td>
          
    
                @foreach ($item->images as $image)
                    <img src="{{ asset('storage/images/'. $image->image) }}" width="170px" height="170px" alt="Zdjecie">
                @endforeach
            </td>
            <td style="vertical-align: bottom;">Dodano: {{$item->created_at->format('Y-m-d H:i')}}<td>
        @endforeach
    </tbody>
</table>

@endsection
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
            //dd($category);
            $items = $products;
            $items = $products->reverse();
            ?>
            @foreach ($items as $item)
                <tr>
                <tr onclick="window.location='{{ url('/productdetails/' . $item->id) }}';" style="cursor:pointer;">
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>


                        @if ($item->images->isNotEmpty())
                            <img src="{{ asset('storage/images/' . $item->images->first()->image) }}" width="170px"
                                height="170px" alt="Zdjecie">
                        @endif
                    </td>
                    <td>
                        @php
                        $is_favorite = $item->product_users->where('user_id', Auth::user()->id)->contains('product_id', $item->id);
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
            @endforeach
        </tbody>
    </table>
@endsection

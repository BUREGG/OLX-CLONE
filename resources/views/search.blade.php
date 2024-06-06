@extends('layouts.app')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <table class="table table-bordered table-striped">

        <tbody>
            <?php
            
            if (request()->sort == 'ascending') {
                $products = $products->sortBy('price');
            } elseif (request()->sort == 'descending') {
                $products = $products->sortByDesc('price');
            } else {
                $products = $products->sortByDesc('refresh');
            }
            ?>
            <hr width="100%" size="2">

            @if ($products->count() == 0)
                <p><strong>Nie znaleziono ogłoszeń</strong></p>
            @else
                <p><strong>Wszystkich ogłoszeń: {{ $products->count() }}</strong></p>
            @endif

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
        </tbody>
    </table>
@endsection

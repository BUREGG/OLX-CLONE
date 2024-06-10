@extends('layouts.app')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <h6 style="margin-top:3px;margin-bottom:3px">Filtrowanie:</h6>
    <form action="{{ route('filtr') }}">
        <div class="mb-3">
            <label for="">Cena od:</label>
            <input type="text" name="lowestprice" class="form-control" style="width: 15%;" required />
        </div>
        <div class="mb-3">
            <label for="">Cena do:</label>
            <input type="text" name="highestprice" class="form-control" style="width: 15%;" required />
        </div>
        <button type="submit" class="btn btn-primary">Zastosuj</button>
    </form>
    <h6 style="margin-top:3px">Sortowanie:</h6>
    <form action="{{ route('product.display') }}">
        <select name="sort" id="" class="form control input-sm" style="margin-bottom:10px">
            <option value="">Wybierz opcję</option>
            <option value="ascending">Od najtanszych</option>
            <option value="descending">Od najdrozszych</option>
        </select>
        <button type="submit" class="btn btn-primary">Zastosuj</button>
    </form>

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


    {{-- {{$products->links('pagination::bootstrap-4')}} --}}
@endsection

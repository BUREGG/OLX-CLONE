@extends('layouts.app')
@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
    <?php
    $url = Request::url();
    $parts = explode('/', $url);
    $id = end($parts);
    ?>
    <form action="{{ route('filtrcategory',['id'=>$id])}}">
        <div class="mb-3">
            <label for="">Cena od:</label>
            <input type="text" name="lowestprice" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="">Cena do:</label>
            <input type="text" name="highestprice" class="form-control" required />
        </div>
        <button type="submit">Zastosuj</button>
    </form>
    <table class="table table-bordered table-striped">
        <tbody>
            <?php
            $items = $products;
            $items = $products->sortByDesc('refresh');
            ?>
            @foreach ($items as $item)
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

                    <td style="vertical-align: bottom;">Dodano: {{ $item->created_at->format('Y-m-d H:i') }} Lokalizacja:
                        {{ $item->address }}

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
            @endforeach
        </tbody>
    </table>
@endsection

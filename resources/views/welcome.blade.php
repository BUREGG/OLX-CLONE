@extends('layouts.app')

@section('content')
<a href="{{ url('/product') }}" class="btn btn-primary">Pokaz wszystkie ogłoszenia</a>
    <div style="margin-top:50px; max-width: 400px;" class="list-group" id="myList" role="tablist">
        @foreach ($categories as $category)
            <div class="category">
                <a style="margin-top:5px" class="list-group-item list-group-item-action" data-toggle="list"
                    href="{{ $category->name }}" role="tab">{{ $category->name }}</a>
                <ul class="subcategory">
                    @foreach ($category->children as $child)
                        <a style="margin-top:5px" class="list-group-item list-group-item-action" data-toggle="list"
                            href="{{ $child->name }}" role="tab">{{ $child->name }}</a>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <style>
        .subcategory {
            display: none;
        }

        .category:hover .subcategory {
            display: block;
        }
    </style>
@endsection

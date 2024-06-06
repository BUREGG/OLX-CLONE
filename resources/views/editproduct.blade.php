@extends('layouts.app')

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
        </div>
    @endif
     <!-- include libraries(jQuery, bootstrap) -->
     {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 
     <!-- include summernote css/js -->
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <div class="container mt-5">
      
    <form action="{{ url('/updateproduct/' . $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="">Opis</label>
            <textarea class="form-control" id="description" name="description" rows="10" required></textarea>
        </div>
        <div class="mb-3">
            <label for="">Cena</label>
            <input type="text" name="price" value="{{ $product->price }}" class="form-control" />
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Aktualizuj</button>
        </div>
        <script>
            $(document).ready(function() {
                var description = {!! json_encode($product->description) !!};
        
                $('#description').val(description);
        
                $('#description').summernote({
                    placeholder: 'description...',
                    tabsize: 2,
                    height: 300,
                });
            });
        </script>
    @endsection

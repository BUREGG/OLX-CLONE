@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Dodaj ogłoszenie</div>
                    <div class="card-body">
                        <form action="{{ route('addproduct') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Tytuł</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Opis</label>
                                <textarea class="form-control" id="description" name="description" rows="10" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Cena</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            @php
                                $categories = \App\Models\Category::whereNotNull('parent_id')->get();
                            @endphp
                            <div class="container">
                                <div class="row">
                                    <div>
                                        <h6>Kategoria</h6>

                                        <select name="category" id="" class="form control input-sm">
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6>Lokalizacja</h6>
                                <div id="map" style="height: 400px;"></div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                            </div>
                            <script>
                                $('#description').summernote({
                                    placeholder: 'description...',
                                    tabsize:2,
                                    height:300
                                });
                            </script>
                            
                            <script>
                             
                                var map = L.map('map').setView([51.7592, 19.4554], 13);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                var marker = L.marker([51.5, -0.09], {
                                    draggable: true
                                }).addTo(map);

                                marker.on('dragend', function(event) {
                                    var marker = event.target;
                                    var position = marker.getLatLng();
                                    document.getElementById('latitude').value = position.lat;
                                    document.getElementById('longitude').value = position.lng;
                                });
                            </script>
                            <script>
                                function setMarkerToCurrentLocation() {
                                    if ("geolocation" in navigator) {
                                        navigator.geolocation.getCurrentPosition(function(position) {
                                            var lat = position.coords.latitude;
                                            var lng = position.coords.longitude;
                                            var newLatLng = new L.LatLng(lat, lng);
                                            marker.setLatLng(newLatLng);
                                            map.setView(newLatLng);
                                            document.getElementById('latitude').value = lat;
                                            document.getElementById('longitude').value = lng;
                                        });
                                    } else {
                                        alert("Geolokalizacja nie jest obsługiwana w twojej przeglądarce.");
                                    }
                                }
                            </script>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" onclick="setMarkerToCurrentLocation()">Ustaw
                                    na aktualną lokalizację</button>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Zdjęcie</label>
                                <input type="file" accept=".jpg, .jpeg, .png" class="form-control" id="image"
                                    name="image[]" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Dodaj ogłoszenie</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    
    ?>
@endsection
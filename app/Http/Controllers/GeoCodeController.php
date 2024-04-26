<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GeoCodeController extends Controller
{
    public function reverseGeocode(Product $product)
    {
        // dd($products);

        $latitude = $product->latitude;
        $longitude = $product->longitude;

        $url = sprintf(
            'https://nominatim.openstreetmap.org/reverse?lat=%s&lon=%s&format=json',
            $latitude,
            $longitude
        );
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ];
        // Wykonujemy zapytanie HTTP do usługi Nominatim
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // Parsujemy odpowiedź JSON
        $location = json_decode($response);


        $product->update([
            ''
        ]);

        // Sprawdzamy, czy udało się odczytać nazwę miejscowości
        if (isset($location->address->city)) {
            // Zwracamy nazwę miejscowości
            return $location->address->city;
        } elseif (isset($location->address->town)) {
            // Alternatywnie, jeśli nazwa miejscowości nie jest dostępna, zwracamy nazwę miejscowości alternatywnej
            return $location->address->town;
        } else {
            // Jeśli nie można znaleźć nazwy miejscowości, zwracamy pusty string
            return '';
        }

        // Jeśli nie ma żadnych rekordów w tabeli Product, zwracamy pusty string
        return '';
    }
}

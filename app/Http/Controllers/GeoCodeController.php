<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GeoCodeController extends Controller
{
    public function reverseGeocode()
    {
        $firstProduct = Product::select('latitude', 'longitude')->first(); // Pobierz pierwszy rekord z kolumnami latitude i longitude
    
        if ($firstProduct) { // Upewnij się, że rekord istnieje
            $latitude = $firstProduct->latitude; // Pobierz wartość latitude z pierwszego rekordu
            $longitude = $firstProduct->longitude; // Pobierz wartość longitude z pierwszego rekordu
    
            // Tworzymy URL zapytania do usługi Nominatim
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
            $data = json_decode($response);
    
            // Sprawdzamy, czy udało się odczytać nazwę miejscowości
            if (isset($data->address->city)) {
                // Zwracamy nazwę miejscowości
                return $data->address->city;
            } elseif (isset($data->address->town)) {
                // Alternatywnie, jeśli nazwa miejscowości nie jest dostępna, zwracamy nazwę miejscowości alternatywnej
                return $data->address->town;
            } else {
                // Jeśli nie można znaleźć nazwy miejscowości, zwracamy pusty string
                return '';
            }
        } else {
            // Jeśli nie ma żadnych rekordów w tabeli Product, zwracamy pusty string
            return '';
        }
    }
    
}

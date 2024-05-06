<?php
namespace App\Services;

use App\Models\Product;

class GeoCodeService {
    public function reverseGeocode(Product $product)
    {

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
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $location = json_decode($response);


        $product->update([
            ''
        ]);

        if (isset($location->address->city)) {
            return $location->address->city;
        } elseif (isset($location->address->town)) {
            return $location->address->town;
        } else {

            return '';
        }
    }
    
}
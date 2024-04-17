<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PhotoApiController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image'
        ]);

        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $path = $file->store('photos', 'public');

        $filePath = storage_path('app/public/' . $path);

        if (file_exists($filePath)) {
            $exifData = @exif_read_data($filePath);





            
            if ($exifData) {
                Log::info('EXIF Data:', $exifData);

                $imageInfo = $this->get_image_info($filePath);
                $latitude = $imageInfo['latitude'];
                $longitude = $imageInfo['longitude'];
                $taken_at = $imageInfo['taken_at'];

                $addressDetails = $this->reverseGeocodeAddress($imageInfo['latitude'], $imageInfo['longitude']);

                if (!$addressDetails) {
                    return response()->json(['message' => 'Failed to reverse geocode address'], 422);

                }







                
                $photo = new Photo([
                    'filename' => $filename,
                    'path' => $path,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'taken_at' => $taken_at,
                ]);

                $photo->save();

                $data = [
                    'photo' => $photo->toArray(),
                    'addressDetails' => $addressDetails
                ];
                return response()->json([
                    'message' => 'Photo téléchargée et données enregistrées',
                    'data' => $data
                ]);
               
            } else {
                Log::error('No EXIF data found for file: ' . $filePath);
                return response()->json(['message' => 'No EXIF data found'], 422);
            }
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }

    
   
    
        
    }

    private function get_image_info($image)
    {
        $exif = exif_read_data($image, 0, true);
        if ($exif && isset($exif['GPS'])) {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude = $exif['GPS']['GPSLongitude'];

            $latitude = $this->gps2decimal($GPSLatitude, $GPSLatitudeRef);
            $longitude = $this->gps2decimal($GPSLongitude, $GPSLongitudeRef);

            $taken_at = isset($exif['IFD0']['DateTime']) ? $exif['IFD0']['DateTime'] : null;
         
            return ['latitude' => $latitude, 'longitude' => $longitude, 'taken_at' => $taken_at];
        } else {
            return false;
        }
    }


    private function gps2decimal($coordinate, $hemisphere)
    {
        $degrees = count($coordinate) > 0 ? $this->gps2Num($coordinate[0]) : 0;
        $minutes = count($coordinate) > 1 ? $this->gps2Num($coordinate[1]) : 0;
        $seconds = count($coordinate) > 2 ? $this->gps2Num($coordinate[2]) : 0;

        $flip = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        $decimal = $flip * ($degrees + ($minutes / 60) + ($seconds / (60 * 60)));

        return $decimal;
    }

    private function gps2Num($part)
    {
        $parts = explode('/', $part);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    public function reverseGeocodeAddress($latitude, $longitude)
    {
        $apiKey = config('services.here.api_key'); 
    
      
        $url = "https://revgeocode.search.hereapi.com/v1/revgeocode";
        $url .= "?at=" . urlencode("{$latitude},{$longitude}");
        $url .= "&limit=1";
        $url .= "&apiKey=" . urlencode($apiKey);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
          
        ])->get($url);

      
        if ($response->successful()) {
            $data = $response->json();
           

            if (!empty($data['items'])) {
                $addressDetails = $data['items'][0];
               
                return $addressDetails;
               
            }
           
        } else {
            Log::error('Lappel à API de géocodage inversé a échoué', [
                'réponse' => $response->body(),

                'statut' => $response->status()
            ]);
            return null; 
        }
    }
    
}

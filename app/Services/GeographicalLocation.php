<?php

namespace App\Services;

use App\Models\AnalyticsUrl;
use App\Models\MappingUrl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GeographicalLocation implements IGeographicalLocation
{
    public function saveUserGeographicalLocationData(MappingUrl $mappingUrl, string $IP)
    {
        $analyticsData = $this->getGeographicalLocationDataBasedOnIp($IP);

        $analyticsUrl = new AnalyticsUrl;
        $analyticsUrl->visitor_IP = $analyticsData["ip"] ?? "N/A";
        $analyticsUrl->country = $analyticsData["country"] ?? "N/A";
        $analyticsUrl->city = $analyticsData["city"] ?? "N/A";
        $analyticsUrl->region = $analyticsData["region"] ?? "N/A";
        $analyticsUrl->visited_at = now();
        // $analyticsUrl->coordinates = DB::raw("ST_GeomFromText('POINT(23.7104 90.4074)', 4326)");
        $analyticsUrl->coordinates = $analyticsData["coordinates"] ?? "N/A";

        $mappingUrl->analyticsUrls()->save($analyticsUrl);
    }

    public function getGeographicalLocationDataBasedOnIp(string $IP): array
    {
        $userIp = "103.73.227.177";
        $response = Http::get("https://ipinfo.io/{$userIp}/json");

        /**
         * IP response data
         *  {
         *      "ip": "103.73.227.177",
         *      "city": "Dhaka",
         *      "region": "Dhaka Division",
         *      "country": "BD",
         *      "loc": "23.7104,90.4074",
         *      "org": "AS134146 SAM ONLINE",
         *      "postal": "1000",
         *      "timezone": "Asia/Dhaka",
         *      "readme": "https://ipinfo.io/missingauth"
         *  }
         */
        if ($response->successful()) {
            $data = $response->json();

            $geographicalLocationData = [
                'ip' => $data['ip'],
                'city' => $data['city'] ?? 'N/A',
                'region' => $data['region'] ?? 'N/A',
                'country' => $data['country'] ?? 'N/A',
                'coordinates' => $data['loc'] ?? 'N/A',
            ];
            return $geographicalLocationData;
        }
        return [
            "ip" => $IP
        ];
    }
}

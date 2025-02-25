<?php

namespace App\Services;

use App\Models\MappingUrl;

interface IGeographicalLocation
{
    public function saveUserGeographicalLocationData(MappingUrl $mappingUrl, string $IP);
    public function getGeographicalLocationDataBasedOnIp(string $IP): array;
}

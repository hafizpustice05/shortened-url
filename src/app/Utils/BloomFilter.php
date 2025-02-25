<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use lastguest\Murmur;

class BloomFilter
{
    private array $bitArray;
    private int $size;
    private int $hashFunctions;

    public function __construct(int $size = 1000, int $hashFunctions = 3)
    {
        $this->size          = $size;
        $this->bitArray      = array_fill(0, $size, 0);
        $this->hashFunctions = $hashFunctions;
    }

    private function getHashes(string $item): array
    {
        $hashes = [];
        for ($i = 0; $i < $this->hashFunctions; $i++) {
            $hash = intval(Murmur::hash3($item . $i));
            Log::debug('Hash: ' . $hash);
            $hashes[] = abs($hash) % $this->size;
        }
        return $hashes;
    }

    public function add(string $item): void
    {
        foreach ($this->getHashes($item) as $hash) {
            $this->bitArray[$hash] = 1;
        }
    }

    public function mightContain(string $item): bool
    {
        foreach ($this->getHashes($item) as $hash) {
            if ($this->bitArray[$hash] === 0) {
                return false; // Definitely NOT in the set
            }
        }
        return true; // Possibly in the set
    }
}

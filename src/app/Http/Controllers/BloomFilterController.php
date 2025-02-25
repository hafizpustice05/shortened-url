<?php

namespace App\Http\Controllers;

use App\Utils\BloomFilter;

class BloomFilterController extends Controller
{
    public function testBloomFilter()
    {
        $bloom = new BloomFilter(1000, 3);
        $bloom->add('apple');
        $bloom->add('banana');

        $tlds    = ['com', 'net', 'org', 'io', 'dev', 'xyz'];
        $domains = [];

        for ($i = 0; $i < 100; $i++) {
            $randomName = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 8);
            $randomTLD  = $tlds[array_rand($tlds)];
            $domain     = "{$randomName}.{$randomTLD}";
            $domains[]  = $domain;
            $bloom->add($domain);

        }

        $results = [
            'apple'  => $bloom->mightContain('apple') ? 'Possibly in set' : 'Definitely NOT in set',
            'banana' => $bloom->mightContain('banana') ? 'Possibly in set' : 'Definitely NOT in set',
            'orange' => $bloom->mightContain('orange') ? 'Possibly in set' : 'Definitely NOT in set'
        ];

        foreach ($domains as $key) {
            $results[] = $bloom->mightContain($key) ? 'Possibly in set' : 'Definitely NOT in set';
        }

        $results[] = $bloom->mightContain('hafiz.com') ? 'Possibly in set' : 'Definitely NOT in set';

        return response()->json($results);
    }
}

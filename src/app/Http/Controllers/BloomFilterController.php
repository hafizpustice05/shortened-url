<?php

namespace App\Http\Controllers;

use App\Utils\BloomFilter;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function FunctionName(Request $request)
    {
        Storage::fake('photos');

        return $request->file('image')->store('uploads', 'public');

        $response = $this->json('POST', '/photos', [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg')
        ]);

        // Assert one or more files were stored...
        Storage::disk('photos')->assertExists('photo1.jpg');
        Storage::disk('photos')->assertExists(['photo1.jpg', 'photo2.jpg']);

        // Assert one or more files were not stored...
        Storage::disk('photos')->assertMissing('missing.jpg');
        Storage::disk('photos')->assertMissing(['missing.jpg', 'non-existing.jpg']);

        // Assert that the number of files in a given directory matches the expected count...
        Storage::disk('photos')->assertCount('/wallpapers', 2);

        // Assert that a given directory is empty...
        Storage::disk('photos')->assertDirectoryEmpty('/wallpapers');
    }

    public function index()
    {
        return view('image-upload');

    }
    public function upload(Request $request)
    {
        return $request->file('file')->store('uploads', 'public');

    }

}

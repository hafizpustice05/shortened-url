<?php

namespace App\Http\Controllers;

use App\Services\ElasticsearchService;
use Illuminate\Http\Request;
use lastguest\Murmur;

class ElasticsearchController extends Controller
{
    protected $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    // Create or Update Document
    public function store(Request $request)
    {
        // return $request->all();
        // dd($this->elasticsearch);

        $item = 'hafizpustice05@gamil.com';
        $i    = 1;
        $size = 502;

        return (Murmur::hash3($item . $i));
        $response = $this->elasticsearch->indexDocument('products', $request->id, $request->all());

        return response()->json($response);
    }

    // Retrieve Document
    public function show($id)
    {
        // return $id;
        $response = $this->elasticsearch->getDocument('products', $id);
        // dd($response);
        return $response;
    }

    // Search Documents
    public function search(Request $request)
    {
        $query = [
            'query' => [
                'match' => [
                    'description' => $request->description // Misspelled version of "iPhone"
                ]

            ]
        ];

        $response = $this->elasticsearch->searchDocuments('products', $query);
        return $response;
    }

    // Delete Document
    public function destroy($id)
    {
        $response = $this->elasticsearch->deleteDocument('products', $id);
        return response()->json($response);
    }
}

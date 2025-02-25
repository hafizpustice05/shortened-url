<?php

namespace App\Services;

// use Elasticsearch\Client;
// use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Log;

class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $hosts = [
            'http://127.0.0.1:9200'
        ];

        // $this->client = $client;
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts($hosts)
            ->build();

    }

    /**
     * create schema function
     *
     * @var  indexSchema(
     *   'index' => 'my_index',
     *   'body'  => (
     *        'settings' => (
     *               'number_of_shards'   => 2,
     *               'number_of_replicas' => 0
     *            )
     *     )
     * )
     * @return void
     */
    public function createIndex(array $indexSchema)
    {
        try {
            $response = $this->client->indices()->create($indexSchema);
            return $response->asArray();

        } catch (\Exception $e) {

            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    public function indexDocument(string $index, string | int $id, array $data)
    {
        try {
            $response = $this->client->index([
                'index' => $index,
                'id'    => $id,
                'body'  => $data
            ]);

            return $response->asArray();
        } catch (\Exception $e) {
            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    public function getDocument(string $index, string | int $id)
    {
        try {
            $response = $this->client->get([
                'index' => $index,
                'id'    => $id
            ]);

            return $response->asArray();

        } catch (\Exception $e) {
            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Searching Document
     *
     * @param string $index
     * @param array $query
     * @return void
     */
    public function searchDocuments(string $index, array $query)
    {
        try {
            $response = $this->client->search([
                'index' => $index,
                'body'  => $query
            ]);

            return $response->asArray();
        } catch (\Exception $e) {
            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Deleting the document bY ID
     *
     * @param string $index
     * @param string $id
     * @return void
     */
    public function deleteDocument(string $index, string $id)
    {
        try {
            $response = $this->client->delete([
                'index' => $index,
                'id'    => $id
            ]);

        } catch (\Exception $e) {
            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Deleteing the Index
     *
     * @param string $index
     * @return void
     */
    public function deleteIndex(string $index)
    {
        $deleteParams = [
            'index' => $index
        ];
        try {
            $response = $this->client->indices()->delete($deleteParams);
            return $response->asArray();
        } catch (\Exception $e) {
            Log::error('Elastic search Error: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }
}

<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class FindItemsByKeywords
{
    private array $headers = [
        'X-EBAY-SOA-OPERATION-NAME' => 'findItemsByKeywords',
        'X-EBAY-SOA-SECURITY-APPNAME' => 'WandoInt-217b-42d8-a699-e79808dd505e',
        'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'JSON',
    ];

    private string $url = 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';

    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function search(FindItemsByKeywordsQuery $keywordsQuery)
    {
        $response = $this->client->post($this->url, [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::JSON => $keywordsQuery
        ]);

        $contents = $response->getBody()->getContents();
        $arr = json_decode($contents, true);

        dd($arr);
    }
}

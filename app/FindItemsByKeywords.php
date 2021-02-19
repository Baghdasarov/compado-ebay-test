<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use JsonException;

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

    /**
     * @param FindItemsByKeywordsQuery $keywordsQuery
     * @return Item[]
     * @throws GuzzleException|JsonException
     */
    public function search(FindItemsByKeywordsQuery $keywordsQuery): array
    {
        $response = $this->client->post($this->url, [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::JSON => $keywordsQuery
        ]);

        $contents = $response->getBody()->getContents();
        $arr = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        $searchResult = $arr['findItemsByKeywordsResponse'][0]['searchResult'][0];

        if ((int)$searchResult['@count'] === 0) {
            return [];
        }

        $items = [];

        foreach ($searchResult['item'] as $item) {
            $items[] = Item::fromArray($item);
        }

        return $items;
    }
}

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
        'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'JSON',
    ];

    private string $url = 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';

    /**
     * @var Client
     */
    private Client $client;

    public function __construct(string $appId)
    {
        $this->client = new Client();

        $this->headers['X-EBAY-SOA-SECURITY-APPNAME'] = $appId;
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

<?php


namespace App;

use JsonSerializable;
use Symfony\Component\HttpFoundation\Request;

class FindItemsByKeywordsQuery implements JsonSerializable
{
    public string $keywords;
    public ?float $maxPrice;
    public ?float $minPrice;
    public ?string $sorting;

    public int $page = 1;
    public int $perPage = 10;

    public function __construct(
        string $keywords,
        ?float $maxPrice = null,
        ?float $minPrice = null,
        ?string $sorting = null
    )
    {
        $this->keywords = $keywords;
        $this->maxPrice = $maxPrice;
        $this->minPrice = $minPrice;
        $this->sorting = $sorting;
    }

    public static function fromRequest(Request $request): self
    {
        $query = $request->query;

        return new self(
            $query->get('keywords'),
            $query->get('price_max'),
            $query->get('price_mix'),
            $query->get('sorting'),
        );
    }

    public function jsonSerialize(): array
    {
        $arr = [
            'keywords' => $this->keywords,
            'paginationInput' => [
                'pageNumber' => $this->page,
                'entriesPerPage' => $this->perPage,
            ],
        ];

        if ($this->maxPrice !== null) {
            $arr['itemFilter'][] = [
                'name' => 'MaxPrice',
                'value' => $this->maxPrice
            ];
        }

        if ($this->minPrice !== null) {
            $arr['itemFilter'][] = [
                'name' => 'MinPrice',
                'value' => $this->minPrice
            ];
        }

        return $arr;
    }
}

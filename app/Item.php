<?php


namespace App;


use JsonSerializable;

class Item implements JsonSerializable
{
    public string $provider = 'ebay';

    public string $itemId;
    public string $url;
    public float $price;
    public string $currency;
    public float $shippingCost;
    public string $title;


    public function __construct(
        string $itemId,
        string $title,
        string $url,
        float $price,
        float $shippingCost,
        string $currency,
    )
    {
        $this->itemId = $itemId;
        $this->title = $title;
        $this->url = $url;
        $this->price = $price;
        $this->shippingCost = $shippingCost;
        $this->currency = $currency;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['itemId'][0],
            $data['title'][0],
            $data['viewItemURL'][0],
            $data['sellingStatus'][0]['currentPrice'][0]['__value__'],
            $data['shippingInfo'][0]['shippingServiceCost'][0]['__value__'],
            $data['sellingStatus'][0]['currentPrice'][0]['@currencyId'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'provider' => $this->provider,
            'item_id' => $this->itemId,
            'click_out_link' => $this->url,
            'price' => $this->price,
            'price_currency' => $this->currency,
            'shipping_price' => $this->shippingCost,
            'title' => $this->title
        ];
    }
}

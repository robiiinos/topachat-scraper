<?php

namespace App\Repositories;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Contracts\TopAchatRepositoryContract;

class TopAchatRepository implements TopAchatRepositoryContract
{
    public function fetchProduct(string $uri) : Crawler
    {
        $client = new Client();

        return $client->request('GET', $uri);
    }

    public function getAttributes(Crawler $crawler) : array
    {
        return [
            'name' => $this->getName($crawler),
            'price' => $this->getPrice($crawler),
            'promoCode' => $this->getPromoCode($crawler),
            'availability' => $this->getAvailability($crawler),
        ];
    }

    private function getName(Crawler $crawler) : string
    {
        $priceNode = $crawler->filter('.fn')->last();

        return $priceNode->text();
    }

    private function getPrice(Crawler $crawler) : string
    {
        $priceNode = $crawler->filter('.priceFinal')->last();

        return $priceNode->attr('content');
    }

    private function getPromoCode(Crawler $crawler) : ?string
    {
        try {
            $promoNode = $crawler->filter('.code-promo-text')->first();

            return $promoNode->filter('span')->last()->text();
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    private function getAvailability(Crawler $crawler) : string
    {
        $availabilityNode = $crawler->filter('.cart-box')->first();

        $availabilityClass = $availabilityNode->attr('class');

        $availability = explode(' ', $availabilityClass);

        return $availability[1];
    }
}

<?php

namespace App\Repositories;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Contracts\TopAchatRepositoryContract;

class TopAchatRepository implements TopAchatRepositoryContract
{
    public function fetchProduct(string $url) : Crawler
    {
        $client = new Client();

        return $client->request('GET', $url);
    }

    public function getProductPrice(Crawler $crawler) : string
    {
        $priceNode = $crawler->filter('.priceFinal')->last();

        return $priceNode->attr('content');
    }

    public function getProductPromoCode(Crawler $crawler) : string
    {
        $promoNode = $crawler->filter('.code-promo-text')->first();

        return $promoNode->filter('span')->last()->text();
    }

    public function getProductAvailability(Crawler $crawler) : string
    {
        $availabilityNode = $crawler->filter('.cart-box')->first();

        $availabilityClass = $availabilityNode->attr('class');

        $availability = explode(' ', $availabilityClass);

        return $availability[1];

    }
}

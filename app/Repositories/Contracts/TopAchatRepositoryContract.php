<?php

namespace App\Repositories\Contracts;

use Symfony\Component\DomCrawler\Crawler;

interface TopAchatRepositoryContract
{
    public function fetchProduct(string $url) : Crawler;

    public function getProductPrice(Crawler $crawler) : string;

    public function getProductPromoCode(Crawler $crawler) : string;

    public function getProductAvailability(Crawler $crawler) : string;
}

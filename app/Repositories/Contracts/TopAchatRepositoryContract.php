<?php

namespace App\Repositories\Contracts;

use Symfony\Component\DomCrawler\Crawler;

interface TopAchatRepositoryContract
{
    public function fetchProduct(string $uri) : Crawler;

    public function getName(Crawler $crawler) : string;

    public function getPrice(Crawler $crawler) : string;

    public function getPromoCode(Crawler $crawler) : string;

    public function getAvailability(Crawler $crawler) : string;
}

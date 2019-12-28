<?php

namespace App\Repositories\Contracts;

use Symfony\Component\DomCrawler\Crawler;

interface TopAchatRepositoryContract
{
    public function fetchProduct(string $uri) : Crawler;

    public function getAttributes(Crawler $crawler) : array;
}

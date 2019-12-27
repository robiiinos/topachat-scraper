<?php

namespace App\Console\Commands;

use App\Product;
use App\Repositories\TopAchatRepository;
use Illuminate\Console\Command;

class AddNewProduct extends Command
{
    /**
     * @var TopAchatRepository
     */
    private $topAchatRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:new {--uri=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->topAchatRepository = new TopAchatRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uri = $this->option('uri');
        if (!$uri) {
            // Ask for the product uri.
            $uri = $this->ask('What is the product uri ?');
        }

        $productCrawler = $this->topAchatRepository->fetchProduct($uri);

        $name = $this->topAchatRepository->getName($productCrawler);
        $price = $this->topAchatRepository->getPrice($productCrawler);
        $promoCode = $this->topAchatRepository->getPromoCode($productCrawler);
        $availability = $this->topAchatRepository->getAvailability($productCrawler);

        $this->alert('Name : ' . $name);
        $this->warn('Price : ' . $price . ' €');
        if ($promoCode) {
            $this->warn('Promo code : ' . $promoCode);
        }
        $this->warn('Availability : ' . $availability);

        if ($this->confirm('Do you want to add this product ?')) {
            Product::create([
                'name' => $name,
                'uri' => $uri,
                'price' => $price,
                'promo_code' => $promoCode,
                'availability' => $availability,
            ]);
        }
    }
}

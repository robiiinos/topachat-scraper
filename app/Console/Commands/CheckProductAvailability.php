<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;
use App\Repositories\TopAchatRepository;

class CheckProductAvailability extends Command
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
    protected $signature = 'product:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check a product information by scraping his uri.';

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
     *
     * @throws \Exception
     */
    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product)
        {
            $productCrawler = $this->topAchatRepository->fetchProduct($product->uri);

            // As TopAchat return a 200 - OK instead of a 301 - Moved Permanently, the only way
            // to check if a product is not available anymore is to check if we have been
            // redirected by checking the client response uri.

            $uri = $productCrawler->getUri();
            if ($uri === $product->uri) {
                $price = $this->topAchatRepository->getPrice($productCrawler);
                $promoCode = $this->topAchatRepository->getPromoCode($productCrawler);
                $availability = $this->topAchatRepository->getAvailability($productCrawler);

                if ($availability === 'en-stock') {
                    $product->update([
                        'price' => $price,
                        'promo_code' => $promoCode,
                        'is_available' => true,
                    ]);

                    $this->info('This product is in stock.');
                } elseif ($availability === 'en-cours-de-reappro') {
                    $product->update([
                        'price' => $price,
                        'promo_code' => $promoCode,
                        'is_available' => false,
                    ]);

                    $this->info('This product is being resupplied (not in stock at the moment).');
                } elseif ($availability === 'stock-epuise') {
                    $product->update([
                        'is_available' => false,
                    ]);

                    $this->info('This product has reached End Of Life (EOL) and will not be resupplied.');
                } else {
                    $this->info('Could not determine if the product is in stock or not; the key was : ' . $availability[1] . '.');
                }
            } else {
                // The product is not available anymore in their catalog.
                $product->update([
                    'is_available' => false,
                ]);

                $product->delete();

                $this->info('This product has been delisted.');
            }
        }
    }
}

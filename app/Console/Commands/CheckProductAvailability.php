<?php

namespace App\Console\Commands;

use App\Mail\ProductUpdate;
use App\Product;
use Illuminate\Console\Command;
use App\Repositories\TopAchatRepository;
use Illuminate\Support\Facades\Mail;

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
                $name = $this->topAchatRepository->getName($productCrawler);

                $price = $this->topAchatRepository->getPrice($productCrawler);
                $promoCode = $this->topAchatRepository->getPromoCode($productCrawler);

                $availability = $this->topAchatRepository->getAvailability($productCrawler);

                // Update the current model.
                $product->name = $name;
                $product->price = $price;
                $product->promo_code = $promoCode;
                $product->availability = $availability;

                if ($product->isDirty()) {
                    // Send a email with the previous attribute value.
                    Mail::send(new ProductUpdate($product, $product->getOriginal('availability')));

                    $product->save();
                }
            } else {
                // The product is not available anymore in their catalog.
                $product->availability = 'delisted';
                $product->delete();

                Mail::send(new ProductUpdate($product, $product->getOriginal('availability')));

                $this->info('This product has been delisted.');
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Product;
use Goutte\Client;
use Illuminate\Console\Command;

class CheckProductAvailability extends Command
{
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
    protected $description = 'Check a product information by scraping his url.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            $client = new Client();
            $response = $client->request('GET', $product->url);

            // As TopAchat return a 200 - OK instead of a 301 - Moved Permanently, the only way
            // to check if a product is not available anymore is to check if we have been
            // redirected by checking the client response url.

            $url = $response->getUri();
            if ($url === $product->url) {
                $availabilityNode = $response->filter('.cart-box')->first();
                $priceNode = $response->filter('.priceFinal')->last();

                $availabilityClass = $availabilityNode->attr('class');
                $priceContent = $priceNode->attr('content');

                $availability = explode(' ', $availabilityClass);
                if ($availability[1] === 'en-stock') {
                    $product->update([
                        'price' => $priceContent,
                        'is_available' => true,
                    ]);

                    $this->info('This product is in stock.');
                } elseif ($availability[1] === 'en-cours-de-reappro') {
                    $product->update([
                        'price' => $priceContent,
                        'is_available' => false,
                    ]);

                    $this->info('This product is being resupplied (not in stock at the moment).');
                } elseif ($availability[1] === 'stock-epuise') {
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

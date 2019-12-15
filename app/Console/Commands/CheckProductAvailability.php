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
    protected $signature = 'product:check:availability';

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
                $node = $response->filter('.cart-box')->first();
                $class = $node->attr('class');

                $availability = explode(' ', $class);
                if ($availability[1] === 'en-stock') {
                    $product->update([
                        'is_available' => true,
                    ]);

                    $this->info('This product is in stock.');
                } elseif ($availability[1] === 'en-cours-de-reappro') {
                    $product->update([
                        'is_available' => false,
                    ]);

                    $this->info('This product is being resupplied (not in stock at the moment).');
                } else {
                    $this->info('Could not determine if the product is in stock or not.');
                }
            } else {
                // The product is not available anymore in their catalog.

                $this->info('This product has been delisted.');
            }
        }
    }
}

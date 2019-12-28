<?php

namespace App\Console\Commands;

use App\Product;
use App\Repositories\TopAchatRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateProduct extends Command
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
    protected $signature = 'product:create {--uri=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a product.';

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

    private function validate($uri) : \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make([
            'uri' => $uri,
        ], [
            'uri' => [
                'required',
                'url',
                'unique:products,uri',
            ],
        ], [
            'uri.required' => 'You must provide an uri.',
            'uri.url' => 'You must provide a valid uri.',
            'uri.unique' => 'A product with this uri already exist.',
        ]);
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
            do {
                // Ask for the product uri.
                $uri = $this->ask('What is the product uri ?', null);
            } while ($uri === null);
        }

        $validator = $this->validate($uri);
        if ($validator->errors()->isEmpty()) {
            $productCrawler = $this->topAchatRepository->fetchProduct($uri);
            $productAttr = $this->topAchatRepository->getAttributes($productCrawler);

            $this->alert('Name : ' . $productAttr['name']);
            $this->warn('Price : ' . $productAttr['price'] . ' €');
            if ($productAttr['promoCode']) {
                $this->warn('Promo code : ' . $productAttr['promoCode']);
            }
            $this->warn('Availability : ' . $productAttr['availability']);

            if ($this->confirm('Do you want to create this product ?')) {
                Product::create([
                    'name' => $productAttr['name'],
                    'uri' => $uri,
                    'price' => $productAttr['price'],
                    'promo_code' => $productAttr['promoCode'],
                    'availability' => $productAttr['availability'],
                ]);

                $this->info($productAttr['name'] . ' has been created.');
            }

            return true;
        }

        $this->alert('An error has occurred.');
        foreach ($validator->errors()->all() as $error)
        {
            $this->warn($error);
        }

        return false;
    }
}

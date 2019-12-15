<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class AddNewProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:new';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Ask for the product name.
        $name = $this->ask('What is the product name ?');

        // Ask for the product url.
        $url = $this->ask('What is the product url ?');

        if ($this->confirm('Do you want to add this product ?')) {
            Product::create([
                'name' => $name,
                'url' => $url,
            ]);

            $this->info('Product has been created.');
        }
    }
}

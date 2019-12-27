<?php

namespace App\Mail;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The product instance.
     *
     * @var Product
     */
    public $product;

    /**
     * The product previous availability.
     *
     * @var string
     */
    public $previousAvailability;

    /**
     * Create a new message instance.
     *
     * @param Product $product
     * @param string $previousAvailability
     *
     * @return void
     */
    public function __construct(Product $product, string $previousAvailability)
    {
        $this->product = $product;

        $this->previousAvailability = $previousAvailability;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->product->availability . ' - ' . $this->product->name)
            ->markdown('mail.product.update')
            ->with([
                'previousAvailability' => $this->previousAvailability,
            ]);
    }
}

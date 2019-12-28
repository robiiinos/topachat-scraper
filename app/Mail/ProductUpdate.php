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
     * The product previous attributes.
     *
     * @var array
     */
    public $original;

    /**
     * The product changed attributes.
     *
     * @var array
     */
    public $changes;

    /**
     * Create a new message instance.
     *
     * @param Product $product
     * @param array $original
     * @param array $changes
     *
     * @return void
     */
    public function __construct(Product $product, array $original, array $changes)
    {
        $this->product = $product;

        $this->original = $original;

        $this->changes = $changes;

        unset($this->changes['created_at'], $this->changes['updated_at'], $this->changes['deleted_at']);
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
            ->view('mail.product.update', [
                'original' => $this->original,
                'changes' => $this->changes,
            ]);
    }
}

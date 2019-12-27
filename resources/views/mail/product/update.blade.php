@component('mail::message')
    # A product has been updated !

    Name : {{ $product->name }}
    Availability : {{ $product->availability }}
    Previous availability : {{ $previousAvailability }}

    Price : {{ number_format($product->price, 2, '.', ',') }} €
    @if($product->promo_code)Promo code : {{ $product->promo_code }}@endif
@endcomponent

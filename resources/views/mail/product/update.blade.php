@component('mail::message')
    # A product has been updated !

    ## What changed ?

    Attributes : {{ implode(', ', array_keys($changes)) }}.

    ### Description :

    Name : {!! $product->name !!}
    Price : {{ number_format($product->price, 2, '.', ',') }} €
    @if($product->promo_code)Promo code : {{ $product->promo_code }}@endif
    Availability : {{ $product->availability }}

    ### Previous description :

    @if(array_key_exists('name', $changes))Name : {!! $original['name'] !!}@endif

    @if(array_key_exists('price', $changes))Price : {{ number_format($original['price'] / 1e2, 2, '.', ',') }} €@endif

    @if(array_key_exists('promoCode', $changes))Promo code : {{ $original['promoCode'] }} €@endif

    @if(array_key_exists('availability', $changes))Availability : {{ $original['availability'] }}@endif
@endcomponent

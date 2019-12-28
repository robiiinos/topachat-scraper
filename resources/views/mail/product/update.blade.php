<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>
    /* Base */

    body,
    body *:not(html):not(style):not(br):not(tr):not(code) {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
        'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        box-sizing: border-box;
    }

    body {
        background-color: #f8fafc;
        color: #74787e;
        height: 100%;
        hyphens: auto;
        line-height: 1.4;
        margin: 0;
        -moz-hyphens: auto;
        -ms-word-break: break-all;
        width: 100% !important;
        -webkit-hyphens: auto;
        -webkit-text-size-adjust: none;
        word-break: break-all;
    }

    div {
        margin-top: 25px;
    }

    /* Typography */

    h1 {
        color: #3d4852;
        font-size: 19px;
        font-weight: bold;
        margin-top: 0;
        text-align: left;
    }

    a {
        color: #3869d4;
        font-size: 24px;
        font-weight: bold;
        margin-top: 0;
        text-align: center;
    }

    p {
        color: #3d4852;
        font-size: 16px;
        line-height: 1.5em;
        margin-top: 0;
        text-align: left;
    }

    span {
        font-weight: bold;
    }

    /* Layout */

    .wrapper {
        background-color: #f8fafc;
        margin: 0;
        padding: 0;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
    }

    .content {
        margin: 0;
        padding: 0;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
    }

    /* Header */

    .header {
        padding: 25px 0;
        text-align: center;
    }

    .header a {
        color: #bbbfc3;
        font-size: 19px;
        font-weight: bold;
        text-decoration: none;
        text-shadow: 0 1px 0 white;
    }

    /* Body */

    .body {
        background-color: #ffffff;
        border-bottom: 1px solid #edeff2;
        border-top: 1px solid #edeff2;
        margin: 0;
        padding: 0;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
    }

    .inner-body {
        background-color: #ffffff;
        margin: 0 auto;
        padding: 0;
        width: 570px;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 570px;
    }

    /* Footer */

    .footer {
        margin: 0 auto;
        padding: 0;
        text-align: center;
        width: 570px;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 570px;
    }

    .footer p {
        color: #aeaeae;
        font-size: 12px;
        text-align: center;
    }

    /* Tables */

    .table table {
        margin: 30px auto;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
    }

    .table th {
        border-bottom: 1px solid #edeff2;
        padding-bottom: 8px;
        margin: 0;
    }

    .table td {
        color: #74787e;
        font-size: 15px;
        line-height: 18px;
        padding: 10px 0;
        margin: 0;
    }

    .content-cell {
        padding: 35px;
    }

    /* Buttons */

    .action {
        margin-top: 0;
        margin-bottom: 30px;
        padding: 0;
        text-align: center;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
    }

    .button {
        border-radius: 3px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
        color: #fff;
        font-size: 19px;
        display: inline-block;
        text-decoration: none;
        -webkit-text-size-adjust: none;
    }

    .button-primary {
        background-color: #3490dc;
        border-top: 10px solid #3490dc;
        border-right: 18px solid #3490dc;
        border-bottom: 10px solid #3490dc;
        border-left: 18px solid #3490dc;
    }

    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="header">
                        <a href="{{ $product->uri }}" target="_blank" rel="noopener noreferrer">
                            {!! $product->name !!}
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <div>
                                        <h1>What changed ?</h1>

                                        <p><span>Attributes :</span> {{ implode(', ', array_keys($changes)) }}.</p>
                                    </div>

                                    <div>
                                        <h1>Description :</h1>

                                        <p><span>Name :</span> {!! $product->name !!}</p>

                                        <p><span>Price :</span> {{ number_format($product->price, 2, '.', ',') }} €</p>

                                        @if($product->promo_code)<p><span>Promo code :</span> {{ $product->promo_code }}</p>@endif

                                        <p><span>Availability :</span> {{ $product->availability }}</p>
                                    </div>

                                    @if(!empty($changes))
                                        <div>
                                            <h1>Previous description :</h1>

                                            @if(array_key_exists('name', $changes))
                                                <p><span>Name :</span> {!! $original['name'] !!}</p>
                                            @endif

                                            @if(array_key_exists('price', $changes))
                                                <p><span>Price :</span> {{ number_format($original['price'] / 1e2, 2, '.', ',') }} €</p>
                                            @endif

                                            @if(array_key_exists('promoCode', $changes))
                                                <p><span>Promo code :</span> {{ $original['promoCode'] }} €</p>
                                            @endif

                                            @if(array_key_exists('availability', $changes))
                                                <p><span>Availability :</span> {{ $original['availability'] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td align="center">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td>
                                                            <a href="{{ $product->uri }}" class="button button-primary" target="_blank" rel="noopener noreferrer">
                                                                View product
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="content-cell" align="center">
                                    © {{ date('Y') }} {{ env('APP_NAME') }}. @lang('All rights reserved.')
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

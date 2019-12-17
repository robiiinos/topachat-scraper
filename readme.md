# topachat-scraper

TopAchat-scraper is a CLI software, written in PHP, that allows you to monitor products on [TopAchat](https://www.topachat.com/accueil/index.php).

With this software, you can :

 - Add a new product to your watchlist,
 - Monitor the stock (or availability) of a product,
 - Monitor the price (and if any promo code applies) of a product.

## Available commands

#### 1. Add a new product - `product:new`

This command let you add a new product, that is currently being sold by TopAchat.

You will need to provide the name of the product, as well as his URL.

```shell script
$ php artisan product:new
```

*Note : you can also add products that were being sold by TopAchat at any given time in the past, but they will be set as `delisted` when the `product:check` runs.*

#### 2. Add a new product - `product:check`

This command will go through every product registered in the database, fetch his new attributes, save them; and print the current availability status in the console / log file.

```shell script
$ php artisan product:check
```

## To-Do

[1] Auto-fetch the product attributes (price, promo code, & availability) when a new product is added.

[2] Fetch the product name.

[3] ~~Switch the database to [SQLite](https://www.sqlite.org/).~~ [(5818a3e)](https://github.com/robiiinos/topachat-scraper/commit/5818a3e09df2315d033ef69af450e561006481ae)

[4] Add an optional argument to `product:new` to provide a product URL when calling the command (e.g. : `php artisan product:new --url={url}`).

[5] Clean up all unused Lumen folders & files (including routes).

[6] Add PHP-CS-Fixer.

[7] Send email when a product attribute changes (price, with or without a promo code, & availability).

## License

This is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

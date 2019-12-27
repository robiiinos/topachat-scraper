# topachat-scraper

TopAchat-scraper is a CLI software, written in PHP, that allows you to monitor products on [TopAchat](https://www.topachat.com/accueil/index.php).

With this software, you can :

 - Add a new product to your watchlist,
 - Monitor the stock (or availability) of a product,
 - Monitor the price (and if any promo code applies) of a product.

## Available commands

#### 1. Add a new product - `product:new`

This command let you add a new product, that is currently being sold by TopAchat.

You will need to provide the URI of the product, through the command line shell or a command line option. You will be prompted the product information at the end before allowing the script to store the product in the database, or not.

```shell script
# Execute the command and ask uri.
$ php artisan product:new

# Execute the command with the provided uri.
$ php artisan product:new --uri={URI}

```

*Note : you can also add products that were being sold by TopAchat at any given time in the past, but they will be set as `delisted` when the `product:check` runs.*

#### 2. Add a new product - `product:check`

This command will go through every product registered in the database, fetch his new attributes, save them; and print the current availability status in the console / log file.

```shell script
$ php artisan product:check
```

## To-Do

[1] ~~Auto-fetch the product attributes (price, promo code, & availability) when a new product is added.~~ [(768d2a7)](https://github.com/robiiinos/topachat-scraper/commit/768d2a734e9d75297a203b2f878d1200f4aa9f3b)

[2] ~~Fetch the product name.~~ [(5d21e17)](https://github.com/robiiinos/topachat-scraper/commit/5d21e17e9441c44f043640d92598563762e7da5e)

[3] ~~Switch the database to [SQLite](https://www.sqlite.org/).~~ [(5818a3e)](https://github.com/robiiinos/topachat-scraper/commit/5818a3e09df2315d033ef69af450e561006481ae)

[4] ~~Add an optional argument to `product:new` to provide a product URI when calling the command (e.g. : `php artisan product:new --uri={URI}`).~~ [(7e91acf)](https://github.com/robiiinos/topachat-scraper/commit/7e91acfb6935b1738983d00bfbf9e9380097e7c1)

[5] Clean up all unused Lumen folders & files (including routes).

[6] Add PHP-CS-Fixer.

[7] ~~Send email when a product attribute changes (price, with or without a promo code, & availability).~~ [(96eec1d)](https://github.com/robiiinos/topachat-scraper/commit/96eec1d2339b539b73918073404d6a1fe742f0b5)

[8] Add configuration from ConfigoMatic.

## License

This is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

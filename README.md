Read Product XML

## Installation

1. Begin Install Laravel latest version (Current verison used 5.7)
```
composer create-project laravel/laravel practical --prefer-dist
````

2. Install Dependancy for XML Reader
To install through composer, simply put the following in your `composer.json` file:
```json
{
    "require": {
        "laravie/parser": "^2.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "laravie/parser=^2.0"

3. Download Code from this repository

4. Database Migration with Seed
```
php artisan migrate:fresh --seed
```
5. Set XML file inside public/data/all_products.xml

6. start serve
```
php artisan serve
```

7. Read & Import XML Data to database
```
Open localhost:8080
```

## Modification files
Controller
----------
app\Http\Controllers\ProductImportController.php

Models
------
Attribute.php
Product.php
ProductAttribute.php
ProductDescription.php
ProductImage.php
StockStatus.php

Datamigration
---------
database\migrations\2019_02_02_034436_create_products_table.php
database\migrations\2019_02_02_034929_create_attributes_table.php
database\migrations\2019_02_02_034950_create_product_images_table.php
database\migrations\2019_02_02_035037_create_product_attributes_table.php
database\migrations\2019_02_02_035437_create_product_descriptions_table.php
database\migrations\2019_02_02_041142_create_stock_status_table.php
database\migrations\2019_02_02_064805_create_stock_statuses_table.php

Seeds
--------------
database\seeds\DatabaseSeeder.php


## Composer Commands e.g.

php artisan make:migration create_product_table

php artisan make:model Product

php artisan make:controller ProductImportController
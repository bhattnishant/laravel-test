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

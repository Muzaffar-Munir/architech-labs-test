# architech-labs-test

This is a proof of concept(POC) for Acme Widget Co's new sales system. 

## How It Works

1. **Initialization**: The `Basket` class is initialized with a product catalogue, delivery charge rules, and special offers.


2. **Adding Products**: Products are added to the basket using the `add` method, which takes a product code as a parameter.

3. **Calculating Total**: The `total` method calculates the total cost of the basket, applying delivery and special offer rules.

## Product Catalogue

The product catalogue is an associative array where the key is the product code and the value is an array containing the price:

```php
$catalogue = [
    'R01' => ['price' => 32.95],
    'G01' => ['price' => 24.95],
    'B01' => ['price' => 7.95],
];
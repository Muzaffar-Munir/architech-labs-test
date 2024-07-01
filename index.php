<?php

class Basket {
    private $catalogue;
    private $deliveryRules;
    private $offers;
    private $items;

    public function __construct($catalogue, $deliveryRules, $offers) {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
        $this->items = [];
    }

    public function add($productCode) {
        if (isset($this->catalogue[$productCode])) {
            $this->items[] = $productCode;
        } else {
            throw new Exception("Product code $productCode does not exist in the catalogue.");
        }
    }

    public function total() {
        $total = 0.0;
        $productCounts = array_count_values($this->items);

        foreach ($productCounts as $code => $count) {
            $price = $this->catalogue[$code]['price'];

            // special offers logic
            if ($code == 'R01' && isset($this->offers['R01'])) {
                $discountedItems = intdiv($count, 2);
                $fullPriceItems = $count - $discountedItems;
                $total += $fullPriceItems * $price + $discountedItems * $price / 2;
            } else {
                $total += $count * $price;
            }
        }

        // delivery charges flow
        if ($total < 50) {
            $total += $this->deliveryRules['under50'];
        } elseif ($total < 90) {
            $total += $this->deliveryRules['under90'];
        }

        return number_format($total, 2, '.', '');
    }
}

// product catalogues as an array
$catalogue = [
    'R01' => ['price' => 32.95],
    'G01' => ['price' => 24.95],
    'B01' => ['price' => 7.95],
];

// delivery charge rule set
$deliveryRules = [
    'under50' => 4.95,
    'under90' => 2.95,
];

// special offers
$offers = [
    'R01' => 'buy one get second half price',
];

// tried examples as given in file
try {
    $basket = new Basket($catalogue, $deliveryRules, $offers);
    $basket->add('B01');
    $basket->add('G01');
    echo "Total: $" . $basket->total() . "\n"; // output 37.85

    $basket = new Basket($catalogue, $deliveryRules, $offers);
    $basket->add('R01');
    $basket->add('R01');
    echo "Total: $" . $basket->total() . "\n"; // output 54.37

    $basket = new Basket($catalogue, $deliveryRules, $offers);
    $basket->add('R01');
    $basket->add('G01');
    echo "Total: $" . $basket->total() . "\n"; // output as 60.85

    $basket = new Basket($catalogue, $deliveryRules, $offers);
    $basket->add('B01');
    $basket->add('B01');
    $basket->add('R01');
    $basket->add('R01');
    $basket->add('R01');
    echo "Total: $" . $basket->total() . "\n"; // output 98.27
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

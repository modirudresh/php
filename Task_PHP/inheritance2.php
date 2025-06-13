<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Inheritance</title>
  <link rel="shortcut icon" href="./php.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
@include('./header.html');

?>
  <div class="page">
<!-- PHP - Overriding Inherited Methods -->
<h2>PHP - Overriding Inherited Methods</h2>
<pre>
class Fruit {
    public $name;

    public function __construct( $name ) {
        $this->name = $name;
    }

    public function intro() {
        echo "{$this->name}";
    }
}

class Apple extends Fruit {
    public $price;
    public $color;

    public function __construct( $name, $color, $price ) {
        $this->name = $name;  
        $this->color = $color;
        $this->price = $price;
    }

    public function intro() {
        echo "{$this->name} is {$this->color} and costs {$this->price}.";
    }
}

$apple = new Apple('Apple', 'red', 10000);
$apple->intro();
</pre>
<div class="output">
    <h4>Output:</h4>
<?php

class Fruit {
    public $name;

    public function __construct( $name ) {
        $this->name = $name;
    }

    public function intro() {
        echo "{$this->name}";
    }
}

class Apple extends Fruit {
    public $price;
    public $color;

    public function __construct( $name, $color, $price ) {
        $this->name = $name;  
        $this->color = $color;
        $this->price = $price;
    }

    public function intro() {
        echo "{$this->name} is {$this->color} and costs {$this->price}.";
    }
}

$apple = new Apple('Apple', 'red', 10000);
$apple->intro();

?>
</div>
</body>

</html>

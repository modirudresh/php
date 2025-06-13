<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP</title>
    <link rel="shortcut icon" href="./php.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
    <?php
  @include('./header.html');
  ?>
    <div class="page">
      <!-- Define a Class & Objects -->
      <h2>Define a Class & Objects</h2>
      <pre>
class Fruit {
  // Properties
  public $name;
  public $color;

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
}

$apple = new Fruit();
$banana = new Fruit();
$apple->set_name('Apple');
$banana->set_name('Banana');

echo $apple->get_name();
echo $banana->get_name();
</pre>
      <div class="output">

        <h4>Output:</h4>
        <?php
class Fruit {
  // Properties
  public $name;
  public $color;

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
}

$apple = new Fruit();
$banana = new Fruit();
$apple->set_name('Apple');
$banana->set_name('Banana');

echo $apple->get_name();
echo "<br>";
echo $banana->get_name();
?>
      </div>

      <!-- add two more methods to class Fruit -->
      <h2>add two more methods to class Fruit</h2>
      <pre>
class Car {
  // Properties
  public $name;
  public $color;

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
  function set_color($color) {
    $this->color = $color;
  }
  function get_color() {
    return $this->color;
  }
}

$apple = new Car();
$apple->set_name('Volvo');
$apple->set_color('Red');
echo "Name: " . $apple->get_name();
echo "Color: " . $apple->get_color();
</pre>
      <div class="output">

        <h4>Output:</h4>
        <?php
class Car {
  // Properties
  public $name;
  public $color;

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
  function set_color($color) {
    $this->color = $color;
  }
  function get_color() {
    return $this->color;
  }
}

$apple = new Car();
$apple->set_name('Volvo');
$apple->set_color('Red');
echo "Name: " . $apple->get_name();
echo "<br>";
echo "Color: " . $apple->get_color();
?>
      </div>

      <!-- PHP - instanceof -->
      <h2>PHP - instanceof</h2>
      <p style="color:red; font-size:18px; margin:5px 10px;"><strong>1. </strong>Inside the class (by adding a
        set_name() method and use $this):</p>
      <pre>
class User {
    public $name;
    function set_name($name) {
      $this->name = $name;
    }
  }
$apple = new User();
$apple->set_name("John");
  
echo $apple->name;
</pre>
      <div class="output">

        <h4>Output:</h4>
        <?php
class User {
    public $name;
    function set_name($name) {
      $this->name = $name;
    }
  }
  $apple = new User();
  $apple->set_name("John");
  
  echo $apple->name;
  ?>
      </div>


      <p style="color:red; font-size:18px; margin:5px 10px;"><strong>2. </strong>Outside the class (by directly changing
        the property value):</p>
      <pre>
class FruitName {
  public $name;
}
$apple = new FruitName();
$apple->name = "Apple";

echo $apple->name;
</pre>
      <div class="output">

        <h4>Output:</h4>
        <?php
class FruitName {
    public $name;
  }
  $apple = new FruitName();
  $apple->name = "Apple";
  
  echo $apple->name;
  ?>
      </div>

 <!-- PHP - instanceof -->
 <h2>PHP - instanceof</h2>
      <pre>
$apple = new Fruit();
var_dump($apple instanceof Fruit);
</pre>
      <div class="output">

        <h4>Output:</h4>
        <?php
$apple = new Fruit();
var_dump($apple instanceof Fruit);
?>
      </div>

      <!-- PHP - The __construct Function -->
       <h2>PHP - The __construct Function</h2>
      <pre>
      class Grocery {
  public $name;
  public $type;
  public $cart;

  function __construct($name, $type, $cart) {
    $this->name = $name;
    $this->type = $type;
    $this->cart = $cart;
  }
  function get_name() {
    return $this->name;
  }
  function get_type() {
    return $this->type;
  }
  function get_cart_status() {
    return $this->cart;
  }
}

$apple = new Grocery("Apple", "Fruit", "Added to cart");
echo $apple->get_name();
echo "<br>";
echo $apple->get_type();
echo "<br>";
echo $apple->get_cart_status();
</pre>
      <div class="output">

        <h4>Output:</h4>
       <?php
class Grocery {
  public $name;
  public $type;
  public $cart;

  function __construct($name, $type, $cart) {
    $this->name = $name;
    $this->type = $type;
    $this->cart = $cart;
  }
  function get_name() {
    return $this->name;
  }
  function get_type() {
    return $this->type;
  }
  function get_cart_status() {
    return $this->cart;
  }
}

$apple = new Grocery("Apple", "Fruit", "Added to cart");
echo $apple->get_name();
echo "<br>";
echo $apple->get_type();
echo "<br>";
echo $apple->get_cart_status();
?>
</div>

<!-- PHP - Access Modifiers -->
<h2>PHP - Access Modifiers</h2>

<pre>
class Fruit {
  public $name;
  protected $color;
  private $weight;
}

$mango = new Fruit();
$mango->name = 'Mango'; // OK
$mango->color = 'Yellow'; // ERROR
$mango->weight = '300'; // ERROR
</pre>

<p style="color:red; font-size:18px; margin:5px 10px;">In the next example we have added access modifiers to two functions. Here, if you try to call the set_color() or the set_weight() function it will result in a fatal error (because the two functions are considered protected and private), even if all the properties are public:</p>

<pre>

class Fruit {
  public $name;
  public $color;
  public $weight;

  function set_name($n) {  // a public function (default)
    $this->name = $n;
  }
  protected function set_color($n) { // a protected function
    $this->color = $n;
  }
  private function set_weight($n) { // a private function
    $this->weight = $n;
  }
}

$mango = new Fruit();
$mango->set_name('Mango'); // OK
$mango->set_color('Yellow'); // ERROR
$mango->set_weight('300'); // ERROR

</pre>
    </div>
  </body>

</html>
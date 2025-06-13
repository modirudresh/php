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
    <!-- PHP Inheritance -->
    <h2> PHP Inheritance </h2>
    <p style="color:red; font-size:18px; margin:5px 10px;">An inherited class is defined by using the <strong style="background-color:gray; color:black; border-radius:8px; padding:2px;" >extends</strong> keyword.</p>
<pre>
class Fruit {
  public $name;
  public $color;
  public function __construct($name, $color) {
    $this->name = $name;
    $this->color = $color;
  }
  public function intro() {
    echo "The fruit is {$this->name} and the color is {$this->color}.";
  }
}

// Strawberry is inherited from Fruit
class Strawberry extends Fruit {
  public function message() {
    echo "Am I a fruit or a berry? ";
  }
}
$strawberry = new Strawberry("Strawberry", "red");
$strawberry->message();
$strawberry->intro();
</pre>
    <div class="output">
    <h4>Output:</h4>
    <?php
class Fruit {
  public $name;
  public $color;
  public function __construct($name, $color) {
    $this->name = $name;
    $this->color = $color;
  }
  public function intro() {
    echo "The fruit is {$this->name} and the color is {$this->color}.";
  }
}

// Strawberry is inherited from Fruit
class Strawberry extends Fruit {
  public function message() {
    echo "Am I a fruit or a berry? ";
  }
}
$strawberry = new Strawberry("Strawberry", "red");
$strawberry->message();
echo"<br>";
$strawberry->intro();
?>

    </div>
   

  </div>
  
</body>

</html>

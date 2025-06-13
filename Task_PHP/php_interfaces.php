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
    <!-- PHP OOP - Interfaces -->
    <h2> PHP OOP - Interfaces</h2>
<pre>
interface Animal {
  public function makeSound();
}

class Cat implements Animal {
  public function makeSound() {
    echo "Meow";
  }
}

$animal = new Cat();
$animal->makeSound();
</pre>
    <div class="output">
    <h4>Output:</h4>
    <?php
interface Animal {
  public function makeSound();
}

class Cat implements Animal {
  public function makeSound() {
    echo "Meow";
  }
}

$animal = new Cat();
$animal->makeSound();
?>
</div>

<!-- PHP - Using Multiple Traits -->
<h2>PHP - Using Multiple Traits</h2>

<pre>
trait message1 {
  public function msg1() {
    echo "OOP is fun! ";
  }
}

trait message2 {
  public function msg2() {
    echo "OOP reduces code duplication!";
  }
}

class Welcome {
  use message1;
}

class Welcome2 {
  use message1, message2;
}

$obj = new Welcome();
$obj->msg1();
echo "<br>";

$obj2 = new Welcome2();
$obj2->msg1();
$obj2->msg2();
</pre>


<div class="output">
    <h4>Output:</h4>
<?php
trait message1 {
  public function msg1() {
    echo "OOP is fun! ";
  }
}

trait message2 {
  public function msg2() {
    echo "OOP reduces code duplication!";
  }
}

class Welcome {
  use message1;
}

class Welcome2 {
  use message1, message2;
}

$obj = new Welcome();
$obj->msg1();
echo "<br>";

$obj2 = new Welcome2();
$obj2->msg1();
$obj2->msg2();
?>
</div>


</div>
</body>
</html>
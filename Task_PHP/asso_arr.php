<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Arrays</title>
    <link rel="shortcut icon" href="./php.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
  @include('./header.html');
  ?>
  <div class="page">

 <!-- PHP Associative Arrays -->
 <h2>PHP Associative Arrays</h2>

<pre>
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
echo "$car";
echo (var_dump($car));
echo count($car); //to count element in array
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
echo "$car .<br/>";
echo (var_dump($car). "<br/>");
echo count($car); 
?>
</div>
<!-- Access Associative Arrays -->
<h2>Access Associative Arrays</h2>

<pre>
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
echo $cars["year"];
echo $cars["brand"];
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
echo $car["year"]. "<br/>";
echo $car["brand"];
?>
</div>

<!-- Change Value by Key name -->
<h2>Change Value by Key name</h2>

<pre>
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
$car["brand"] = "BMW";
echo $car["brand"];
echo var_dump($car);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);
$car["brand"] = "BMW";
echo $car["brand"] . "<br/>";
echo var_dump($car);   
?>
</div>


<!-- Loop Through an Associative Array -->
<h2>Loop Through an Associative Array</h2>
<pre>
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);

foreach ($car as $x => $y) {
  echo "$x: $y";
}
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);

foreach ($car as $x => $y) {
  echo "$x: $y <br>";
}
?>
</div>

<!-- add items to an associative array -->
<h2>add items to an associative array</h2>

<pre>
$cars = array("brand" => "Ford");
$cars["color"] = "Red";
$cars += ["model" => "Mustang", "year" => 1964]; //add multiple items
print_r($cars);

</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("brand" => "Ford", "model" => "Mustang");
$cars["color"] = "Red";
$cars += ["model" => "Mustang", "year" => 1964];
print_r($cars);
?>
</div>


<!-- Sort Array (Ascending Order), According to Value - asort() -->
<h2>Sort Array (Ascending Order), According to Value - asort()</h2>
<pre>
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
asort($age);
print_r($age);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
asort($age);
print_r($age);
?>
</div>

<!-- Sort Array (Descending Order), According to Value - arsort() -->
<h2>Sort Array (Descending Order), According to Value - arsort()</h2>
<pre>
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
arsort($age);
print_r($age);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
arsort($age);
print_r($age);
?>
</div>

<!-- Sort Array (Ascending Order), According to Key - ksort() -->
<h2>Sort Array (Ascending Order), According to Key - ksort()</h2>
<pre>
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
ksort($age);
print_r($age);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
ksort($age);
print_r($age);
?>
</div>

<!-- Sort Array (Descending Order), According to Key - krsort() -->
<h2>Sort Array (Descending Order), According to Key - krsort()</h2>
<pre>
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
krsort($age);
print_r($age);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
krsort($age);
print_r($age);
?>
</div>


  </div>
</body>
</html>
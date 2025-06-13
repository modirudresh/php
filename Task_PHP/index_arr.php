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
  <!-- PHP indexed Arrays -->
  <h2>PHP indexed Arrays</h2>

<pre>
$Animal = array("cat","dog","lion");
print_r( $Animal);
echo (var_dump($Animal));   
echo count($Animal);//to count element in array
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$Animal = array("cat","dog","lion");
print_r( $Animal);
echo"<br/>";
echo (var_dump($Animal). "<br/>");   
echo count($Animal);
?>
</div>

<!-- Access Indexed Arrays -->
<h2>Access Indexed Arrays</h2>

<pre>
$cars = array("Volvo", "BMW", "Toyota");
echo $cars[0];
echo $cars[2];
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("Volvo", "BMW", "Toyota");
echo $cars[0]. "<br/>";
echo $cars[2];
?>
</div>

<!-- Change Value by Index -->
<h2>Change Value by Index</h2>

<pre>
$cars = array("Volvo", "BMW", "Toyota");
$cars[0] = "mini";
echo $cars[0];
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("Volvo", "BMW", "Toyota");
$cars[0] = "mini";
echo $cars[0] . "<br/>";
echo var_dump($cars);   
?>
</div>

<!-- Loop Through an Indexed Array -->
<h2>Loop Through an Indexed Array</h2>

<pre>
$game = array("chess", "ludo", "Sudoku");
foreach ($game as $x) {
  echo "$x <br>";
}
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$game = array("chess", "ludo", "Sudoku");
foreach ($game as $x) {
  echo "$x <br>";
}
?>
</div>

<!-- array_push() function to add a new item -->
<h2>array_push() function to add a new item</h2>

<pre>
$game = array("chess", "ludo", "Sudoku");
array_push($game, "tic tac toe");
print_r($game);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$game = array("chess", "ludo", "Sudoku");
array_push($game, "tic tac toe") ;
print_r($game);
?>
</div>

<!-- Excecute a Function Item -->
<h2>Excecute a Function Item</h2>
<pre>
function myFunction() {
  echo "I come from a function!";
}

$myArr = array("Volvo", 15, myFunction());

$myArr[2];
</pre>
<div class="output">
<h4>Output:</h4>

<?php
function myFunction() {
  echo "I come from a function!";
}
$myArr = array("Volvo", 15, myFunction());
$myArr[2];
?>
</div>

<!-- Update Array Items in a Foreach Loop -->
 <h2>Update Array Items in a Foreach Loop</h2>
<pre>
$cars = array("Volvo", "BMW", "Toyota");
foreach ($cars as &$x) {
  $x = "Ford";
}
unset($x);
var_dump($cars);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("Volvo", "BMW", "Toyota");
foreach ($cars as &$x) {
  $x = "Ford";
}
unset($x);
var_dump($cars);
?>
</div>

<!-- add items to an existing array -->
 <h2>add items to an existing array</h2>

 <pre>
$fruits = array("Apple", "Banana", "Cherry");
$fruits[] = "Orange"; //add Single item
print_r($fruits);
array_push($fruits, "mango","pineapple", "guava"); //add multiple items
print_r($fruits);

</pre>
<div class="output">
<h4>Output:</h4>

<?php
$fruits = array("Apple", "Banana", "Cherry");
$fruits[] = "Orange";
print_r($fruits);
echo"<br>";
array_push($fruits, "mango","pineapple", "guava");
print_r($fruits);
?>
</div>

<!-- Remove Array Item -->
 <h2>Remove Array Item </h2>
 <pre>
$fruits = array("Apple", "Banana", "Cherry");
array_splice($fruits, 1, 1);
print_r($fruits);
unset($fruits[1]);
echo("using unset delete item:");
print_r($fruits);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$fruits = array("Apple", "Banana", "Cherry");
array_splice($fruits, 1, 1);
print_r($fruits);
echo"<br/>";
unset($fruits[1]);
echo("using unset delete item:");
print_r($fruits);

?>
</div>

<!-- Sort Array in Ascending Order - sort() -->
<h2>Sort Array in Ascending Order - sort()</h2>
<pre>
$cars = array("Volvo", "BMW", "Toyota");
$numbers = array(4, 6, 2, 22, 11);
sort($cars);
print_r($cars);
sort($numbers);
print_r($numbers);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("Volvo", "BMW", "Toyota");
$numbers = array(4, 6, 2, 22, 11);
sort($cars);
print_r($cars);
print_r("<br/>");
sort($numbers);
print_r($numbers);

?>
</div>

<!-- Sort Array in Descending Order - rsort() -->
<h2>Sort Array in Descending Order - rsort()</h2>
<pre>
$cars = array("Volvo", "BMW", "Toyota");
$numbers = array(4, 6, 2, 22, 11);
rsort($cars);
print_r($cars);
rsort($numbers);
print_r($numbers);
</pre>
<div class="output">
<h4>Output:</h4>

<?php
$cars = array("Volvo", "BMW", "Toyota");
$numbers = array(4, 6, 2, 22, 11);
rsort($cars);
print_r($cars);
print_r("<br/>");
rsort($numbers);
print_r($numbers);

?>
</div>


</div>
</body>
</html>
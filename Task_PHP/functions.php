<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP functions</title>
    <link rel="shortcut icon" href="./php.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
  @include('./header.html');
  ?>
  <div class="page">
<!-- PHP User Defined Functions -->
<h2>PHP User Defined Functions</h2>

<pre>
function Message() {
    echo "Hello world!";
  }
  Message(); //Call a Function

</pre>
<div class="output">
<h4>Output:</h4>

<?php
function Message() {
    echo "Hello world!";
  }
  Message(); 
?>
</div>
<!-- PHP Function Arguments -->
 <h2>PHP Function Arguments</h2>

 <pre>
 function welcome($firstname) {
    echo "Hello ". $firstname . "!";
  }
  welcome("Developer"); 
 </pre>
 <div class="output">
<h4>Output:</h4>
 <?php
 function welcome($firstname) {
    echo "Hello ". $firstname . "!<br/>";
  }
  welcome("Developer"); 
 ?>
</div>
<!-- function with two arguments  -->
<h2>PHP function with two arguments</h2>

<pre>
function Mymessage($firstname, $age) {
   echo "Hello ". $firstname . "!";
   echo "Age: ". $age;
 }
 Mymessage("Developer","34"); 
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function Mymessage($firstname, $age) {
    echo "Hello ". $firstname . "!<br/>";
    echo "Age: ". $age;
  }
  Mymessage("Developer","34"); 

?>
</div>

<!-- function with Default arguments value -->
<h2>PHP function with Default arguments value</h2>

<pre>
function abcd($firstname = 'User') {
    echo "Hello ". $firstname . "!<br/>";
  }
  abcd("Developer"); 
  abcd();
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function abcd($firstname = 'User') {
    echo "Hello ". $firstname . "!<br/>";
  }
  abcd("Developer"); 
  abcd();
?>
</div>
<!-- Functions - Returning values -->
<h2>PHP Functions - Returning values</h2>

<pre>
function mul($a, $b) {
    $z = $a * $b;
    return $z;
  }
  echo" 5 * 10 = ".mul(5,10);  
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function mul($a, $b) {
    $z = $a * $b;
    return $z;
  }
  echo" 5 * 10 = ".mul(5,10). "<br/>";
  
?>
</div>

<!-- Variable Number of Arguments -->
<h2>Variable Number of Arguments</h2>

<pre>
function sumMyNumbers(...$x) {
  $n = 0;
  $len = count($x);
  for($i = 0; $i < $len; $i++) {
    $n += $x[$i];
  }
  return $n;
}

$a = sumMyNumbers(5, 2, 6, 2, 7, 7);
echo $a;
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function sumMyNumbers(...$x) {
    $n = 0;
    $len = count($x);
    for($i = 0; $i < $len; $i++) {
      $n += $x[$i];
    }
    return $n;
  }
  
  $a = sumMyNumbers(5, 2, 6, 2, 7, 7);
  echo $a;
?>
</div>

<!-- Variable Number of Arguments -->
<h2>Variable Number of Arguments</h2>
<pre>
function myFamily($Age, ...$firstname) {
    $txt = "";
    $len = count($firstname);
    for($i = 0; $i < $len; $i++) {
      $txt = $txt."Hi, $firstname[$i] your age is $Age";
    }
    return $txt;
  }
  
  $a = myFamily('20',"Jane", "John", "Joey");
  echo $a;
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function myFamily($Age, ...$firstname) {
    $txt = "";
    $len = count($firstname);
    for($i = 0; $i < $len; $i++) {
      $txt = $txt."Hi, $firstname[$i] your age is $Age.<br>";
    }
    return $txt;
  }
  
  $a = myFamily('20',"Jane", "John", "Joey");
  echo $a;
  
  
  ?>
  </div>

  <!-- Return Type Declarations -->
<h2>Return Type Declarations</h2>
<pre>
function addNumbers(float $a, float $b) : float {
  return $a + $b;
}
echo addNumbers(1.2, 5.2);

function addNum(float $a, float $b) : int {
  return $a + $b;
}
echo addNum(1.2, 5.2);
</pre>
<div class="output">
<h4>Output:</h4>
<?php
function addNumbers(float $a, float $b) : float {
    return $a + $b;
  }
  echo "Addition in float format-> ". addNumbers(1.2, 5.2). "<br/>";


function addNum(float $a, float $b) : int {
  return $a + $b;
}
echo "Addition in intger format-> ". addNum(1.2, 5.2);
  ?>
  </div>
</div>
</body>
</html>
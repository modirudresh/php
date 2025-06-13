<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP Introduction</title>
    <link rel="shortcut icon" href="./php.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <?php
  @include('./header.html');
  ?>
    <div class="page">
      <!-- PHP Syntax -->
      <h2>PHP Syntax</h2>
      <pre>
echo "Hello World!";
</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
    echo "Hello World!";
    ?>
      </div>
      <br />
      <!-- PHP Variables -->
      <h2>PHP Variables</h2>
      <pre>
$X = 3;
$Y = 12;
$x = $y = $z = "Fruit";
$txt = "Hello"; 
$txt2 = "Coder!";

echo" ". $X ." ". $Y ." ". $txt ." ";
echo $X + $Y;
  </pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
    $X = 3;
    $Y = 12;
    $x = $y = $z = "Fruit";
    $txt = "Hello"; 
    $txt2 = "Coder!";

    echo" ". $X ." ". $Y ." ". $txt ." <br/>"; echo $X + $Y; ?>
      </div>

      <br />
      <!-- PHP Variable Scope -->
      <h2>PHP Variable Scope</h2>
      <pre>
$x = 'Global var'; 
function myTest() {
  echo "Variable x inside function is: $x";
} 
myTest();
echo "Variable x outside function is: $x";
</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
    $x = 'Global var'; 
    function myTest() {
    echo "Variable x inside function is: $x<br/>"; } myTest(); echo "Variable x
        outside function is: $x"; ?>
      </div>
      <br />
      <!-- PHP String -->
      <h2>PHP String</h2>
      <pre>
echo "Hello";
echo 'Hello';</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
     echo "using Double quotation(\"Hello\"): Hello <br/>"; echo 'using Single
        quotation(\'Hello\'): Hello'; ?>
      </div>
      <!-- String function -->
      <h2>PHP string functions</h2>
      <pre>
$str = 'Icreative Technolabs';
$txt = 'Hello';
$txt2 = 'Coder!';

echo strlen($str);

echo str_word_count($str);

echo strpos($str, "Techno");

echo strtoupper($str);

echo strtolower($str);

echo str_replace("Technolabs", "Technology", $str);

echo strrev($str);

$arr = explode(" ", $str);
print_r($arr);

echo $txt ." ". $txt2;

echo substr($str, 2, 6);

echo substr($str, 5);

echo substr($str, -16, 9);</pre
      >

      <div class="output">
        <h4>Output:</h4>
        <?php
    $str = 'Icreative Technolabs';
    $txt = 'Hello';
    $txt2 = 'Coder!';    
    $arr = explode(" ", $str);
    echo "String length = " . strlen($str). "<br>"; 
    echo "String word counting = " . str_word_count($str). "<br />"; 
    echo "Search For Text Within a String =" . strpos($str, "Techno"). "<br />";
    echo "Convert to Uppercase = " . strtoupper($str). "<br />";
    echo "Convert to Lowercase = " . strtolower($str). "<br />";
    echo "Replace String = " .        str_replace("Technolabs", "Technology", $str). "<br />";
    echo "Reverse a String = " . strrev($str). "<br />";
    echo 'Convert String into Array = ';
    print_r($arr);
    echo '<br />';
    echo'String Concatenation($txt + $txt2)=>'. $txt ." ". $txt2 ."<br />";
    echo "string Slicing of [$str] from 2nd pos. to 6 char. => ". substr($str, 2, 6)."<br />";
    echo "string Slice to the End [$str] from 5th pos. to end. => ". substr($str, 5). "<br />";
    echo "string Slice From the End => ". substr($str, -16, 9). "<br />"; ?>
      </div>
      <!-- PHP Numbers -->
      <h2>PHP Numbers</h2>

      <pre>
$a = 5; //int
$b = 5.34; //float
$c = "25"; //string

var_dump($a);
var_dump($b);
var_dump($c);
</pre
      >

      <div class="output">
        <h4>Output:</h4>
        <?php
$a = 5;
$b = 5.34;
$c = "25";
var_dump($a);
var_dump($b);
var_dump($c);
?>
      </div>
      <!-- PHP min() and max() Functions -->
      <h2>PHP min() and max() Functions</h2>

      <pre>
echo(min(0, 150, 30, 20, -8, -200));
echo(max(0, 150, 30, 20, -28, -200));
</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
echo"minimum number = ".(min(0, 150, 30, 20, -8, -200))."<br/>"; echo"maximum
        number = ".(max(0, 150, 30, 20, -28, -200)); ?>
      </div>
      <!-- PHP abs() Function -->
      <h2>PHP abs() Function</h2>

      <pre> echo(abs(-6.7));</pre>
      <div class="output">
        <h4>Output:</h4>
        <?php
 echo"absolute(positive) value of given number(-6.7) = ".(abs(-6.7));
?>
      </div>
      <!-- Create a PHP Constant -->
      <h2>Create a PHP Constant</h2>

      <pre>
 define("GREETING", "Welcome to coder world!");
 echo GREETING;</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
 define("GREETING", "Welcome to coder world!");
 echo GREETING;
 ?>
      </div>
      <!-- PHP const Keyword -->
      <h2>PHP const Keyword</h2>

      <pre>
 const MYCAR = "Volvo";
 echo "const MYCAR = Volvo". MYCAR;</pre
      >

      <div class="output">
        <h4>Output:</h4>
        <?php
 const MYCAR = "Volvo";
 echo "const MYCAR = Volvo <br/>". MYCAR; ?>
      </div>
      <!-- PHP - The if Statement -->
      <h2>PHP - The if Statement</h2>

      <pre>
 if (5 > 3) {
    echo "Have a good day!";
  }</pre
      >

      <div class="output">
        <h4>Output:</h4>
        <?php
 if (5 >
        3) { echo "Have a good day!"; } ?>
      </div>

      <!-- PHP switch Statement -->
      <h2>PHP switch Statement</h2>
      <pre>
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "Your favorite color is red!";
    break;
  case "blue":
    echo "Your favorite color is blue!";
    break;
  case "green":
    echo "Your favorite color is green!";
    break;
  default:
    echo "Your favorite color is neither red, blue, nor green!";
}</pre
      >

      <div class="output">
        <h4>Output:</h4>
        <?php
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "Your favorite color is red!";
    break;
  case "blue":
    echo "Your favorite color is blue!";
    break;
  case "green":
    echo "Your favorite color is green!";
    break;
  default:
    echo "Your favorite color is neither red, blue, nor green!";
}
?>
      </div>
      <!-- PHP while Loop -->
      <h2>PHP while Loop</h2>
      <pre>
 $i = 10;
while ($i < 16) {
  echo $i. "\t";
  $i++;
}
 </pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
 $i = 10;
while ($i < 16) {
  echo $i. "\t";
  $i++;
}
?>
      </div>

      <!-- break Statement -->
      <h2>break Statement</h2>
      <pre>
 $j = 1;
 while ($j < 5) {
   if ($j == 3) break;
   echo $j."\t";
   $j++;
 }
 </pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
 $j = 1;
 while ($j < 5) {
   if ($j == 3) break;
   echo $j."\t";
   $j++;
 }
 ?>
      </div>

      <!-- continue Statement -->
      <h2>continue Statement</h2>

      <pre>
 $i = 0;
while ($i < 6) {
  $i++;
  if ($i == 3) continue;
  echo $i."\t";
}
 </pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
 $i = 0;
 while ($i < 6) {
   $i++;
   if ($i == 3) continue;
   echo $i."\t";
 }
 ?>
      </div>

      <!-- PHP for Loop -->
      <h2>PHP for Loop</h2>
      <pre>
for ($x = 0; $x <= 100; $x+=10) {
  echo "The number is: $x";
}    
</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php  
for ($x = 0; $x <= 100; $x+=10) {
  echo "The number is: $x". "<br>"; } ?>
      </div>
      <!-- foreach Loop on Arrays -->
      <h2>foreach Loop on Arrays</h2>

      <pre>
 $colors = array("red", "green", "blue", "yellow");

foreach ($colors as $x) {
  echo "$x";
}
 </pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
 $colors = array("red", "green", "blue", "yellow");

 foreach ($colors as $x) {
   echo "$x <br>"; } ?>
      </div>
      <!-- Keys and Values -->
      <h2>Keys and Values</h2>

      <pre>
$members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

foreach ($members as $x => $y) {
  echo "$x : $y ";
}
</pre
      >
      <div class="output">
        <h4>Output:</h4>
        <?php
$members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43"); foreach ($members as
        $x => $y) { echo "$x : $y <br />"; } ?>
      </div>
    </div>
  </body>
</html>

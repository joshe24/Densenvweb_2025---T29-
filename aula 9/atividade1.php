<?php
$a = 12;
$b = 5;
$c = 8;

$soma = $a + $b + $c;

if ($a > 10) {
    echo "<span style='color:blue'>O resultado da soma é: $soma</span>";
} elseif ($b < $c) {
    echo "<span style='color:green'>O resultado da soma é: $soma</span>";
} elseif ($c < $a && $c < $b) {
    echo "<span style='color:red'>O resultado da soma é: $soma</span>";
} else {
    echo "O resultado da soma é: $soma";
}
?>
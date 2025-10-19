<?php
$saldo = 50;

$precos = [
    "maçã" => 5, 
    "melancia" => 8, 
    "laranja" => 4, 
    "repolho" => 3, 
    "cenoura" => 6, 
    "batatinha" => 2
];

$quantidades = [
    "maçã" => 2, 
    "melancia" => 1, 
    "laranja" => 3, 
    "repolho" => 1, 
    "cenoura" => 2, 
    "batatinha" => 4
];

$total = 0;

foreach ($precos as $produto => $preco) {
    $total += $preco * $quantidades[$produto];
}

if ($total < $saldo) {
    $restante = $saldo - $total;
    echo "<span style='color:blue'>O valor total da compra é R$ $total. Ainda restam R$ $restante para gastar.</span>";
} elseif ($total > $saldo) {
    $faltando = $total - $saldo;
    echo "<span style='color:red'>O valor total da compra é R$ $total. Faltam R$ $faltando para pagar a conta.</span>";
} else {
    echo "<span style='color:green'>O valor total da compra é exatamente R$ $saldo. Saldo esgotado.</span>";
}
?>

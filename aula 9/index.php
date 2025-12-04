<?php
 require_once 'funcoes.php';

 $valor = $_REQUEST['valor'];
 $desconto = $_REQUEST['desconto'];

 function calculaDesconto($valor, $desconto){
    if ($desconto < 0 || $desconto > 100){
        throw new Exception("Desconto inválido");
    }
    $valorComDesconto = $valor - ($valor * $desconto / 100);
    return $valorComDesconto;
 }

 echo "Valor: $valor <br>";
 echo "Desconto: $desconto <br>";
 echo "Valor com Desconto " . calcularDesconto($valor, $desconto) . "<br>"
?>
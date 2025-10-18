<?php
$valor_a_vista = 22500;
$parcelas = 60;
$valor_parcela = 489.65;

$valor_financiado = $parcelas * $valor_parcela;
$juros = $valor_financiado - $valor_a_vista;

echo "Mariazinha pagará R$ $juros apenas de juros no financiamento.";
?>

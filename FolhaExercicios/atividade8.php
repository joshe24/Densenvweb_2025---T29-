<?php
$valor_moto = 8654;
$parcelas_opcoes = [24, 36, 48, 60];
$taxa = 0.015;

foreach ($parcelas_opcoes as $i => $parcelas) {
    $juros_total = $valor_moto * $taxa * $parcelas;
    $valor_parcela = ($valor_moto + $juros_total) / $parcelas;
    echo "Parcelamento $parcelas vezes: R$ " . number_format($valor_parcela,2) . "<br>";
    $taxa += 0.005; 
}
?>

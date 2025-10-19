<?php
$valor_moto = 8654;
$parcelas_opcoes = [24, 36, 48, 60];
$taxa = 0.02; 

foreach ($parcelas_opcoes as $i => $parcelas) {
    $montante = $valor_moto * pow((1 + $taxa), $parcelas);
    $valor_parcela = $montante / $parcelas;
    echo "Parcelamento $parcelas vezes: R$ " . number_format($valor_parcela,2) . "<br>";
    $taxa += 0.003; 
}
?>

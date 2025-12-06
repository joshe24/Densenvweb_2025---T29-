<?php

$notas = [8.5, 7.0, 6.0, 9.0, 10.0];
$faltas = [0,1,0,0,1,0,0,0,1,0];

function calcularMedia($notas) {
    if (count($notas) === 0) return 0;
    return array_sum($notas) / count($notas);
}

function verificarAprovacaoNota($media) {
    return ($media >= 7) ? "Aprovado por Nota" : "Reprovado por Nota";
}

function calcularFrequencia($faltas) {
    $totalDias = count($faltas);
    $diasComFalta = array_sum($faltas);
    return (($totalDias - $diasComFalta) / $totalDias) * 100;
}

function verificarAprovacaoFrequencia($frequencia) {
    return ($frequencia >= 70) ? "Aprovado por Frequência" : "Reprovado por Frequência";
}

$media = calcularMedia($notas);
$statusNota = verificarAprovacaoNota($media);

$frequencia = calcularFrequencia($faltas);
$statusFrequencia = verificarAprovacaoFrequencia($frequencia);

echo "<h2>Resultado do Aluno</h2>";

echo "Média: " . number_format($media, 2, ',', '.') . "<br>";
echo "Status por Nota: <strong>$statusNota</strong><br><br>";

echo "Frequência: " . number_format($frequencia, 2, ',', '.') . "%<br>";
echo "Status por Frequência: <strong>$statusFrequencia</strong><br>";

?>

<?php

$pastas = array(
    "bsn" => array(
        "3a Fase" => array("desenvWeb", "bancoDados 1", "engSoft 1"),
        "4a Fase" => array("Intro Web", "bancoDados 2", "engSoft 2")
    )
);

function exibirArvore($array, $nivel = 0) {
    foreach ($array as $chave => $valor) {
        echo str_repeat("-", $nivel * 2) . " " . $chave . "<br>";
        if (is_array($valor)) {
            exibirArvore($valor, $nivel + 1);
        }
    }
}

exibirArvore($pastas);

?>

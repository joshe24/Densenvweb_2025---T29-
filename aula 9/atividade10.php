<?php
$pastas = array(
    "bsn" => array(
        "3a Fase" => array("desenvWeb", "bancoDados 1", "engSoft 1"),
        "4a Fase" => array("Intro Web", "bancoDados 2", "engSoft 2")
    )
);

function imprimeArvore($array, $nivel = 0) {
    foreach ($array as $chave => $valor) {
        $prefixo = str_repeat('-', $nivel + 1) . ' ';
        
        if (is_array($valor)) {
            echo $prefixo . $chave . PHP_EOL;
           
            imprimeArvore($valor, $nivel + 1);
        } else {
         
            echo $prefixo . $valor . PHP_EOL;
        }
    }
}
imprimeArvore($pastas);
?>

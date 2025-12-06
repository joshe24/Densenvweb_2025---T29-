<?php
     $notas = array (7,9,5,3);

     $faltas = array(1, 0, 1, 0, 1, 0, 1, 1, 0, 1);

    function calculamedia($notas){
        $soma = 0;
        $totalNotas = count($notas);
        for($nota = 0; $nota <count ($notas); $notas++){
            $soma += $notas[$nota];
        }
        $media = $soma / $totalNotas;
        return $media;
    } 
     function verificaAprovacaoNotas($media) {
        $aprovacao = ($media >= 7 );
        return $aprovacao;
     }

      function calculaMediaFaltas($faltas){
        $frequencia = 0;
        $totalFaltas = count($faltas);
        for($faltas = 0; $$faltas <count ($faltas); $faltas++){
            $frequencia += $faltas[$faltas];
        }
        $frequencia = $frequencia / $totalNotas;
        return $frequencia;
    }
     function verificaAprovacaoFaltas($frequencia) {
        $aprovacaoFaltas = ($frequencia >= 7 );
        return $aprovacaoFaltas;

     }

$pastas =array("bsn" =>

array("3a Fase" =>

array("desenvWeb","bancoDados 1", "engSoft 1"),

"4a Fase" =>

array("Intro Web",
"bancoDados 2", "engSoft 2")));

function listarpastas($pasta,  $nivel = 0){
    if(is_array($pasta)) {
        foreach($pasta as $elemento => $valor){
            if(is_array($valor)){
                echo str_repeat("-", $nivel) . $elemento . "<br>";
                listarpastas($valor,$nivel + 1);
            } else {echo str_repeat("-" , $nivel) . $valor . "<br>";
            }
        }
    } else {
        echo $pasta . "<br>";
    }
}
    
    ?>
<?php
    //incluindo o arquivo da classe pessoa
    require_once "pessoa.php";

    //instanciando a classe pessoa
    $pessoa = new Pessoa();
    $pessoa->nome = "jose";
    $pessoa->sobreNome = "augusto";

    echo $pessoa->getNomeCompleto();
?>
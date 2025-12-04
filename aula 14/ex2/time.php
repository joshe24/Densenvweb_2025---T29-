<?php
    class time{
        private $nome;
        private $anoFundacao;
        private $jogadores;
    public function __construct(){
        $this->jogadores = array();
    }
    
    public function adicionajogador($nome,$posicao,$dataNascimento){
        $this->nome = nome;
        $this->posicao = posicao;
        $this->dataNascimento = (date(dataNascimento));
    } 
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->$nome = $nome;
    }
}
?>
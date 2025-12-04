<?php
    class Pessoa{
        private $nome;
        private $sobreNome;

        public function contruct() {
            $this->nome = "";
            $this->sobreNome = "";
        }

        public function getNomeCompleto() {
            return $this->nome." ". $this->sobreNome;
        }
        public function getNome(){
            return $this->$nome;
        }
        public function getSobreNome(){
            return $this->$sobreNome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setSobreNome($sobreNome){
             $this->sobreNome = $sobreNome;
        }
    }
?>
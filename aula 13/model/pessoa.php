<?php
    class Pessoa{
        private $nome;
        private $sobreNome;
        private $dataNascimento;
        private $cpfcnpj;
        private $tipo;
        private $telefone;
        private $endereco; 
        public function construct() {
            $this-> $tipo = 1; 
            $this->dataInstancia = new DateTime;
        }
        public function getDataInstancia() {
            return $this->dataInstancia->format('d/m/Y/ H:i:s');
        }
        public function getNomeCompleto() {
            return $this->nome." ". $this->sobreNome;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getSobreNome(){
            return $this->sobreNome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setSobreNome($sobreNome){
             $this->sobreNome = $sobreNome;
        }
    }
?>
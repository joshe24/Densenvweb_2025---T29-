<?php
    class calculadora{
            private $numero1;
            private $numero2;

        public function adicao($numero1, $numero2){
            return $this->$numero1 + $this->$numero2; 
        }
        public function subtracao($numero1, $numero2){
            return $this->$numero1 - $this->$numero2;

        }
        public function divisao($numero1, $numero2){
            return $this->$numero1 / $this->$numero2;

        }
        public function multiplicador($numero1, $numero2){
            return $this->$numero1 * $this->$numero2;

        }
        
        public function getNumero1(){
            return $this->$numero1;
        }
        public function setNumero1(){
            $this->numero1 = $numero1;
        }
        public function getNumero2(){
            return $this->$numero2;
        }
        public function setNumero2(){
            $this->numero2 = $numero2;
        }

    }
?>
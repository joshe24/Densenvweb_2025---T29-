<?php
    
    class query {
        private $sql;
        private $registros;
        private $conecaoBd;
        
    public function __construct($conecaoBd){
        $this->registros = 0;
        $this->conecaoBd = conecaoBd;
    }

    public function serSql($sSql){
        $this->sqp = sSql;
    }
    }


?>
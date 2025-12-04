<?php

    $connectionString = "host=localhost port=5432 dbname=local user=postgres password=unidavi";
    $connection = pg_connect($connectionString);
    if($connection) {
        echo "Database conectado com sucesso! <br>";

        $result = pg_query($connection, "SELECT COUNT (*) AS QTDTPES FROM tbpessoa");
       
      //att1

        if($result) {
            $row = pg_fetch_assoc($result);
            echo "Quantidade de tabelas no database: ".$row['qtdtpes'];
        } else {
            echo "Erro ao executar a consulta.";
        } 
        $aDadosPessoa = array('Juan', 'Oliveira','Juan.oliveira@gmail.com', 'unidavi5', 'Amazonas', 'AM' );
        $resultInsert = pg_query_params($connection,'INSERT INTO TBPESSOA (pesnome, pessobrenome, pesemail, pespassword, pescidade, pesestado)
        VALUES ($1, $2, $3, $4, $5, $6)', $aDadosPessoa); 
        
        if($resultInsert) {
            echo "<br>Dados inseridos com sucesso!";
        }

    } else {
        echo "Erro ao conectar ao Database.";
     }

     if ($connection){
        if($result){
            echo "<table border='1px'><tr>";
            echo "<th>Nome<th>";
            echo "<th>Sobrenome<th>";
            echo "<th>Email<th>";
            echo "<th>password<th>";
            echo "<th>Cidade<th>";
            echo "<th>Estado<th>";
            echo "<tr>";
        }
        $row = pg_fetch_assoc($result);
        while($row){
            echo "<tr>";
            echo "<td>".$row['pesnome']."</td>";
            echo "<td>".$row['pessobrenome']."</td>";
            echo "<td>".$row['pesemail']."</td>";
            echo "<td>".$row['pespassword']."</td>";
            echo "<td>".$row['pescidade']."</td>";
            echo "<td>".$row['pesestado']."</td>";
            echo "<tr>"; 
                $row = pg_fetch_assoc($result);
        }  
        }
    ?>
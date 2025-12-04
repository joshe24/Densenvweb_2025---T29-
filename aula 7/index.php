<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquivo PHP</title>
</head>
<body>
    <p>Teste</p>



    <?php
       
        
        $txt = "José";
        echo "Meu nome é $txt!";
        echo "<br>";

       //nome e sobrenome em constantes 
       define("NOME", "José");
       define("SOBRENOME", "Augusto");

       $nomecompleto = NOME . "-" . SOBRENOME. "<br>";

       echo $nomecompleto;

       //atribui valores as variaveis:
       $SALARIO1 = 1000 ; 
       $SALARIO2 = 2000 ;

       echo ($SALARIO1 . "-" . $SALARIO2 . "<br>");
       
       //variavel 2 recece variavel 1
       $SALARIO2 = $SALARIO1 ; 

       echo ($SALARIO2 . "<br>");

       //10% a mais:
       $SALARIO2 = $SALARIO2 * 0.10 + $SALARIO2;

       //$SALARIO * = 1.1;
       
       echo ($SALARIO2 . "<br>");

       //incrementa 1 na variavel:
       ++$SALARIO2;

       echo($SALARIO2 . "<br>");

       //texto de saida:
       echo ("valor salario 1 = " . $SALARIO1 . "<br>" . "valor salario 2 = " . $SALARIO2 . "<br>");

       if  ($SALARIO1 > $SALARIO2) {
            echo("O valor da variável 1 é maior que o valor da variável 2" . "<br>");
        }
        else if ($SALARIO2 > $SALARIO1) {
              echo("O valor da variável 2 é maior que o valor da variável 2" . "<br>");   
        }
        else{
            echo("Os valores são iguais" . "<br>");
        }

        /* $nome = array(" aluno1 ", " aluno2 " , " aluno3 ");
        foreach($nome as $elementos);
        echo ($elementos);
        */
        
        for ($I=0; $I<101;$I++){
            $SALARIO1++;
            if ($I == 50){
                break;
            }  
        }
        echo($SALARIO1 . "<br>");

    ?>

    
    
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Instalador</title>
    </head>

    <body>
        <div>
            <?php
                switch ($_GET['step']){
                    case 2:
                        $pdo = new PDO("mysql:host=localhost;", "root", "adsse12556");
                        
                        $query = $pdo->query("CREATE DATABASE `financeiro`;");
                        
                        var_dump($query);   
                        echo "<h3>Instalação do SisFin</h3>
                              <p>Criação do banco de dados: Sucesso!</p>";
                        break;
                    default: 
                        echo "<h3>Instalação do SisFin</h3>
                              <p>Bem vindo ao serviço de instalação. Esse setup irá ajudar você com a instalação do sistema.</p>
                              <a href='?step=2'>Continuar</a>";
                        break;
                }

            ?>
            
        </div>
    </body>

</html>
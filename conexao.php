<?php
//dados da conexão
$server = "localhost";

$user = "root";

$password = "root";
$database = "db_estoque";


//função mysqli para conectar no banco de dados

$conexao = new mysqli($server,$user,$password, $database);

//verificando se tem erro na conexão

if (!$conexao){

    echo"Falha na conexão";
}


?>
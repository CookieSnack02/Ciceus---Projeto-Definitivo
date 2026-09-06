<?php 

$host = "localhost"; 
$bancoDeDados = "mydb";
$usuario = "root";
$senha = "";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$bancoDeDados", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configura para caso de erro 

}

catch(PDOException $e){
    echo "Erro na conexão: " . $e->getMessage();
}


?>
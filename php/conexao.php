<?php

/* as credenciais ficam no config.php, fora do git.
   veja o config.exemplo.php para o formato */
$config = require __DIR__ . '/config.php';

try{
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['bancoDeDados']};charset=utf8mb4",
        $config['usuario'],
        $config['senha']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configura para caso de erro

}

catch(PDOException $e){
    /* a mensagem real vai so para o log do servidor: ela traz
       usuario e host do banco. sem conexao nao ha o que fazer,
       entao a execucao para aqui em vez de seguir sem $pdo */
    error_log("Erro na conexão: " . $e->getMessage());
    http_response_code(500);
    exit("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
}


?>
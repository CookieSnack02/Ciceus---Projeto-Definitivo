<?php

/* as credenciais ficam fora do git (veja o config.exemplo.php).
   a ordem de busca e:
   1. ciceus_config.php na pasta ACIMA da pasta publica (public_html):
      o deploy pelo git nao apaga esse arquivo e ninguem acessa ele
      pelo navegador. e o lugar recomendado na hospedagem
   2. php/config.php, ao lado deste arquivo: pratico para rodar local */
$locaisConfig = [
    dirname($_SERVER['DOCUMENT_ROOT'] ?? __DIR__) . '/ciceus_config.php',
    __DIR__ . '/config.php'
];

$config = null;
foreach ($locaisConfig as $local) {
    if (is_file($local)) {
        $config = require $local;
        break;
    }
}

if (!is_array($config)) {
    /* sem isso o require dava erro fatal e o site inteiro caia
       com erro 500, sem dizer o motivo */
    error_log("Ciceus: arquivo de configuracao do banco nao encontrado em: " . implode(', ', $locaisConfig));
    http_response_code(500);
    exit("Configuração do banco de dados não encontrada.");
}

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
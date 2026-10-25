<?php
require_once '../sessao.php';
require_once '../conexao.php';

// ID do usuário logado; sem sessao volta para a tela de acesso
$idUsuario = exigirLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmPasta  = trim($_POST['nmPasta'] ?? '');
    $corPasta = trim($_POST['corPasta'] ?? '#a27b5b');

    if (!empty($nmPasta) && isset($pdo)) { //Somente se o nome da pasta existir e a conexão com o banco de dados estiver ativa
        try {
            $colocarDadosPasta = "INSERT INTO pasta (nmPasta, corPasta, ciceus_idCiceus) 
                    VALUES (:nmPasta, :corPasta, :idUsuario)";
            
            $stmt = $pdo->prepare($colocarDadosPasta);
            $stmt->bindValue(':nmPasta', $nmPasta);
            $stmt->bindValue(':corPasta', $corPasta);
            $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de erro
        }
    }
}

// Redireciona de volta para a tela de pastas
header("Location: ../../html/headers/pasta.php");
exit;
?> 
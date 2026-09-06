<?php
require_once '../conexao.php';

if (isset($_GET['id']) && isset($pdo)) {
    $idPasta = (int) $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM pasta WHERE codPasta = :id");
        $stmt->bindValue(':id', $idPasta, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Tratamento de erro
    }
}

// Redireciona de volta para a tela de pastas
header("Location: ../../html/headers/pasta.php");
exit;


<?php
// php/pasta/criar.php
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmPasta  = trim($_POST['nmPasta'] ?? '');
    $corPasta = trim($_POST['corPasta'] ?? '#a27b5b');
    
    // ID do usuário logado (ex: de $_SESSION['idUsuario'])
    $idUsuario = 1; 

    if (!empty($nmPasta)) {
        $sql = "INSERT INTO pasta (nmPasta, corPasta, ciceus_idCiceus) 
                VALUES (:nmPasta, :corPasta, :idUsuario)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nmPasta', $nmPasta);
        $stmt->bindValue(':corPasta', $corPasta);
        $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Redireciona de volta para a tela de pastas
header("Location: ../../html/headers/pasta.php");
exit;
?> 
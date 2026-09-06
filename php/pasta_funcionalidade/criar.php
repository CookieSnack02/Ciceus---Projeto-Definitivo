<?php
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmPasta  = trim($_POST['nmPasta'] ?? '');
    $corPasta = trim($_POST['corPasta'] ?? '#a27b5b');
    
    // ID do usuário logado (ex: de $_SESSION['idUsuario'])
    $idUsuario = 1; 

    if (!empty($nmPasta) && isset($pdo)) { //Somente se o nome da pasta existir e a conexão com o banco de dados estiver ativa
        try {
            // Garantir que exista um usuário na tabela ciceus para respeitar a chave estrangeira (FK)
            $checagemDeUsuario = $pdo->prepare("SELECT idCiceus FROM ciceus WHERE idCiceus = :id");
            $checagemDeUsuario->bindValue(':id', $idUsuario, PDO::PARAM_INT);
            $checagemDeUsuario->execute();

            if (!$checagemDeUsuario->fetch()) {
                $insercaoUsuario = $pdo->prepare("INSERT INTO ciceus (idCiceus, nmUsuario, emailUsuario, senhaUsuario, telefoneUsuario) VALUES (:id, 'Usuário Teste', 'teste@ciceus.com', '123456', '000000000')");
                $insercaoUsuario->bindValue(':id', $idUsuario, PDO::PARAM_INT);
                $insercaoUsuario->execute();
            }

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
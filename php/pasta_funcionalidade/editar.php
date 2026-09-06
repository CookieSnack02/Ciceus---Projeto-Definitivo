<?php
require_once '../conexao.php';

$idPasta = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pasta = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPasta = (int)($_POST['codPasta'] ?? 0);
    $nmPasta = trim($_POST['nmPasta'] ?? '');
    $corPasta = trim($_POST['corPasta'] ?? '#a27b5b');

    if (!empty($nmPasta) && $idPasta > 0 && isset($pdo)) {
        try {
            $stmt = $pdo->prepare("UPDATE pasta SET nmPasta = :nmPasta, corPasta = :corPasta WHERE codPasta = :id");
            $stmt->bindValue(':nmPasta', $nmPasta);
            $stmt->bindValue(':corPasta', $corPasta);
            $stmt->bindValue(':id', $idPasta, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Erro
        }
    }
    header("Location: ../../html/headers/pasta.php");
    exit;
}

if ($idPasta > 0 && isset($pdo)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM pasta WHERE codPasta = :id");
        $stmt->bindValue(':id', $idPasta, PDO::PARAM_INT);
        $stmt->execute();
        $pasta = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Erro
    }
}

if (!$pasta) {
    header("Location: ../../html/headers/pasta.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pasta</title>
    <link rel="stylesheet" href="../../css/headers/pasta.css">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/editar.css">
</head>
<body>
    <div class="conteudos" style="margin-left: 40px; padding: 30px;">
        <div class="edit-box">
            <h2>Editar Pasta</h2>
            <form action="editar.php" method="POST">
                <input type="hidden" name="codPasta" value="<?php echo $pasta['codPasta']; ?>">
                
                <div class="form-group">
                    <label>Nome da Pasta:</label>
                    <input type="text" name="nmPasta" value="<?php echo htmlspecialchars($pasta['nmPasta']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Cor da Pasta:</label>
                    <input type="color" name="corPasta" value="<?php echo htmlspecialchars($pasta['corPasta'] ?? '#a27b5b'); ?>">
                </div>

                <div class="edit-actions">
                    <button type="submit" class="btn-salvar"><i class="fa-solid fa-check"></i> Salvar</button>
                    <a href="../../html/headers/pasta.php" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


<?php
require_once '../sessao.php';
require_once '../conexao.php';

// sem login volta para a tela de acesso
$idUsuario = exigirLogin();

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
<?php
$tituloPagina = 'Editar pasta';
$cssPagina = '/css/headers/pasta.css';
$paginaAtual = 'pastas';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php require __DIR__ . '/../../html/componentes/cabeca.php'; ?>
</head>
<body>

<?php require __DIR__ . '/../../html/componentes/navbar.php'; ?>

    <main class="conteudos">
        <div class="pagina">

            <header class="pagina-cabecalho">
                <h1>Editar pasta</h1>
            </header>

            <form class="edit-box cartao-base" action="editar.php" method="POST">
                <input type="hidden" name="codPasta" value="<?php echo (int) $pasta['codPasta']; ?>">

                <div class="form-grupo">
                    <label for="nmPasta">Nome</label>
                    <input class="campo-entrada" id="nmPasta" type="text" name="nmPasta" maxlength="255" value="<?php echo htmlspecialchars($pasta['nmPasta']); ?>" required>
                </div>

                <div class="form-grupo">
                    <label for="corPasta">Cor</label>
                    <span class="seletor-cor">
                        <input id="corPasta" type="color" name="corPasta" value="<?php echo htmlspecialchars($pasta['corPasta'] ?? '#C08552'); ?>">
                    </span>
                </div>

                <div class="edit-acoes">
                    <button type="submit" class="botao botao-principal"><i class="ph ph-check"></i> Salvar</button>
                    <a href="../../html/headers/pasta.php" class="botao botao-secundario">Cancelar</a>
                </div>
            </form>

        </div>
    </main>

</body>
</html>

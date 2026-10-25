<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    $idUsuario = exigirLogin();

    $tituloPagina = 'Pastas';
    $cssPagina = '/css/headers/pasta.css';
    $paginaAtual = 'pastas';

    require_once __DIR__ . '/../../php/conexao.php';

    $pastas = [];
    $erroBanco = false;

    try {
        $capturaDados = $pdo->prepare("SELECT * FROM pasta WHERE ciceus_idCiceus = :idUsuario ORDER BY dtCriacaoPasta DESC");
        $capturaDados->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $capturaDados->execute();
        $pastas = $capturaDados->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // o detalhe vai para o log; na tela aparece so um aviso
        error_log("Ciceus pastas: " . $e->getMessage());
        $erroBanco = true;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php require __DIR__ . '/../componentes/cabeca.php'; ?>
</head>
<body>

<?php require __DIR__ . '/../componentes/navbar.php'; ?>

    <!-- aba de pastas -->
    <main class="conteudos">
        <div class="pagina">

            <header class="pagina-cabecalho">
                <h1>Pastas</h1>
                <p>Organize suas notas, questões e cartões por matéria.</p>
            </header>

            <?php if ($erroBanco): ?>
                <p class="aviso erro">Não foi possível carregar suas pastas. Tente novamente.</p>
            <?php endif; ?>

            <!-- formulario para criar pasta -->
            <form action="../../php/pasta_funcionalidade/criar.php" method="POST" class="form-pasta cartao-base">
                <label class="seletor-cor" title="Cor da pasta">
                    <input type="color" name="corPasta" value="#C08552" aria-label="Cor da pasta">
                </label>
                <input class="campo-entrada" type="text" name="nmPasta" placeholder="Nome da nova pasta" maxlength="255" required>
                <button class="botao botao-principal" type="submit"><i class="ph ph-plus"></i> Criar</button>
            </form>

            <!-- lista de pastas -->
            <div class="lista-pastas">
                <?php if (empty($pastas) && !$erroBanco): ?>
                    <p class="aviso">Nenhuma pasta ainda. Crie a primeira acima.</p>
                <?php endif; ?>

                <?php foreach ($pastas as $pasta): ?>
                    <?php $cor = htmlspecialchars($pasta['corPasta'] ?? '#C08552'); ?>
                    <div class="pasta-card cartao-base" style="--cor-pasta: <?php echo $cor; ?>;">
                        <div class="pasta-info">
                            <span class="pasta-icone"><i class="ph-fill ph-folder"></i></span>
                            <h2><?php echo htmlspecialchars($pasta['nmPasta']); ?></h2>
                        </div>
                        <div class="acoes">
                            <a class="botao-icone" href="../../php/pasta_funcionalidade/editar.php?id=<?php echo (int) $pasta['codPasta']; ?>" title="Editar" aria-label="Editar pasta"><i class="ph ph-pencil-simple"></i></a>
                            <a class="botao-icone perigo" href="../../php/pasta_funcionalidade/deletar.php?id=<?php echo (int) $pasta['codPasta']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta pasta?');" title="Excluir" aria-label="Excluir pasta"><i class="ph ph-trash"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </main>
    <!-- fim das pastas -->

</body>
</html>

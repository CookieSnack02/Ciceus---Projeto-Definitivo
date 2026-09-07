<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastas</title>

    <link rel="stylesheet" href="../css/headers/pasta.css">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- ================= barra lateral (fixa) ================= -->
    <aside class="barra-lateral">
        <a class="marca" href="../index.php">
            <span class="marca-simbolo"><img src="../img/ciceus.svg" alt=""></span>
            <span class="marca-nome">Ciceus</span>
        </a>

        <nav class="navegacao">
            <p class="navegacao-rotulo">Estudo</p>
            <ul>
                <li><a href="../index.php"><i class="fa-slab fa-regular fa-house"></i><span>Inicial</span></a></li>
                <li><a href="nota.php"><i class="fa-slab fa-regular fa-clipboard"></i><span>Notas</span></a></li>
                <li><a href="questao.php"><i class="fa-slab fa-regular fa-question"></i><span>Questões</span></a></li>
                <li><a href="cartoes.php"><i class="fa-slab fa-regular fa-copy"></i><span>Cartões</span></a></li>
                <li><a href="quadro.php"><i class="fa-slab fa-regular fa-rectangle-wide"></i><span>Quadro</span></a></li>
                <li><a href="pasta.php" class="ativo"><i class="fa-slab fa-regular fa-folders"></i><span>Pastas</span></a></li>
                <li><a href="tempo.php"><i class="fa-slab fa-regular fa-stopwatch"></i><span>Temporizador</span></a></li>
            </ul>
        </nav>

        <button class="conta" type="button">
            <span class="conta-icone">
                <i class="fa-slab-press fa-regular fa-circle-user icone-repouso"></i>
                <i class="fa-slab fa-regular fa-circle-user icone-ativo"></i>
            </span>
            <span class="conta-texto">
                <strong>Minha conta</strong>
                <small>Ver perfil</small>
            </span>
        </button>
    </aside>
    <!-- ================= fim da barra lateral ================= -->

    <?php
        require_once("../../php/conexao.php");

        $idUsuario = 1;
        $pastas = [];

        if (isset($pdo)) {
            try {
                $capturaDados = $pdo->prepare("SELECT * FROM pasta WHERE ciceus_idCiceus = :idUsuario ORDER BY dtCriacaoPasta DESC");
                $capturaDados->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $capturaDados->execute();
                $pastas = $capturaDados->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $erroBanco = $e->getMessage();
            }
        }
    ?>

    <main class="pagina">
        <div class="pagina-interna">

            <header class="pagina-cabecalho">
                <span class="pagina-etiqueta">Pastas</span>
                <h1>Organize por matéria</h1>
                <p class="pagina-resumo">Agrupe notas e questões em pastas para achar tudo depois sem procurar.</p>
            </header>

            <?php if (isset($erroBanco)): ?>
                <div class="aviso-erro">
                    Erro ao carregar pastas: <?php echo htmlspecialchars($erroBanco); ?>
                </div>
            <?php endif; ?>

            <!-- criação de pasta -->
            <form action="../../php/pasta_funcionalidade/criar.php" method="POST" class="form-pasta">
                <input class="campo" type="text" name="nmPasta" placeholder="Nome da pasta" required>
                <span class="seletor-cor">
                    <input type="color" name="corPasta" value="#a27b5b" title="Cor da pasta">
                </span>
                <button class="botao botao-primario" type="submit">
                    <i class="fa-slab fa-regular fa-plus"></i> Criar pasta
                </button>
            </form>

            <!-- lista -->
            <?php if (empty($pastas)): ?>
                <div class="vazio">
                    <i class="fa-slab fa-regular fa-folders"></i>
                    Nenhuma pasta ainda. Crie a primeira no campo acima.
                </div>
            <?php else: ?>
                <div class="lista-pastas">
                    <?php foreach ($pastas as $pasta): ?>
                        <?php $cor = htmlspecialchars($pasta['corPasta'] ?? '#a27b5b'); ?>
                        <div class="pasta-card">
                            <div class="pasta-info">
                                <span class="pasta-ponto" style="background-color: <?php echo $cor; ?>;"></span>
                                <h2>
                                    <?php echo htmlspecialchars($pasta['nmPasta']); ?>
                                    <?php if (!empty($pasta['dtCriacaoPasta'])): ?>
                                        <span class="pasta-data">Criada em <?php echo date('d/m/Y', strtotime($pasta['dtCriacaoPasta'])); ?></span>
                                    <?php endif; ?>
                                </h2>
                            </div>
                            <div class="acoes">
                                <a href="../../php/pasta_funcionalidade/editar.php?id=<?php echo $pasta['codPasta']; ?>" title="Editar">
                                    <i class="fa-slab fa-regular fa-pen"></i>
                                </a>
                                <a class="acao-excluir" href="../../php/pasta_funcionalidade/deletar.php?id=<?php echo $pasta['codPasta']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta pasta?');" title="Excluir">
                                    <i class="fa-slab fa-regular fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>

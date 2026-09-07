<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quadro</title>

    <link rel="stylesheet" href="../css/headers/quadro.css">
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
                <li><a href="quadro.php" class="ativo"><i class="fa-slab fa-regular fa-rectangle-wide"></i><span>Quadro</span></a></li>
                <li><a href="pasta.php"><i class="fa-slab fa-regular fa-folders"></i><span>Pastas</span></a></li>
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

    <main class="pagina">
        <div class="pagina-interna">

            <div class="quadro-topo">
                <header class="pagina-cabecalho" style="margin-bottom: 0;">
                    <span class="pagina-etiqueta">Quadro</span>
                    <h1>Espaço em branco</h1>
                    <p class="pagina-resumo">Rascunhe, esquematize e conecte ideias antes de passar a limpo.</p>
                </header>

                <div class="ferramentas">
                    <button class="ferramenta ativa" type="button" data-ferramenta="caneta" title="Caneta">
                        <i class="fa-slab fa-regular fa-pen"></i>
                    </button>
                    <button class="ferramenta" type="button" data-ferramenta="borracha" title="Borracha">
                        <i class="fa-slab fa-regular fa-eraser"></i>
                    </button>

                    <span class="ferramentas-separador"></span>

                    <button class="ferramenta" type="button" data-cor="#1C1A17" title="Preto" style="color: #1C1A17;">
                        <i class="fa-solid fa-circle" style="font-size: 11px;"></i>
                    </button>
                    <button class="ferramenta" type="button" data-cor="#A27B5B" title="Terracota" style="color: #A27B5B;">
                        <i class="fa-solid fa-circle" style="font-size: 11px;"></i>
                    </button>
                    <button class="ferramenta" type="button" data-cor="#3F6B5A" title="Verde" style="color: #3F6B5A;">
                        <i class="fa-solid fa-circle" style="font-size: 11px;"></i>
                    </button>

                    <span class="ferramentas-separador"></span>

                    <button class="ferramenta" type="button" id="limpar-quadro" title="Limpar quadro">
                        <i class="fa-slab fa-regular fa-trash"></i>
                    </button>
                </div>
            </div>

            <div class="prancheta" id="prancheta">
                <canvas id="quadro-canvas"></canvas>
                <div class="prancheta-dica">
                    <i class="fa-slab fa-regular fa-pen"></i>
                    Clique e arraste para desenhar
                </div>
            </div>

        </div>
    </main>

    <script src="../js/quadro.js"></script>

</body>
</html>

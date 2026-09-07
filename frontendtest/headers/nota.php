<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>

    <link rel="stylesheet" href="../css/headers/nota.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
                <li><a href="nota.php" class="ativo"><i class="fa-slab fa-regular fa-clipboard"></i><span>Notas</span></a></li>
                <li><a href="questao.php"><i class="fa-slab fa-regular fa-question"></i><span>Questões</span></a></li>
                <li><a href="cartoes.php"><i class="fa-slab fa-regular fa-copy"></i><span>Cartões</span></a></li>
                <li><a href="quadro.php"><i class="fa-slab fa-regular fa-rectangle-wide"></i><span>Quadro</span></a></li>
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

            <header class="pagina-cabecalho">
                <span class="pagina-etiqueta">Notas</span>
                <h1>Suas anotações</h1>
                <p class="pagina-resumo">Escreva, organize e revise o que importa. O texto fica em uma página limpa, sem distração.</p>
            </header>

            <div class="nota-acoes">
                <input class="campo nota-titulo" type="text" placeholder="Título da nota">
                <button class="botao botao-neutro" type="button"><i class="fa-slab fa-regular fa-folder"></i> Pasta</button>
                <button class="botao botao-primario" type="button"><i class="fa-slab fa-regular fa-check"></i> Salvar</button>
            </div>

            <div class="editor-caixa">
                <div id="editor-texto"></div>
            </div>

            <div class="nota-rodape">
                <span>Rascunho não salvo</span>
                <span id="contador-palavras">0 palavras</span>
            </div>

        </div>
    </main>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="../js/nota.js"></script>

</body>
</html>

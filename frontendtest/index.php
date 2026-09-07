<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciceus</title>

    <link rel="stylesheet" href="css/index.css">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- ================= barra lateral (fixa) ================= -->
    <aside class="barra-lateral">
        <a class="marca" href="index.php">
            <span class="marca-simbolo"><img src="img/ciceus.svg" alt=""></span>
            <span class="marca-nome">Ciceus</span>
        </a>

        <nav class="navegacao">
            <p class="navegacao-rotulo">Estudo</p>
            <ul>
                <li><a href="index.php" class="ativo"><i class="fa-slab fa-regular fa-house"></i><span>Inicial</span></a></li>
                <li><a href="headers/nota.php"><i class="fa-slab fa-regular fa-clipboard"></i><span>Notas</span></a></li>
                <li><a href="headers/questao.php"><i class="fa-slab fa-regular fa-question"></i><span>Questões</span></a></li>
                <li><a href="headers/cartoes.php"><i class="fa-slab fa-regular fa-copy"></i><span>Cartões</span></a></li>
                <li><a href="headers/quadro.php"><i class="fa-slab fa-regular fa-rectangle-wide"></i><span>Quadro</span></a></li>
                <li><a href="headers/pasta.php"><i class="fa-slab fa-regular fa-folders"></i><span>Pastas</span></a></li>
                <li><a href="headers/tempo.php"><i class="fa-slab fa-regular fa-stopwatch"></i><span>Temporizador</span></a></li>
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

            <header class="abertura">
                <h1>Bem-vindo(a) ao <em>Ciceus</em></h1>
                <p>Uma plataforma de estudo pessoal: reúna suas notas, questões, cartões e sessões cronometradas em um só lugar, sem ruído.</p>
            </header>

            <p class="secao-rotulo">Recursos</p>
            <div class="atalhos">
                <a class="atalho" href="headers/nota.php">
                    <i class="fa-slab fa-regular fa-clipboard"></i>
                    <h2>Notas</h2>
                    <p>Escreva e organize suas anotações de estudo.</p>
                </a>

                <a class="atalho" href="headers/questao.php">
                    <i class="fa-slab fa-regular fa-question"></i>
                    <h2>Questões</h2>
                    <p>Monte um banco de questões para praticar.</p>
                </a>

                <a class="atalho" href="headers/cartoes.php">
                    <i class="fa-slab fa-regular fa-copy"></i>
                    <h2>Cartões</h2>
                    <p>Revise por repetição com cartões de memória.</p>
                </a>

                <a class="atalho" href="headers/quadro.php">
                    <i class="fa-slab fa-regular fa-rectangle-wide"></i>
                    <h2>Quadro</h2>
                    <p>Esquematize ideias livremente em um espaço em branco.</p>
                </a>

                <a class="atalho" href="headers/pasta.php">
                    <i class="fa-slab fa-regular fa-folders"></i>
                    <h2>Pastas</h2>
                    <p>Agrupe notas e questões por matéria ou projeto.</p>
                </a>

                <a class="atalho" href="headers/tempo.php">
                    <i class="fa-slab fa-regular fa-stopwatch"></i>
                    <h2>Temporizador</h2>
                    <p>Estude em blocos de foco com pausas marcadas.</p>
                </a>
            </div>

            <section class="foco">
                <div>
                    <h2>Comece por um bloco de foco</h2>
                    <p>25 minutos de estudo contínuo, sem interrupção.</p>
                </div>
                <a class="botao botao-primario" href="headers/tempo.php">
                    <i class="fa-slab fa-regular fa-stopwatch"></i> Abrir temporizador
                </a>
            </section>

        </div>
    </main>

</body>
</html>

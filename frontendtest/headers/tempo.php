<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizador</title>

    <link rel="stylesheet" href="../css/headers/tempo.css">
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
                <li><a href="pasta.php"><i class="fa-slab fa-regular fa-folders"></i><span>Pastas</span></a></li>
                <li><a href="tempo.php" class="ativo"><i class="fa-slab fa-regular fa-stopwatch"></i><span>Temporizador</span></a></li>
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
                <span class="pagina-etiqueta">Temporizador</span>
                <h1>Bloco de foco</h1>
                <p class="pagina-resumo">Arraste o marcador para escolher a duração e comece. Você pode soltar o relógio em um pop-up flutuante e continuar navegando.</p>
            </header>

            <div class="tempo-palco">
                <div class="timer-container" id="timer-container">
                    <div class="drag-handle" id="drag-handle">
                        <i class="fa-solid fa-grip-lines"></i>
                    </div>

                    <h1>Sessão de estudo</h1>
                    <p class="timer-legenda">Arraste o marcador para ajustar</p>

                    <div class="circular-slider" id="circular-slider">
                        <svg class="slider-svg" viewBox="0 0 200 200" id="slider-svg">
                            <circle class="bg-circle" cx="100" cy="100" r="85" fill="none"></circle>
                            <circle class="progress-circle" id="progress-circle" cx="100" cy="100" r="85"
                                    fill="none" stroke-linecap="round" transform="rotate(-90 100 100)"></circle>
                            <circle class="slider-thumb" id="slider-thumb" cx="100" cy="15" r="7"
                                    style="cursor: pointer;"></circle>
                        </svg>
                        <div class="timer-display">
                            <p id="tempo" style="margin: 0;">25:00</p>
                        </div>
                    </div>

                    <div class="controls">
                        <button id="iniciar" type="button">Iniciar</button>
                        <button id="pausar" type="button">Pausar</button>
                        <button id="resetar" type="button">Resetar</button>
                    </div>

                    <div class="popup-toggle">
                        <label>
                            <input type="checkbox" id="popup-checkbox"> Abrir em pop-up flutuante
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="../js/timer.js"></script>

</body>
</html>

<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Temporizador';
    $cssPagina = '/css/headers/tempo.css';
    $paginaAtual = 'tempo';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php require __DIR__ . '/../componentes/cabeca.php'; ?>
</head>
<body>

<?php require __DIR__ . '/../componentes/navbar.php'; ?>

    <!-- conteudos -->
    <main class="conteudos">
        <div class="timer-container cartao-base" id="timer-container">
            <div class="drag-handle" id="drag-handle" title="Arraste para mover"><i class="ph ph-dots-six"></i></div>

            <h1>Temporizador</h1>
            <p class="timer-dica">Arraste o círculo para escolher de 10 a 60 minutos.</p>

            <div class="circular-slider" id="circular-slider">
                <svg class="slider-svg" viewBox="0 0 200 200" width="280" height="280" id="slider-svg">
                    <!-- fundo do circulo -->
                    <circle class="bg-circle" cx="100" cy="100" r="85" fill="none" stroke-width="10"></circle>
                    <!-- circulo de progresso -->
                    <circle class="progress-circle" id="progress-circle" cx="100" cy="100" r="85" fill="none" stroke-width="10" stroke-linecap="round" transform="rotate(-90 100 100)"></circle>
                    <!-- bolinha de controle (thumb) -->
                    <circle class="slider-thumb" id="slider-thumb" cx="100" cy="15" r="11" stroke-width="3"></circle>
                </svg>
                <div class="timer-display">
                    <p id="tempo">25:00</p>
                </div>
            </div>

            <div class="controls">
                <button class="botao botao-principal" id="iniciar"><i class="ph-fill ph-play"></i> Iniciar</button>
                <button class="botao botao-secundario" id="pausar"><i class="ph ph-pause"></i> Pausar</button>
                <button class="botao botao-secundario" id="resetar" title="Recomeçar" aria-label="Recomeçar"><i class="ph ph-arrow-counter-clockwise"></i></button>
            </div>

            <label class="popup-toggle">
                <input type="checkbox" id="popup-checkbox">
                <i class="ph ph-picture-in-picture"></i> Abrir em janela flutuante
            </label>
        </div>
    </main>
    <!-- fim dos conteudos -->

    <script src="<?php echo versao('/js/headers/timer.js'); ?>"></script>
</body>
</html>

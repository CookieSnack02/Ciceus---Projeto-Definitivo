<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Início';
    $cssPagina = '/css/style.css';
    $paginaAtual = 'inicial';

    $nomeUsuario = $_SESSION['nomeUsuario'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php require __DIR__ . '/componentes/cabeca.php'; ?>
</head>
<body>

<?php require __DIR__ . '/componentes/navbar.php'; ?>

    <!-- conteudos -->
    <main class="conteudos">
        <div class="pagina">

            <header class="pagina-cabecalho">
                <h1>Olá<?php echo $nomeUsuario !== '' ? ', ' . htmlspecialchars($nomeUsuario) : ''; ?></h1>
                <p>O que você vai estudar hoje?</p>
            </header>

            <!-- grade de atalhos para as paginas -->
            <div class="grade-paginas">

                <a class="cartao-pagina cartao-base" href="headers/nota.php">
                    <span class="icone-cartao"><i class="ph ph-clipboard-text"></i></span>
                    <h2>Notas</h2>
                    <p>Escreva e organize suas anotações de aula.</p>
                </a>

                <a class="cartao-pagina cartao-base" href="headers/questao.php">
                    <span class="icone-cartao"><i class="ph ph-question"></i></span>
                    <h2>Questões</h2>
                    <p>Crie e responda questões para testar o que aprendeu.</p>
                </a>

                <a class="cartao-pagina cartao-base" href="headers/cartoes.php">
                    <span class="icone-cartao"><i class="ph ph-cards"></i></span>
                    <h2>Cartões</h2>
                    <p>Revise o conteúdo por repetição espaçada.</p>
                </a>

                <a class="cartao-pagina cartao-base" href="headers/quadro.php">
                    <span class="icone-cartao"><i class="ph ph-chalkboard-simple"></i></span>
                    <h2>Quadro</h2>
                    <p>Rascunhe ideias e mapas mentais.</p>
                </a>

                <a class="cartao-pagina cartao-base" href="headers/pasta.php">
                    <span class="icone-cartao"><i class="ph ph-folders"></i></span>
                    <h2>Pastas</h2>
                    <p>Agrupe seus materiais por matéria.</p>
                </a>

                <a class="cartao-pagina cartao-base" href="headers/tempo.php">
                    <span class="icone-cartao"><i class="ph ph-timer"></i></span>
                    <h2>Temporizador</h2>
                    <p>Sessões de foco com a técnica Pomodoro.</p>
                </a>

            </div>
            <!-- fim da grade -->

        </div>
    </main>
    <!-- fim dos conteudos -->

</body>
</html>

<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Quadro';
    $cssPagina = '/css/headers/quadro.css';
    $paginaAtual = 'quadro';
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
        <div class="pagina">
            <header class="pagina-cabecalho">
                <h1>Quadro</h1>
                <p>Desenhe, esquematize e organize suas ideias visualmente.</p>
            </header>
            <div class="em-breve cartao-base">
                <i class="ph ph-chalkboard-simple"></i>
                <p>Em breve: um quadro livre com pincel, formas, texto e fórmulas.</p>
            </div>
        </div>
    </main>
    <!-- fim dos conteudos -->

</body>
</html>

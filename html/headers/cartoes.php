<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Cartões';
    $cssPagina = '/css/headers/cartoes.css';
    $paginaAtual = 'cartoes';
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
                <h1>Cartões</h1>
                <p>Revise com cartões frente e verso por repetição espaçada.</p>
            </header>

            <div class="cartoes-container">
                <!-- cartao -->
                <article class="cartao cartao-base" tabindex="0">
                    <div class="topo-cartao">
                        <span class="cartao-titulo">Cartão #01</span>
                        <span class="cartao-disciplina">Disciplina</span>
                    </div>
                    <p class="cartao-rodape"><i class="ph ph-hand-tap"></i> Clique no cartão</p>
                </article>
                <!-- fim do cartao -->
            </div>
        </div>
    </main>
    <!-- fim dos conteudos -->

</body>
</html>

<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Questões';
    $cssPagina = '/css/headers/questao.css';
    $paginaAtual = 'questoes';
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
                <h1>Questões</h1>
                <p>Monte seu banco de questões para praticar e testar seus conhecimentos.</p>
            </header>
            <div class="em-breve cartao-base">
                <i class="ph ph-question"></i>
                <p>Em breve você poderá criar questões de múltipla escolha, discursivas e de certo ou errado.</p>
            </div>
        </div>
    </main>
    <!-- fim dos conteudos -->

</body>
</html>

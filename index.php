<?php
    /* a raiz do site nao tem pagina propria: quem esta logado vai
       para o painel, quem nao esta vai para o login/cadastro */
    require_once __DIR__ . '/php/sessao.php';

    // caminho relativo: funciona na hospedagem e em ambiente local
    if(isset($_SESSION["idUsuario"])){
        header("Location: html/index.php", true, 302);
    } else {
        header("Location: html/acesso.php", true, 302);
    }
    exit;

<?php

/* ponto unico de abertura da sessao. toda pagina que precisa
   saber quem esta logado inclui este arquivo em vez de chamar
   session_start() direto, assim o cookie sai sempre com as
   mesmas protecoes */

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,          // dura ate fechar o navegador
        'path'     => '/',
        'httponly' => true,       // javascript nao le o cookie (protege contra XSS)
        'samesite' => 'Lax',      // outro site nao envia o cookie em POST
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ]);
    session_start();
}

/* barra quem nao esta logado.
   paginas recebem redirecionamento para o acesso; arquivos que
   devolvem JSON (fetch do javascript) recebem 401, porque um
   redirecionamento ali viraria HTML no lugar dos dados */
function exigirLogin($respostaJson = false)
{
    if (isset($_SESSION['idUsuario'])) {
        return (int) $_SESSION['idUsuario'];
    }

    if ($respostaJson) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['erro' => 'sem sessao']);
        exit;
    }

    header('Location: /html/acesso.php');
    exit;
}

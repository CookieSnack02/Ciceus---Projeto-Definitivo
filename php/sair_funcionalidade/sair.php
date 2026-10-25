<?php

require_once __DIR__ . '/../sessao.php';

/* esvazia os dados, apaga o cookie no navegador e destroi a
   sessao no servidor. so o session_destroy() deixaria o cookie
   antigo no navegador */
$_SESSION = [];

$parametros = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires'  => time() - 3600,
    'path'     => $parametros['path'],
    'secure'   => $parametros['secure'],
    'httponly' => $parametros['httponly'],
    'samesite' => $parametros['samesite']
]);

session_destroy();

header("Location: ../../html/acesso.php");
exit;

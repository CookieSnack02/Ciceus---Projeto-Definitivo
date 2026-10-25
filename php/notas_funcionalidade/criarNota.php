<?php

/* cria uma nota nova. recebe {titulo, conteudo, codPasta}
   e devolve {id} da nota criada */

require_once __DIR__ . '/comum.php';

$nota = lerNota($pedido);

if ($nota['codPasta'] !== null && !pastaEhDoUsuario($pdo, $nota['codPasta'], $idUsuario)) {
    responder(403, ['erro' => 'Pasta inválida.']);
}

try {
    // nota e pasta sao gravadas juntas: ou as duas entram, ou nenhuma
    $pdo->beginTransaction();

    $inserir = $pdo->prepare("INSERT INTO nota (tituloNotas, conteudoNotas, ciceus_idCiceus) VALUES (:titulo, :conteudo, :usuario)");
    $inserir->bindValue(':titulo', $nota['titulo']);
    $inserir->bindValue(':conteudo', $nota['conteudo']);
    $inserir->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
    $inserir->execute();

    $idNota = (int) $pdo->lastInsertId();

    definirPastaDaNota($pdo, $idNota, $nota['codPasta']);

    $pdo->commit();

    responder(201, ['id' => $idNota]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    responderErroBanco($e, 'criar');
}

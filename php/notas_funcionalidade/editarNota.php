<?php

/* atualiza uma nota existente. recebe {id, titulo, conteudo, codPasta}
   e devolve {id} */

require_once __DIR__ . '/comum.php';

$idNota = (int) ($pedido['id'] ?? 0);
$nota = lerNota($pedido);

if ($nota['codPasta'] !== null && !pastaEhDoUsuario($pdo, $nota['codPasta'], $idUsuario)) {
    responder(403, ['erro' => 'Pasta inválida.']);
}

try {
    /* confere o dono antes de mexer. nao da para confiar so no
       rowCount() do UPDATE: ele volta 0 tambem quando nada mudou */
    $dono = $pdo->prepare("SELECT 1 FROM nota WHERE idNotas = :nota AND ciceus_idCiceus = :usuario");
    $dono->bindValue(':nota', $idNota, PDO::PARAM_INT);
    $dono->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
    $dono->execute();

    if (!$dono->fetchColumn()) {
        responder(404, ['erro' => 'Nota não encontrada.']);
    }

    $pdo->beginTransaction();

    $atualizar = $pdo->prepare("UPDATE nota SET tituloNotas = :titulo, conteudoNotas = :conteudo WHERE idNotas = :nota AND ciceus_idCiceus = :usuario");
    $atualizar->bindValue(':titulo', $nota['titulo']);
    $atualizar->bindValue(':conteudo', $nota['conteudo']);
    $atualizar->bindValue(':nota', $idNota, PDO::PARAM_INT);
    $atualizar->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
    $atualizar->execute();

    definirPastaDaNota($pdo, $idNota, $nota['codPasta']);

    $pdo->commit();

    responder(200, ['id' => $idNota]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    responderErroBanco($e, 'editar');
}

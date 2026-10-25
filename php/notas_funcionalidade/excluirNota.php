<?php

/* apaga uma nota. recebe {id}. a ligacao com a pasta
   (nota_has_pasta) some junto pelo ON DELETE CASCADE */

require_once __DIR__ . '/comum.php';

$idNota = (int) ($pedido['id'] ?? 0);

try {
    // o filtro pelo dono impede apagar a nota de outra pessoa trocando o id
    $apagar = $pdo->prepare("DELETE FROM nota WHERE idNotas = :nota AND ciceus_idCiceus = :usuario");
    $apagar->bindValue(':nota', $idNota, PDO::PARAM_INT);
    $apagar->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
    $apagar->execute();

    if ($apagar->rowCount() === 0) {
        responder(404, ['erro' => 'Nota não encontrada.']);
    }

    responder(200, ['id' => $idNota]);

} catch (PDOException $e) {
    error_log("Ciceus notas (excluir): " . $e->getMessage());
    responder(500, ['erro' => 'Não foi possível excluir a nota. Tente novamente.']);
}

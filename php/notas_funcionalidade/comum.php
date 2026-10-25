<?php

/* o que criarNota, editarNota e excluirNota tem em comum.
   os tres recebem JSON do nota.js (fetch) e devolvem JSON */

require_once __DIR__ . '/../sessao.php';
require_once __DIR__ . '/../conexao.php';

header('Content-Type: application/json; charset=utf-8');

// o dono da nota vem sempre da sessao, nunca do que o navegador mandou
$idUsuario = exigirLogin(true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(405, ['erro' => 'metodo nao permitido']);
}

$pedido = json_decode(file_get_contents('php://input'), true);

if (!is_array($pedido)) {
    responder(400, ['erro' => 'pedido invalido']);
}

function responder($codigo, $dados)
{
    http_response_code($codigo);
    echo json_encode($dados);
    exit;
}

/* le e limpa os campos que vem do editor */
function lerNota($pedido)
{
    $titulo = trim($pedido['titulo'] ?? '');
    if ($titulo === '') {
        $titulo = 'Sem título';
    }

    return [
        // a coluna tituloNotas e VARCHAR(45)
        'titulo'   => mb_substr($titulo, 0, 45),
        'conteudo' => (string) ($pedido['conteudo'] ?? ''),
        'codPasta' => isset($pedido['codPasta']) && $pedido['codPasta'] !== '' ? (int) $pedido['codPasta'] : null
    ];
}

/* a pasta escolhida tem que ser do proprio usuario, senao daria
   para pendurar uma nota na pasta de outra pessoa trocando o numero */
function pastaEhDoUsuario($pdo, $codPasta, $idUsuario)
{
    $stmt = $pdo->prepare("SELECT 1 FROM pasta WHERE codPasta = :pasta AND ciceus_idCiceus = :usuario");
    $stmt->bindValue(':pasta', $codPasta, PDO::PARAM_INT);
    $stmt->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return (bool) $stmt->fetchColumn();
}

/* troca a pasta da nota. a tela trabalha com uma pasta por nota,
   entao apaga a ligacao antiga e cria a nova (se houver) */
function definirPastaDaNota($pdo, $idNota, $codPasta)
{
    $apagar = $pdo->prepare("DELETE FROM nota_has_pasta WHERE nota_idNotas = :nota");
    $apagar->bindValue(':nota', $idNota, PDO::PARAM_INT);
    $apagar->execute();

    if ($codPasta !== null) {
        $ligar = $pdo->prepare("INSERT INTO nota_has_pasta (nota_idNotas, pasta_codPasta) VALUES (:nota, :pasta)");
        $ligar->bindValue(':nota', $idNota, PDO::PARAM_INT);
        $ligar->bindValue(':pasta', $codPasta, PDO::PARAM_INT);
        $ligar->execute();
    }
}

/* traduz o erro do banco para uma mensagem que o usuario entende */
function responderErroBanco($e, $acao)
{
    error_log("Ciceus notas ($acao): " . $e->getMessage());

    // 22001 = "data too long": o TEXT do conteudo estourou, quase sempre por imagem colada
    if ($e->getCode() === '22001') {
        responder(413, ['erro' => 'A nota ficou grande demais para salvar. Tente usar imagens menores.']);
    }

    responder(500, ['erro' => 'Não foi possível salvar a nota. Tente novamente.']);
}

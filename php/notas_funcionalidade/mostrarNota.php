<?php

require_once __DIR__ . '/../sessao.php';
require_once __DIR__ . '/../conexao.php';

/* este arquivo nao devolve pagina, devolve dados.
   quem monta os cartoes e o renderizarNotas() do nota.js */
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); //Método que não foi permitido 
    echo json_encode(['erro' => 'metodo nao permitido']);
    exit;
}

/* o dono das notas vem da SESSAO, nunca da URL.
   se viesse do $_GET, bastava trocar o numero no endereco
   para ler as anotacoes de outro aluno */
$idUsuario = exigirLogin(true);

/* filtro opcional por pasta: mostrarNota.php?idPasta=3
   sem ele a consulta traz todas as notas do aluno */
$idPasta = $_GET['idPasta'] ?? '';
$filtrarPorPasta = $idPasta !== '';

try {

    /* a ligacao nota-pasta fica na tabela nota_has_pasta.
       LEFT JOIN e nao INNER: a nota pode nao estar em pasta nenhuma,
       e com INNER essas notas sumiriam da lista. a tela so permite
       uma pasta por nota, entao cada nota volta uma vez so */
    $consultarNotas = "SELECT  n.idNotas,
                               n.tituloNotas,
                               n.conteudoNotas,
                               n.dtCriacaoNota,
                               p.codPasta,
                               p.nmPasta
                       FROM nota n
                       LEFT JOIN nota_has_pasta np ON np.nota_idNotas = n.idNotas
                       LEFT JOIN pasta p ON p.codPasta = np.pasta_codPasta
                       WHERE n.ciceus_idCiceus = :idUsuario";

    if ($filtrarPorPasta) {
        $consultarNotas .= " AND np.pasta_codPasta = :idPasta";
    }

    $consultarNotas .= " ORDER BY n.dtCriacaoNota DESC, n.idNotas DESC";

    $stmt = $pdo->prepare($consultarNotas);
    $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);

    if ($filtrarPorPasta) {
        $stmt->bindValue(':idPasta', $idPasta, PDO::PARAM_INT);
    }

    $stmt->execute();
    $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* traduz os nomes das colunas do banco para os nomes que o
       front-end usa. assim uma renomeacao no banco nao obriga a
       mexer no javascript */
    $notas = [];

    foreach ($linhas as $linha) {
        $notas[] = [
            'id'       => (int) $linha['idNotas'],
            'titulo'   => $linha['tituloNotas'],
            'codPasta' => $linha['codPasta'] !== null ? (int) $linha['codPasta'] : null,
            'pasta'    => $linha['nmPasta'] ?? 'Sem pasta',
            'conteudo' => $linha['conteudoNotas'],
            'resumo'   => resumirConteudo($linha['conteudoNotas']),
            'data'     => date('d/m/Y', strtotime($linha['dtCriacaoNota']))
        ];
    }

    echo json_encode($notas);

} catch (PDOException $e) {
    /* a mensagem real do banco nao vai para o navegador:
       ela entrega nome de tabela e estrutura para quem estiver olhando */
    http_response_code(500);
    echo json_encode(['erro' => 'falha ao consultar as anotacoes']);
}

/* o conteudo vem como HTML do Quill. o cartao mostra so um
   trecho em texto puro, senao apareceria a marcacao na tela */
function resumirConteudo($html, $limite = 90)
{
    $texto = trim(preg_replace('/\s+/', ' ', strip_tags($html ?? '')));

    if (mb_strlen($texto) <= $limite) {
        return $texto;
    }

    return mb_substr($texto, 0, $limite) . '...';
}

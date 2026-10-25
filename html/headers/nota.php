<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    $idUsuario = exigirLogin();

    $tituloPagina = 'Notas';
    $cssPagina = '/css/headers/nota.css';
    $paginaAtual = 'notas';

    // pastas do usuario para o seletor da nota
    require_once __DIR__ . '/../../php/conexao.php';

    $pastas = [];
    try {
        $buscarPastas = $pdo->prepare("SELECT codPasta, nmPasta FROM pasta WHERE ciceus_idCiceus = :idUsuario ORDER BY nmPasta");
        $buscarPastas->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $buscarPastas->execute();
        $pastas = $buscarPastas->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // sem as pastas a nota ainda pode ser salva, so sem pasta
        error_log("Ciceus notas (pastas): " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php require __DIR__ . '/../componentes/cabeca.php'; ?>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- katex: o botao de formula do quill depende dele para renderizar -->
    <link href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" rel="stylesheet">
</head>
<body>

<?php require __DIR__ . '/../componentes/navbar.php'; ?>

    <!-- conteudos -->
    <main class="conteudos">
        <div class="pagina">

            <header class="pagina-cabecalho">
                <h1>Notas</h1>
                <p>Escreva, organize e revise suas anotações de estudo.</p>
            </header>

            <!-- barra de acoes: modo de exibicao e pasta da nota -->
            <div class="acoes-nota">

                <div class="alternador-modo" role="group" aria-label="Modo de exibição">
                    <label>
                        <input type="radio" name="modo" value="editor" checked>
                        <span><i class="ph ph-pencil-simple"></i> Editar</span>
                    </label>
                    <label>
                        <input type="radio" name="modo" value="visualizacao">
                        <span><i class="ph ph-eye"></i> Ler</span>
                    </label>
                </div>

                <label class="area-pasta" title="Pasta da nota">
                    <i class="ph ph-folder"></i>
                    <select id="lista-pastas" class="campo-entrada" aria-label="Pasta da nota">
                        <option value="">Sem pasta</option>
                        <?php foreach ($pastas as $pasta): ?>
                            <option value="<?php echo (int) $pasta['codPasta']; ?>"><?php echo htmlspecialchars($pasta['nmPasta']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <div class="botoes-nota">
                    <span class="status-nota" id="status-nota" aria-live="polite"></span>
                    <button type="button" class="botao-icone" id="botao-nova" title="Nova nota" aria-label="Nova nota"><i class="ph ph-plus"></i></button>
                    <button type="button" class="botao-icone perigo" id="botao-excluir" title="Excluir nota" aria-label="Excluir nota" hidden><i class="ph ph-trash"></i></button>
                    <button type="button" class="botao botao-principal" id="botao-salvar" title="Salvar (Ctrl + S)"><i class="ph ph-floppy-disk"></i> Salvar</button>
                </div>

            </div>

            <input type="text" id="titulo-nota" class="titulo-nota" placeholder="Título da nota" maxlength="45" aria-label="Título da nota">

            <div class="editor-wrapper">
                <div id="editor-texto"></div>
            </div>

            <!-- legenda dos atalhos, senao as keybinds ficam invisiveis -->
            <details class="atalhos">
                <summary><i class="ph ph-keyboard"></i> Atalhos de teclado</summary>
                <ul class="lista-atalhos">
                    <li><span>Negrito</span><kbd>Ctrl + B</kbd></li>
                    <li><span>Itálico</span><kbd>Ctrl + I</kbd></li>
                    <li><span>Sublinhado</span><kbd>Ctrl + U</kbd></li>
                    <li><span>Títulos 1 a 4</span><kbd>Ctrl + Alt + 1..4</kbd></li>
                    <li><span>Texto normal</span><kbd>Ctrl + Alt + 0</kbd></li>
                    <li><span>Lista numerada</span><kbd>Ctrl + Shift + 7</kbd></li>
                    <li><span>Lista com marcadores</span><kbd>Ctrl + Shift + 8</kbd></li>
                    <li><span>Citação</span><kbd>Ctrl + Shift + 9</kbd></li>
                    <li><span>Bloco de código</span><kbd>Ctrl + Alt + C</kbd></li>
                    <li><span>Link</span><kbd>Ctrl + K</kbd></li>
                    <li><span>Fórmula matemática</span><kbd>Ctrl + Alt + F</kbd></li>
                    <li><span>Limpar formatação</span><kbd>Ctrl + \</kbd></li>
                    <li><span>Salvar nota</span><kbd>Ctrl + S</kbd></li>
                </ul>
            </details>

            <!-- grade visualizadora das anotacoes -->
            <h2 class="subtitulo">Minhas anotações</h2>
            <div class="grade-notas" id="grade-notas"></div>

        </div>
    </main>
    <!-- fim dos conteudos -->

<!-- o katex tem que vir antes do quill, senao a formula nao registra -->
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="<?php echo versao('/js/headers/nota.js'); ?>"></script>

</body>
</html>

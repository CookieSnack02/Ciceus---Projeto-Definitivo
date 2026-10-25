<?php
    // sem login nao entra: volta para a tela de acesso
    require_once __DIR__ . '/../../php/sessao.php';
    exigirLogin();

    $tituloPagina = 'Notas';
    $cssPagina = '/css/headers/nota.css';
    $paginaAtual = 'notas';
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

                <div class="area-pasta">
                    <button type="button" class="botao botao-secundario" id="botao-pasta">
                        <i class="ph ph-folder"></i>
                        <span id="rotulo-pasta">Adicionar pasta</span>
                    </button>
                    <select id="lista-pastas" class="campo-entrada" hidden>
                        <option value="">Sem pasta</option>
                        <option value="Matemática">Matemática</option>
                        <option value="História">História</option>
                        <option value="Biologia">Biologia</option>
                        <option value="Redação">Redação</option>
                    </select>
                </div>

            </div>

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

/* Editor de notas — barra reduzida ao essencial (versão minimalista) */

var configuracaoBarra = [
    [{ header: [1, 2, 3, false] }],
    ['bold', 'italic', 'underline'],
    [{ list: 'ordered' }, { list: 'bullet' }],
    ['blockquote', 'code-block'],
    ['link', 'image'],
    ['clean']
];

var quill = new Quill('#editor-texto', {
    modules: { toolbar: configuracaoBarra },
    theme: 'snow',
    placeholder: 'Escreva suas notas aqui...'
});

/* contador de palavras do rodapé */
var contador = document.getElementById('contador-palavras');

if (contador) {
    quill.on('text-change', function () {
        var texto = quill.getText().trim();
        var palavras = texto ? texto.split(/\s+/).length : 0;
        contador.textContent = palavras + (palavras === 1 ? ' palavra' : ' palavras');
    });
}

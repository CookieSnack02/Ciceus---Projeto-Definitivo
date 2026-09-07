/* ------------------------------------------------------------------
   barra de formatacao do Quill
   mantida minimalista: so os grupos essenciais
   ------------------------------------------------------------------ */

var configuracaoBarra = [
    ['bold', 'italic', 'underline'],
    ['blockquote', 'code-block'],
    [{ 'header': [1, 2, 3, 4, false] }],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'font': [] }],
    ['link', 'image', 'video', 'formula']
];


/* ------------------------------------------------------------------
   atalhos de teclado das formatacoes
   ------------------------------------------------------------------ */

/* fabricas de handler: evitam repetir o mesmo corpo de funcao.
   dentro do handler o Quill entrega "this.quill" */

function alternarCabecalho(nivel) {
    return function () {
        var atual = this.quill.getFormat().header;
        this.quill.format('header', atual === nivel ? false : nivel);
    };
}

function alternarLista(tipo) {
    return function () {
        var atual = this.quill.getFormat().list;
        this.quill.format('list', atual === tipo ? false : tipo);
    };
}

function alternarBloco(formato) {
    return function () {
        var atual = this.quill.getFormat()[formato];
        this.quill.format(formato, !atual);
    };
}

/* Ctrl+B, Ctrl+I, Ctrl+U e Ctrl+\ ja vem prontos do Quill,
   entao aqui ficam so as formatacoes que faltavam.
   os numeros usam Ctrl+Alt porque Ctrl+1..9 sozinho e
   atalho de troca de aba do navegador. */

var atalhosFormatacao = {

    'titulo 1': { key: '1', shortKey: true, altKey: true, handler: alternarCabecalho(1) },
    'titulo 2': { key: '2', shortKey: true, altKey: true, handler: alternarCabecalho(2) },
    'titulo 3': { key: '3', shortKey: true, altKey: true, handler: alternarCabecalho(3) },
    'titulo 4': { key: '4', shortKey: true, altKey: true, handler: alternarCabecalho(4) },

    'texto normal': {
        key: '0',
        shortKey: true,
        altKey: true,
        handler: function () {
            this.quill.format('header', false);
        }
    },

    'lista numerada': { key: '7', shortKey: true, shiftKey: true, handler: alternarLista('ordered') },
    'lista marcadores': { key: '8', shortKey: true, shiftKey: true, handler: alternarLista('bullet') },

    'citacao': { key: '9', shortKey: true, shiftKey: true, handler: alternarBloco('blockquote') },
    'bloco de codigo': { key: 'C', shortKey: true, altKey: true, handler: alternarBloco('code-block') },

    /* abre a mesma caixinha do botao de formula da barra */
    'formula matematica': {
        key: 'F',
        shortKey: true,
        altKey: true,
        handler: function () {
            if (this.quill.theme && this.quill.theme.tooltip) {
                this.quill.theme.tooltip.edit('formula');
            }
            return false;
        }
    }

    /* Ctrl+K (link) nao entra aqui: o tema snow ja registra esse
       atalho sozinho quando a barra tem o botao de link, e o
       tooltip dele e melhor que um prompt do navegador */
};


/* ------------------------------------------------------------------
   editor
   ------------------------------------------------------------------ */

var quill = new Quill('#editor-texto', {
    modules: {
        toolbar: configuracaoBarra,
        keyboard: { bindings: atalhosFormatacao }
    },
    theme: 'snow',
    placeholder: 'Escreva suas notas aqui...'
});


/* ------------------------------------------------------------------
   alternancia entre editor e visualizacao
   ------------------------------------------------------------------ */

var caixaEditor = document.querySelector('.editor-wrapper');
var seletorModo = document.getElementById('modo-nota');

/* no modo visualizacao a classe esconde a barra de formatacao
   pelo css e o quill fica somente leitura */
function aplicarModo(modo) {
    var visualizando = modo === 'visualizacao';

    caixaEditor.classList.toggle('modo-visualizacao', visualizando);
    quill.enable(!visualizando);

    if (seletorModo.value !== modo) {
        seletorModo.value = modo;
    }
}

seletorModo.addEventListener('change', function () {
    aplicarModo(seletorModo.value);
});

/* tres cliques seguidos na nota devolvem o modo de edicao.
   o proprio evento de clique ja conta a sequencia em event.detail */
quill.root.addEventListener('click', function (evento) {
    if (evento.detail === 3 && seletorModo.value === 'visualizacao') {
        aplicarModo('editor');
        quill.focus();
    }
});

aplicarModo(seletorModo.value);


/* ------------------------------------------------------------------
   pasta da nota
   ------------------------------------------------------------------ */

var botaoPasta = document.getElementById('botao-pasta');
var rotuloPasta = document.getElementById('rotulo-pasta');
var listaPastas = document.getElementById('lista-pastas');

botaoPasta.addEventListener('click', function () {
    listaPastas.hidden = !listaPastas.hidden;
    if (!listaPastas.hidden) {
        listaPastas.focus();
    }
});

listaPastas.addEventListener('change', function () {
    definirPasta(listaPastas.value);
    listaPastas.hidden = true;
});

function definirPasta(pasta) {
    listaPastas.value = pasta;
    rotuloPasta.textContent = pasta === '' ? 'Adicionar Pasta' : pasta;
}


/* ------------------------------------------------------------------
   grade visualizadora das anotacoes
   ------------------------------------------------------------------ */

var gradeNotas = document.getElementById('grade-notas');

/* preenchido pelo mostrarNota.php; comeca vazio para a pagina
   nao quebrar caso a requisicao falhe */
var notasDoAluno = [];

/* busca as anotacoes do aluno logado.
   o php descobre quem e o aluno pela sessao, entao nao
   precisamos mandar nenhum id daqui */
function carregarNotas() {
    fetch('../../php/notas_funcionalidade/mostrarNota.php')
        .then(function (resposta) {
            if (!resposta.ok) {
                throw new Error('resposta ' + resposta.status);
            }
            return resposta.json();
        })
        .then(function (dados) {
            notasDoAluno = dados;
            renderizarNotas();
        })
        .catch(function (erro) {
            console.error('falha ao carregar as anotacoes:', erro);
            mostrarAviso('Não foi possível carregar suas anotações.');
        });
}

function mostrarAviso(mensagem) {
    gradeNotas.innerHTML = '';

    var aviso = document.createElement('p');
    aviso.className = 'aviso-notas';
    aviso.textContent = mensagem;

    gradeNotas.appendChild(aviso);
}

function renderizarNotas() {
    gradeNotas.innerHTML = '';

    if (notasDoAluno.length === 0) {
        mostrarAviso('Você ainda não tem anotações salvas.');
        return;
    }

    notasDoAluno.forEach(function (nota, indice) {

        var cartao = document.createElement('article');
        cartao.className = 'cartao-nota';
        cartao.tabIndex = 0;
        /* o atraso vem daqui e nao do css porque a quantidade
           de anotacoes e variavel */
        cartao.style.animationDelay = (60 + indice * 60) + 'ms';

        var pasta = document.createElement('span');
        pasta.className = 'pasta-nota';
        pasta.innerHTML = '<i class="fa-slab fa-regular fa-folders"></i>';
        pasta.appendChild(document.createTextNode(nota.pasta));

        var titulo = document.createElement('h3');
        titulo.textContent = nota.titulo;

        var resumo = document.createElement('p');
        resumo.className = 'resumo-nota';
        resumo.textContent = nota.resumo;

        var data = document.createElement('span');
        data.className = 'data-nota';
        data.textContent = 'Editada em ' + nota.data;

        cartao.appendChild(pasta);
        cartao.appendChild(titulo);
        cartao.appendChild(resumo);
        cartao.appendChild(data);

        cartao.addEventListener('click', function () {
            abrirNota(indice);
        });

        /* mesma acao pelo teclado, para quem navega por tab */
        cartao.addEventListener('keydown', function (evento) {
            if (evento.key === 'Enter' || evento.key === ' ') {
                evento.preventDefault();
                abrirNota(indice);
            }
        });

        gradeNotas.appendChild(cartao);
    });
}

/* carrega a nota escolhida no editor e abre em leitura.
   tres cliques no texto passam para o modo de edicao */
function abrirNota(indice) {
    var nota = notasDoAluno[indice];

    quill.setContents([]);
    quill.clipboard.dangerouslyPasteHTML(nota.conteudo);

    definirPasta(nota.pasta);
    aplicarModo('visualizacao');

    var cartoes = gradeNotas.querySelectorAll('.cartao-nota');
    for (var i = 0; i < cartoes.length; i++) {
        cartoes[i].classList.toggle('nota-ativa', i === indice);
    }

    caixaEditor.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

carregarNotas();

/* ------------------------------------------------------------------
   largura da tela

   Declarado aqui em cima porque a barra de formatacao logo abaixo ja
   precisa saber em qual layout estamos. E o mesmo valor do @media do
   nota.css e do responsivo.css.
   ------------------------------------------------------------------ */

var telaPequena = window.matchMedia('(max-width: 900px)');


/* ------------------------------------------------------------------
   barra de formatacao do Quill
   ------------------------------------------------------------------ */

/* desktop: os grupos essenciais */
var configuracaoBarra = [
    ['bold', 'italic', 'underline'],
    ['blockquote', 'code-block'],
    [{ 'header': [1, 2, 3, 4, false] }],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'font': [] }],
    ['link', 'image', 'video', 'formula']
];

/* mobile: conjunto reduzido, escolhido para caber em UMA linha da
   tela do celular. Com a lista inteira, ou a barra quebrava em 4
   linhas (comendo a altura do editor) ou precisava rolar de lado.
   Os botoes que sairam continuam acessiveis por teclado externo e
   pela versao de desktop da mesma nota. */
var configuracaoBarraMobile = [
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic'],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    ['link', 'formula']
];

/* a barra e montada uma unica vez, na criacao do editor: redimensionar
   a janela no desktop nao a reconstroi. E o comportamento certo para
   aparelho real, onde a largura nao muda de categoria */
var barraEmUso = telaPequena.matches ? configuracaoBarraMobile : configuracaoBarra;


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
        toolbar: barraEmUso,
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
   painel do editor no mobile

   No celular o editor nao fica na pagina: ele abre num painel que
   ocupa a tela inteira. Quem posiciona e anima o painel e o css
   (.painel-editor dentro do @media do nota.css); aqui so entra e sai
   a classe `editor-aberto` do <body>.
   ------------------------------------------------------------------ */

var painelEditor = document.getElementById('painel-editor');
var botaoNovaNota = document.getElementById('botao-nova-nota');
var botaoVoltar = document.getElementById('botao-voltar');

function abrirFolha() {
    if (telaPequena.matches) {
        document.body.classList.add('editor-aberto');
        ajustarAoTeclado();
    }
}

function fecharFolha() {
    document.body.classList.remove('editor-aberto');
    limparAjusteDoTeclado();
}


/* ------------------------------------------------------------------
   teclado virtual

   PROBLEMA: `position: fixed` se apoia no layout viewport, que NAO
   encolhe quando o teclado do celular abre. No iOS o navegador rola a
   pagina inteira para revelar o campo em foco, e o painel fixo sobe
   junto — o topo dele sai da tela e o rodape fica atras do teclado.

   SOLUCAO: a API visualViewport informa a area que o usuario esta
   realmente vendo (`height`) e o quanto ela esta deslocada dentro do
   layout viewport (`offsetTop`). Copiando esses dois valores para o
   painel, ele passa a acompanhar exatamente a area visivel: fica
   parado no lugar e encolhe para caber acima do teclado.

   Nao existe fallback: em navegador sem visualViewport (bem antigo) o
   painel simplesmente se comporta como antes.
   ------------------------------------------------------------------ */

var areaVisivel = window.visualViewport;

function ajustarAoTeclado() {
    if (!areaVisivel || !painelEditor) {
        return;
    }

    if (!document.body.classList.contains('editor-aberto')) {
        return;
    }

    painelEditor.style.top = areaVisivel.offsetTop + 'px';
    painelEditor.style.bottom = 'auto';
    painelEditor.style.height = areaVisivel.height + 'px';
}

/* ao fechar, os estilos inline saem: sem isso eles continuariam
   valendo depois, inclusive se a janela virar desktop */
function limparAjusteDoTeclado() {
    if (!painelEditor) {
        return;
    }

    painelEditor.style.top = '';
    painelEditor.style.bottom = '';
    painelEditor.style.height = '';
}

if (areaVisivel) {
    /* resize: o teclado abriu ou fechou.
       scroll: o iOS deslocou a area visivel dentro da pagina */
    areaVisivel.addEventListener('resize', ajustarAoTeclado);
    areaVisivel.addEventListener('scroll', ajustarAoTeclado);
}

/* nova nota: editor limpo, sem pasta, em modo de edicao */
if (botaoNovaNota) {
    botaoNovaNota.addEventListener('click', function () {
        quill.setContents([]);
        definirPasta('');
        aplicarModo('editor');

        /* nenhum cartao continua marcado como aberto */
        var marcados = gradeNotas.querySelectorAll('.cartao-nota.nota-ativa');
        for (var i = 0; i < marcados.length; i++) {
            marcados[i].classList.remove('nota-ativa');
        }

        abrirFolha();
        quill.focus();
    });
}

if (botaoVoltar) {
    botaoVoltar.addEventListener('click', fecharFolha);
}

/* Escape fecha a folha em quem estiver num celular com teclado */
document.addEventListener('keydown', function (evento) {
    if (evento.key === 'Escape') {
        fecharFolha();
    }
});

/* ao girar o aparelho para o modo paisagem a tela pode passar dos
   900px: ali o layout volta a ser o de desktop, e a classe deixaria
   o body travado sem rolagem */
function aoTrocarLarguraNota(evento) {
    if (!evento.matches) {
        fecharFolha();
    }
}

if (telaPequena.addEventListener) {
    telaPequena.addEventListener('change', aoTrocarLarguraNota);
} else if (telaPequena.addListener) {
    /* Safari antigo (< 14) so tem a API velha */
    telaPequena.addListener(aoTrocarLarguraNota);
}


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

    if (telaPequena.matches) {
        /* no mobile a nota abre na folha de tela cheia; rolar a pagina
           nao faria sentido porque a folha e fixa, cobre tudo */
        abrirFolha();
    } else {
        caixaEditor.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

carregarNotas();

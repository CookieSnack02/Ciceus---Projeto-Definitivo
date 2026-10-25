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
var opcoesModo = document.querySelectorAll('input[name="modo"]');

function modoAtual() {
    return document.querySelector('input[name="modo"]:checked').value;
}

/* no modo visualizacao a classe esconde a barra de formatacao
   pelo css e o quill fica somente leitura */
function aplicarModo(modo) {
    var visualizando = modo === 'visualizacao';

    caixaEditor.classList.toggle('modo-visualizacao', visualizando);
    quill.enable(!visualizando);

    opcoesModo.forEach(function (opcao) {
        opcao.checked = opcao.value === modo;
    });
}

opcoesModo.forEach(function (opcao) {
    opcao.addEventListener('change', function () {
        aplicarModo(opcao.value);
    });
});

/* tres cliques seguidos na nota devolvem o modo de edicao.
   o proprio evento de clique ja conta a sequencia em event.detail */
quill.root.addEventListener('click', function (evento) {
    if (evento.detail === 3 && modoAtual() === 'visualizacao') {
        aplicarModo('editor');
        quill.focus();
    }
});

aplicarModo(modoAtual());



/* ------------------------------------------------------------------
   nota aberta no editor
   ------------------------------------------------------------------ */

var campoTitulo = document.getElementById('titulo-nota');
var listaPastas = document.getElementById('lista-pastas');
var statusNota = document.getElementById('status-nota');
var botaoSalvar = document.getElementById('botao-salvar');
var botaoNova = document.getElementById('botao-nova');
var botaoExcluir = document.getElementById('botao-excluir');

/* null = nota nova, ainda nao gravada no banco */
var idNotaAtual = null;

/* true quando ha mudanca que ainda nao foi salva */
var alterada = false;

var salvando = false;

function mostrarStatus(texto, tipo) {
    statusNota.textContent = texto;
    statusNota.className = 'status-nota' + (tipo ? ' ' + tipo : '');
}

function marcarAlterada() {
    alterada = true;
    mostrarStatus('Alterações não salvas', 'pendente');
}

/* o quill avisa toda mudanca; "api" sao as mudancas feitas pelo
   proprio codigo (ao abrir uma nota), que nao contam como edicao */
quill.on('text-change', function (delta, anterior, origem) {
    if (origem === 'user') {
        marcarAlterada();
    }
});

campoTitulo.addEventListener('input', marcarAlterada);
listaPastas.addEventListener('change', marcarAlterada);

/* pergunta antes de jogar fora uma edicao que nao foi salva */
function podeDescartar() {
    return !alterada || confirm('Há alterações não salvas nesta nota. Deseja descartá-las?');
}

/* deixa o editor no estado de uma nota (ou vazio, para nota nova) */
function carregarNoEditor(nota) {
    idNotaAtual = nota ? nota.id : null;
    campoTitulo.value = nota ? nota.titulo : '';
    listaPastas.value = nota && nota.codPasta !== null ? String(nota.codPasta) : '';

    quill.setContents([], 'api');
    if (nota && nota.conteudo) {
        quill.clipboard.dangerouslyPasteHTML(nota.conteudo, 'api');
    }

    alterada = false;
    botaoExcluir.hidden = idNotaAtual === null;
    mostrarStatus('');
    marcarCartaoAtivo();
}

function notaVazia() {
    /* getText() ignora imagens e formulas; elas contam como conteudo */
    var temTexto = quill.getText().trim() !== '';
    var temEmbed = quill.root.querySelector('img, iframe, .ql-formula') !== null;
    return !temTexto && !temEmbed && campoTitulo.value.trim() === '';
}

/* envia JSON para o php e devolve a resposta ja lida.
   o php responde com {erro: "..."} quando algo da errado */
function enviar(arquivo, dados) {
    return fetch('../../php/notas_funcionalidade/' + arquivo, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    }).then(function (resposta) {
        return resposta.json().catch(function () {
            return {};
        }).then(function (corpo) {
            if (!resposta.ok) {
                throw new Error(corpo.erro || 'Não foi possível concluir. Tente novamente.');
            }
            return corpo;
        });
    });
}

function salvarNota() {
    if (salvando) return;

    if (notaVazia()) {
        mostrarStatus('Escreva algo antes de salvar', 'erro');
        campoTitulo.focus();
        return;
    }

    salvando = true;
    botaoSalvar.disabled = true;
    mostrarStatus('Salvando…');

    var dados = {
        titulo: campoTitulo.value,
        conteudo: quill.root.innerHTML,
        codPasta: listaPastas.value
    };

    var arquivo = 'criarNota.php';
    if (idNotaAtual !== null) {
        dados.id = idNotaAtual;
        arquivo = 'editarNota.php';
    }

    enviar(arquivo, dados)
        .then(function (corpo) {
            idNotaAtual = corpo.id;
            alterada = false;
            botaoExcluir.hidden = false;

            var agora = new Date();
            mostrarStatus('Salvo às ' + agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }), 'ok');

            carregarNotas();
        })
        .catch(function (erro) {
            mostrarStatus(erro.message, 'erro');
        })
        .finally(function () {
            salvando = false;
            botaoSalvar.disabled = false;
        });
}

function novaNota() {
    if (!podeDescartar()) return;

    carregarNoEditor(null);
    aplicarModo('editor');
    campoTitulo.focus();
}

function excluirNota() {
    if (idNotaAtual === null) return;
    if (!confirm('Excluir esta nota? Essa ação não pode ser desfeita.')) return;

    enviar('excluirNota.php', { id: idNotaAtual })
        .then(function () {
            carregarNoEditor(null);
            aplicarModo('editor');
            mostrarStatus('Nota excluída', 'ok');
            carregarNotas();
        })
        .catch(function (erro) {
            mostrarStatus(erro.message, 'erro');
        });
}

botaoSalvar.addEventListener('click', salvarNota);
botaoNova.addEventListener('click', novaNota);
botaoExcluir.addEventListener('click', excluirNota);

/* Ctrl+S (Cmd+S no mac) salva em vez de abrir o "salvar pagina" do navegador */
document.addEventListener('keydown', function (evento) {
    if ((evento.ctrlKey || evento.metaKey) && evento.key.toLowerCase() === 's') {
        evento.preventDefault();
        salvarNota();
    }
});

/* avisa antes de fechar ou trocar de pagina com edicao pendente */
window.addEventListener('beforeunload', function (evento) {
    if (alterada) {
        evento.preventDefault();
        evento.returnValue = '';
    }
});


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
    aviso.className = 'aviso';
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
        cartao.className = 'cartao-nota cartao-base';
        cartao.tabIndex = 0;
        cartao.dataset.id = nota.id;
        /* o atraso vem daqui e nao do css porque a quantidade
           de anotacoes e variavel */
        cartao.style.animationDelay = Math.min(indice * 40, 400) + 'ms';

        var pasta = document.createElement('span');
        pasta.className = 'pasta-nota';
        pasta.innerHTML = '<i class="ph ph-folder"></i>';
        pasta.appendChild(document.createTextNode(nota.pasta));

        var titulo = document.createElement('h3');
        titulo.textContent = nota.titulo;

        var resumo = document.createElement('p');
        resumo.className = 'resumo-nota';
        resumo.textContent = nota.resumo;

        var data = document.createElement('span');
        data.className = 'data-nota';
        data.textContent = 'Criada em ' + nota.data;

        cartao.appendChild(pasta);
        cartao.appendChild(titulo);
        cartao.appendChild(resumo);
        cartao.appendChild(data);

        cartao.addEventListener('click', function () {
            abrirNota(nota);
        });

        /* mesma acao pelo teclado, para quem navega por tab */
        cartao.addEventListener('keydown', function (evento) {
            if (evento.key === 'Enter' || evento.key === ' ') {
                evento.preventDefault();
                abrirNota(nota);
            }
        });

        gradeNotas.appendChild(cartao);
    });

    marcarCartaoAtivo();
}

function marcarCartaoAtivo() {
    var cartoes = gradeNotas.querySelectorAll('.cartao-nota');
    for (var i = 0; i < cartoes.length; i++) {
        cartoes[i].classList.toggle('nota-ativa', Number(cartoes[i].dataset.id) === idNotaAtual);
    }
}

/* carrega a nota escolhida no editor e abre em leitura.
   tres cliques no texto passam para o modo de edicao */
function abrirNota(nota) {
    if (nota.id === idNotaAtual) return;
    if (!podeDescartar()) return;

    carregarNoEditor(nota);
    aplicarModo('visualizacao');

    caixaEditor.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

carregarNotas();

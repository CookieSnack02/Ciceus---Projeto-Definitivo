/* ------------------------------------------------------------------
   abre e fecha a gaveta de navegacao do mobile

   TODO o visual (posicao, animacao, veu de fundo) esta no
   css/responsivo.css. Este arquivo faz uma coisa so: colocar ou
   tirar a classe `menu-aberto` do <body>. Assim, se um dia a
   animacao mudar, nada aqui precisa ser mexido.

   A funcao fica dentro de uma IIFE — aquela `(function(){ ... })()`
   do final — para que as variaveis daqui nao virem globais e
   colidam com as dos outros scripts da pagina (nota.js, timer.js).
   ------------------------------------------------------------------ */

(function () {

    var botaoMenu = document.getElementById('botao-menu');
    var fundoMenu = document.getElementById('fundo-menu');
    var navbar = document.getElementById('navbar');

    /* se a pagina nao tiver a barra do mobile, o script para aqui
       em vez de estourar erro no console */
    if (!botaoMenu || !navbar) {
        return;
    }

    function menuEstaAberto() {
        return document.body.classList.contains('menu-aberto');
    }

    /* um unico ponto que muda o estado: a classe do body e os
       atributos ARIA andam sempre juntos, entao o leitor de tela
       nunca fica dessincronizado do que aparece na tela */
    function definirMenu(aberto) {
        document.body.classList.toggle('menu-aberto', aberto);
        botaoMenu.setAttribute('aria-expanded', aberto ? 'true' : 'false');
        botaoMenu.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
    }

    botaoMenu.addEventListener('click', function () {
        definirMenu(!menuEstaAberto());
    });

    /* tocar no veu escuro fecha: e o gesto que o usuario de
       celular espera, mais rapido que voltar no botao */
    if (fundoMenu) {
        fundoMenu.addEventListener('click', function () {
            definirMenu(false);
        });
    }

    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape' && menuEstaAberto()) {
            definirMenu(false);
        }
    });

    /* fechar ao escolher uma aba. A navegacao acontece depois deste
       handler, entao a gaveta ja sai fechada — e ao voltar pelo
       historico a pagina nao reaparece com o menu por cima */
    navbar.addEventListener('click', function (evento) {
        if (evento.target.closest('a')) {
            definirMenu(false);
        }
    });

    /* girar o celular ou alargar a janela pode passar dos 900px:
       ali a gaveta volta a ser barra lateral fixa e a classe
       `menu-aberto` deixaria o body travado sem rolagem */
    var telaGrande = window.matchMedia('(min-width: 901px)');

    function aoTrocarLargura(evento) {
        if (evento.matches) {
            definirMenu(false);
        }
    }

    if (telaGrande.addEventListener) {
        telaGrande.addEventListener('change', aoTrocarLargura);
    } else if (telaGrande.addListener) {
        /* Safari antigo (< 14) so tem a API velha */
        telaGrande.addListener(aoTrocarLargura);
    }

})();

# Dia 6 — Responsividade mobile

Foi feita a responsividade mobile das 7 páginas internas do sistema. O
problema era o mesmo em todas: o menu lateral de 250px com `position: fixed`
somado ao `margin-left: 260px` do conteúdo deixava cerca de 100px úteis num
celular de 360px, e três páginas ainda tinham altura fixa (`height: 1000px`,
`height: 100vh`) que gerava rolagem vazia. A landing page e a tela de login
já eram fluidas e quase não precisaram de ajuste.

O ponto de troca de layout é 900px. Não são os 768px habituais porque o menu
ocupa 250px: abaixo de 900px sobra menos de 650px de conteúdo, que é onde as
páginas começam a apertar.

## Navbar

Abaixo de 900px o menu lateral sai do fluxo da tela e passa a ser aberto por
um botão numa barra fixa de 56px no topo. É o **mesmo HTML** da navbar do
desktop: só o CSS muda abaixo de 900px, então nada foi duplicado.

Para isso foram criados dois arquivos compartilhados pelas 7 páginas, em vez
de repetir as mesmas ~120 linhas em cada um dos 6 CSS:

- **`css/responsivo.css`** — a barra superior, o botão de menu, o menu
  lateral retrátil e o overlay escurecido que cobre o conteúdo enquanto o
  menu está aberto. É carregado *depois* do CSS de cada página, porque
  regras dentro de `@media` não ganham especificidade extra: quando o peso é
  igual, quem vence é a última declarada.
- **`js/navbar.js`** — adiciona e remove a classe `menu-aberto` do `<body>`;
  todo o resultado visual vem do CSS. Fecha ao clicar no overlay, ao
  escolher um item do menu, com `Esc` e quando a largura volta ao desktop.

A abertura usa `transform: translateX()` em vez de `left`, o que evita
recálculo de layout a cada frame. Fechado, o menu recebe `visibility: hidden`
para sair da ordem de tabulação do teclado.

## Notas — mudança de layout

Reproduzir o layout do desktop no celular não funcionava: a barra de
formatação do Quill quebrava em 4 linhas, o editor de 320px deixava pouco
espaço de texto, a lista de anotações ficava fora da primeira tela e a
legenda de atalhos (`Ctrl + Alt + 1`) é inútil sem teclado físico.

No mobile a ordem foi invertida: **a lista de anotações passa a ser o
conteúdo principal** e o editor abre num painel de tela cheia, acionado ao
tocar numa nota ou no botão fixo "Nova nota".

O que isso exigiu:

- No HTML, a barra de ações, o editor e os atalhos foram agrupados em
  `div.painel-editor`. No desktop esse elemento não recebe estilo próprio —
  os filhos mantêm o `max-width: 800px` que já tinham e a tela continua
  idêntica. No mobile ele recebe `position: fixed` e cobre a tela.
- Um cabeçalho com botão "Voltar" e um botão fixo de nova nota, ambos com
  `display: none` por padrão e ativados apenas dentro do `@media`.
- A legenda de atalhos é ocultada no mobile.
- Em `nota.js`, as funções `abrirFolha()` / `fecharFolha()` e uma checagem
  de `matchMedia` dentro de `abrirNota()`: no mobile a nota abre no painel,
  no desktop mantém o `scrollIntoView` de antes.

### Barra de formatação sem rolagem lateral

A lista completa de botões do Quill não cabe na largura de um celular: ou
quebrava em 4 linhas, consumindo a altura do editor, ou exigia arrastar a
barra para os lados. As duas coisas foram descartadas.

`nota.js` passou a montar **duas configurações de barra**: a completa no
desktop e uma reduzida no mobile (título, negrito, itálico, lista numerada,
lista com marcadores, link e fórmula). A escolha é feita uma vez, na criação
do editor, por `matchMedia`.

No CSS, a barra virou um container flex em que cada grupo de botões recebe
`flex: 1`. Com isso os botões **dividem a largura disponível** em vez de
terem largura fixa: nunca sobra nada para fora da tela, em nenhum tamanho de
aparelho, e os botões ficam com 44px de altura em vez dos 24px padrão do
Quill. O `flex-wrap: wrap` é apenas garantia — se a barra crescer no futuro,
ela quebra para uma segunda linha em vez de rolar.

O painel também recebeu `overflow: hidden`: ele nunca rola, nem na vertical
nem na horizontal. Quem rola é o texto, dentro do editor.

### Teclado virtual

`position: fixed` se apoia no *layout viewport*, que não encolhe quando o
teclado do celular abre. No iOS o navegador rola a página inteira para
revelar o campo em foco, e o painel fixo sobe junto: o topo sai da tela e o
rodapé fica atrás do teclado.

A correção usa a API `visualViewport`, que informa a área realmente visível
(`height`) e o quanto ela está deslocada dentro do layout viewport
(`offsetTop`). `nota.js` copia esses dois valores para o `top` e o `height`
do painel nos eventos `resize` e `scroll` do `visualViewport`. O painel passa
a acompanhar exatamente a área visível: fica parado no lugar e encolhe para
caber acima do teclado. Ao fechar, os estilos inline são removidos.

## Ajustes por página

- **Inicial** — margem do menu zerada e `#bem-vindo` de 42px fixos para
  `clamp(27px, 8vw, 40px)`. A grade de cartões já reduzia para uma coluna
  sozinha, por causa do `auto-fit`.
- **Temporizador** — `100vh` trocado por `min-height: 100dvh`, porque no
  celular o `vh` desconsidera a barra de endereço e sempre esconde parte da
  tela. O seletor circular de 300px fixos passou a `min(300px, 74vw)` com
  `aspect-ratio: 1`, e os três botões viraram grade. O modo pop-up foi
  ocultado no mobile: a caixa tem 350px fixos e o arraste depende de eventos
  de mouse, que não existem em tela de toque.
- **Pastas** — o formulário passou a ocupar duas linhas (o `min-width: 250px`
  do campo de texto causava rolagem horizontal), os cartões ocupam a linha
  inteira e os links de editar/excluir ganharam área de toque de 44px.
- **Cartões / Quadro / Questões** — `height: 1000px` → `auto`, margem
  zerada, e o cartão de estudo de `width: 320px` para `100%` com limite de
  380px.
- **Login** — já era responsivo; o ajuste principal foi levar os campos a
  `font-size: 16px`, porque abaixo disso o Safari do iPhone aplica zoom
  automático ao focar e a página passa a ser maior que a tela.

Em vários pontos o `:hover` foi desativado no mobile: em tela de toque o
estado permanece aplicado depois do toque, deixando o elemento alterado sem
motivo.

## Duas correções de passagem

- `pasta.php` carregava `js/headers/pasta.js`, arquivo inexistente, o que
  imprimia um `Warning: filemtime(): stat failed` no corpo da página e
  gerava 404. A tag foi substituída pela do `navbar.js`.
- O `div.grade-notas` tinha um atributo `action=`, válido apenas em `<form>`;
  o caminho real já está no `fetch()` do `nota.js`.

## Como testar

DevTools em 360px e 375px nas 7 páginas; redimensionar a janela passando por
900px para confirmar que o menu troca de forma sem salto; na página de notas,
abrir e fechar o painel do editor e conferir que a barra de formatação cabe
inteira na largura; no temporizador, arrastar o controle circular por toque.

O teste do teclado virtual só vale em aparelho real: tocar no texto da nota
e verificar que o painel continua no lugar, com a barra de formatação
visível, em vez de subir junto com a página.

Não foi possível executar as páginas aqui — não há PHP no PATH desta máquina,
então a conferência foi de código e de cascata, não de renderização. O teste
em navegador, de preferência em aparelho real, ainda precisa ser feito: o
zoom automático do Safari e a barra de endereço variável não aparecem no
emulador.

## Pendências

- A barra de formatação é montada uma única vez, na criação do editor.
  Redimensionar a janela do desktop para menos de 900px não troca a barra
  completa pela reduzida — só recarregar a página. Em aparelho real isso não
  acontece, porque a largura não muda de categoria.
- O breakpoint de 900px está repetido em três arquivos (`responsivo.css`,
  `navbar.js`, `nota.js`), porque `var()` do CSS não funciona dentro de
  `@media`. Está anotado nos comentários dos três.
- Quadro e Questões só têm título e parágrafo; quando o conteúdo real for
  implementado, cada um vai precisar do seu próprio ajuste de mobile.

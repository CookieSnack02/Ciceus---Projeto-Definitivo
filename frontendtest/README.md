# frontendtest — protótipo visual do Ciceus

Pasta isolada, criada só para aprovação do novo visual.
**Nenhum arquivo de `html/`, `css/`, `js/` ou `php/` foi alterado.**

## Como abrir

Precisa de servidor PHP (por causa de `pasta.php`). Na raiz do projeto:

```
php -S localhost:8000
```

E acesse `http://localhost:8000/frontendtest/index.php`.

Se você usa XAMPP/Laragon, é só abrir a URL normal do projeto + `/frontendtest/index.php`.

## O que mudou

| Item | Antes | Agora |
|---|---|---|
| Fonte do corpo | Nunito | `'DM Sans', Helvetica, sans-serif` |
| Fonte dos títulos | SN Pro 900 | Fraunces com eixo `SOFT 70` (formas arredondadas, peso 500) |
| Barra lateral | `<ul position:fixed>` — o logo e o título rolavam junto com a página | `<aside>` inteiro fixo (logo + navegação + conta), só a lista de links rola internamente |
| Conta | não existia | botão no canto inferior esquerdo, com troca `fa-slab-press` → `fa-slab` no hover |
| Cores | `#efede3` + `#C08552` sólido | tokens em `css/base.css`: fundo `#FBFAF7`, barra `#F5F2EC`, linha `#E8E3D9`, acento `#A27B5B` |
| Estilo | pílulas 25px, sombras, blocos grandes | traços de 1px, raios de 8–12px, sem sombra, muito espaço em branco |

### Animação da conta

Os dois ícones ficam empilhados na mesma caixa. No hover, o `fa-slab-press` sai
(`opacity 0`, `scale .7`) e o `fa-slab` entra em `scale 1.12` com easing
`cubic-bezier(.34, 1.56, .64, 1)` — a curva passa do alvo e volta, é isso que dá
a sensação de "pop". Ver `.conta-icone` em `css/base.css`.

## Estrutura

```
frontendtest/
├── index.php              → saudação + grade de atalhos
├── headers/
│   ├── nota.php           → editor Quill em papel limpo
│   ├── pasta.php          → lê o banco de verdade (mesmo SQL do original)
│   ├── quadro.php         → prancheta de desenho + barra de ferramentas
│   ├── cartoes.php        → cartões que viram no clique
│   ├── tempo.php          → temporizador (mesma lógica, visual novo)
│   └── questao.php        → só o shell novo (página ainda sem função)
├── css/
│   ├── base.css           → tokens + tipografia + barra lateral  ← fonte única
│   ├── index.css
│   └── headers/*.css      → cada um faz `@import` do base.css
├── js/
│   ├── timer.js           → cópia do original, sem alteração
│   ├── nota.js            → barra do Quill reduzida ao essencial + contador
│   ├── quadro.js          → desenho em canvas (novo)
│   └── cartoes.js         → virada do cartão (novo)
└── img/ciceus.svg         → a coruja, extraída do SVG inline
```

A profundidade das pastas é a mesma de `html/headers/`, então portar depois é
copiar e ajustar os caminhos de `css/` e `js/`.

## Pontos a saber

- `pasta.php` lê o banco de verdade. O formulário e os botões de editar/excluir
  apontam para os scripts reais em `php/pasta_funcionalidade/`. Como esses
  scripts têm o redirect fixo para `html/headers/pasta.php`, depois de criar ou
  excluir você cai na tela **antiga**. Isso é do script original, não do protótipo.
- `quadro.php` e a virada dos cartões são novos — o quadro original era só um
  título e um parágrafo. Se preferir a página vazia, é só remover.
- Os ícones `fa-slab` e `fa-slab-press` vêm do kit Font Awesome já usado no
  projeto (`5f10733ee6`). Se o kit não tiver a família Slab habilitada, os ícones
  aparecem em branco — nesse caso troque por `fa-regular` / `fa-solid`.

## Rollback

Nada foi tocado fora desta pasta. Para descartar tudo:

```
git clean -fd frontendtest
```

ou simplesmente apague a pasta `frontendtest/`.

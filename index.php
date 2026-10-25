<?php
    require_once __DIR__ . '/php/sessao.php';
    if(isset($_SESSION["idUsuario"])){
        // caminho relativo: funciona na hospedagem e em ambiente local
        header("Location: html/index.php", true, 302);
        exit;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ciceus — Anotações, flashcards e questões para estudo ativo</title>
    <meta name="description" content="Anotações, banco de questões, flashcards com repetição espaçada, videoaulas sem distração e Pomodoro em uma única ferramenta de estudo ativo.">
    <link rel="canonical" href="https://www.ciceus.com/">
    <meta name="theme-color" content="#FAF9F5">

    <!-- Favicon: a barra inicial faz o caminho valer a partir da raiz do dominio,
         entao o mesmo bloco funciona aqui, em /html/ e em /html/headers/ -->
    <link rel="icon" href="/logo/favicon/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/logo/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/logo/favicon/site.webmanifest">

    <!-- Cartao de compartilhamento no WhatsApp, LinkedIn, X, Discord... -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.ciceus.com/">
    <meta property="og:site_name" content="Ciceus">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="Ciceus — Ferramenta de estudo ativo">
    <meta property="og:description" content="Anotações, questões, flashcards, videoaulas e Pomodoro reunidos em um só lugar.">
    <meta name="twitter:card" content="summary_large_image">

    <!-- preconnect abre a conexao com o servidor de fontes antes do CSS pedir os
         arquivos; economiza o custo de DNS + TLS no carregamento inicial -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@400;500;600&display=swap">

    <link rel="stylesheet" href="index.css?v=<?php echo filemtime(__DIR__ . '/index.css'); ?>">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>

    <!-- Dados estruturados: descrevem o produto em JSON para o Google.
         Nao mudam nada na tela, sao lidos so por robos. -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Ciceus",
      "url": "https://www.ciceus.com/",
      "applicationCategory": "EducationalApplication",
      "operatingSystem": "Navegador web",
      "inLanguage": "pt-BR",
      "description": "Ferramenta de estudo ativo que reúne anotações, banco de questões, flashcards com repetição espaçada, videoaulas sem distração, quadro branco e temporizador Pomodoro."
    }
    </script>
</head>
<body>

    <!-- ================= cabecalho ================= -->
    <header class="topo">
        <a class="topo-marca" href="/" aria-label="Ciceus, página inicial">
            <svg class="topo-logo" viewBox="0 0 512 512" width="30" height="30" aria-hidden="true" focusable="false"><path d="M460.994,200.379c11.845-22.438,14.678-52.681,8.38-90.043c-4.739-28.113-13.077-50.284-13.43-51.214l-5.564-14.676 l-15.64,1.357c-0.988,0.084-24.503,2.192-51.819,10.261c-27.22,8.041-48.625,19.048-63.996,32.834 c-20.823-6.88-42.001-10.493-62.926-10.493c-20.926,0-42.103,3.613-62.926,10.492c-15.371-13.787-36.775-24.792-63.996-32.834 c-27.316-8.069-50.831-10.176-51.819-10.261l-15.638-1.358l-5.564,14.678c-0.353,0.93-8.69,23.1-13.43,51.214 c-6.298,37.362-3.465,67.606,8.38,90.043C18.64,247.221,0,300.363,0,348.243v13.901l256,105.411l256-105.411v-13.901 C512,300.363,493.36,247.221,460.994,200.379z M422.144,89.39c5.543,19.659,11.341,49.214,7.903,72.711 c-20.584-21.867-43.329-39.878-67.203-53.516C381.462,98.451,404.874,92.434,422.144,89.39z M256,119.919 c44.278,0,90.657,20.589,130.26,57.192c-57.491,5.184-106.619,39.792-132.178,88.611c-27.53-46.995-77.489-79.324-135.081-82.173 C160.019,142.923,209.185,119.919,256,119.919z M89.802,89.46c7.799,1.38,17.728,3.488,28.188,6.616 c12.011,3.59,22.428,7.805,31.123,12.533c-23.884,13.648-46.635,31.672-67.221,53.552C78.369,138.741,84.129,109.392,89.802,89.46 z M256,422.662l-213.88-88.07c3.028-34.691,17.289-72.182,40.192-106.486c9.255-2.156,18.783-3.252,28.392-3.252 c59.162,0,108.818,41.469,121.437,96.865h46.357c9.912-58.826,61.202-103.784,122.801-103.784c7.674,0,15.316,0.708,22.798,2.089 c26.174,36.434,42.52,77.129,45.787,114.568L256,422.662z"></path><circle cx="359.784" cy="300.959" r="20.757"></circle><circle cx="152.216" cy="300.959" r="20.757"></circle><path d="M269.838,349.394H256h-13.838c-7.643,0-13.838,6.195-13.838,13.838c0,13.838,27.676,27.676,27.676,27.676 s27.676-13.838,27.676-27.676C283.676,355.59,277.48,349.394,269.838,349.394z"></path></svg>
            <span class="topo-nome">Ciceus</span>
        </a>

        <nav class="topo-navegacao" aria-label="Navegação principal">
            <a href="#recursos">Recursos</a>
            <a href="#metodo">Método</a>
            <a class="botao botao-contorno" href="/html/acesso.php">Entrar</a>
        </nav>
    </header>

    <main>

        <!-- ================= abertura ================= -->
        <section class="capa">
            <p class="capa-etiqueta">Ferramenta de estudo ativo</p>

            <h1 class="capa-titulo">
                Tudo o que você usa para estudar,<br>
                <em>em um lugar só</em>
            </h1>

            <p class="capa-texto">
                Anotar, testar, revisar e cronometrar costumam viver em quatro programas
                diferentes — e cada troca de janela custa concentração. O Ciceus reúne
                anotações, questões, flashcards, videoaulas, quadro e Pomodoro em uma única
                ferramenta, construída em torno de um princípio: você aprende quando
                <strong>recupera</strong> a informação, não quando relê.
            </p>

            <div class="capa-acoes">
                <a class="botao botao-principal" href="/html/acesso.php">Criar conta gratuita</a>
                <a class="botao botao-discreto" href="#recursos">Ver os recursos</a>
            </div>

            <p class="capa-nota">Funciona no navegador, sem instalar nada.</p>
        </section>

        <!-- ================= recursos ================= -->
        <section class="secao" id="recursos">
            <header class="secao-cabecalho">
                <h2 class="secao-titulo">Seis ferramentas, um fluxo</h2>
                <p class="secao-texto">
                    Cada aba resolve uma etapa do estudo, e todas compartilham a mesma
                    organização em pastas — o que você anota na aula vira material de revisão
                    sem precisar copiar nada de lugar.
                </p>
            </header>

            <div class="grade">

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-clipboard" aria-hidden="true"></i></span>
                    <h3>Anotações</h3>
                    <p>
                        Editor de texto com formatação, tabelas, imagens e fórmulas matemáticas.
                        Importe PDFs, organize em pastas e exporte o arquivo já formatado.
                    </p>
                </article>

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-question" aria-hidden="true"></i></span>
                    <h3>Banco de questões</h3>
                    <p>
                        Crie questões de múltipla escolha, discursivas ou de certo e errado.
                        Monte simulados por pasta e exporte em PDF com o gabarito ao final.
                    </p>
                </article>

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-copy" aria-hidden="true"></i></span>
                    <h3>Flashcards</h3>
                    <p>
                        Cartões frente e verso com repetição espaçada: cada carta reaparece no
                        intervalo certo conforme a dificuldade que você marcou ao revisá-la.
                    </p>
                </article>

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-circle-play" aria-hidden="true"></i></span>
                    <h3>Videoaulas</h3>
                    <p>
                        Cole um link do YouTube ou envie um vídeo e assista sem recomendações,
                        comentários nem barra lateral. As anotações que você fizer durante a
                        aula aparecem direto na aba de anotações.
                    </p>
                </article>

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-rectangle-wide" aria-hidden="true"></i></span>
                    <h3>Quadro</h3>
                    <p>
                        Espaço livre para desenhar, ligar ideias e montar mapas mentais, com
                        formas geométricas, texto, imagens e fórmulas.
                    </p>
                </article>

                <article class="cartao">
                    <span class="cartao-icone"><i class="fa-slab fa-regular fa-stopwatch" aria-hidden="true"></i></span>
                    <h3>Temporizador Pomodoro</h3>
                    <p>
                        Seletor circular para definir o ciclo de foco. Quando o tempo acaba, o
                        descanso começa sozinho — você não precisa tocar em nada.
                    </p>
                </article>

            </div>
        </section>

        <!-- ================= metodo ================= -->
        <section class="secao secao-destaque" id="metodo">
            <header class="secao-cabecalho">
                <h2 class="secao-titulo">Por que estudo ativo</h2>
                <p class="secao-texto">
                    Reler e grifar dão uma sensação forte de domínio, e é exatamente aí que
                    mora a armadilha: a facilidade de reconhecer um texto não é a mesma coisa
                    que conseguir lembrar dele numa prova.
                </p>
            </header>

            <ol class="passos">
                <li class="passo">
                    <span class="passo-numero">1</span>
                    <h3>Registre</h3>
                    <p>
                        Anote com suas próprias palavras enquanto assiste à aula ou lê o
                        material. Reescrever já é um primeiro processamento.
                    </p>
                </li>
                <li class="passo">
                    <span class="passo-numero">2</span>
                    <h3>Recupere</h3>
                    <p>
                        Transforme a anotação em pergunta — flashcard ou questão. Tentar
                        lembrar sem olhar a resposta é o que de fato fixa o conteúdo.
                    </p>
                </li>
                <li class="passo">
                    <span class="passo-numero">3</span>
                    <h3>Espace</h3>
                    <p>
                        Revise no intervalo em que você está prestes a esquecer. É quando o
                        esforço de lembrar é maior — e o ganho também.
                    </p>
                </li>
            </ol>
        </section>

        <!-- ================= chamada final ================= -->
        <section class="chamada">
            <h2>Comece a estudar de forma ativa</h2>
            <p>Crie sua conta e monte seu primeiro conjunto de anotações e flashcards hoje.</p>
            <a class="botao botao-principal" href="/html/acesso.php">Criar conta gratuita</a>
        </section>

    </main>

    <footer class="rodape">
        <p>Ciceus — ferramenta de estudo ativo e organizado.</p>
        <p><a href="/html/acesso.php">Entrar</a></p>
    </footer>

</body>
</html>

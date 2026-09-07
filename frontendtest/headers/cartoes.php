<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartões</title>

    <link rel="stylesheet" href="../css/headers/cartoes.css">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- ================= barra lateral (fixa) ================= -->
    <aside class="barra-lateral">
        <a class="marca" href="../index.php">
            <span class="marca-simbolo"><img src="../img/ciceus.svg" alt=""></span>
            <span class="marca-nome">Ciceus</span>
        </a>

        <nav class="navegacao">
            <p class="navegacao-rotulo">Estudo</p>
            <ul>
                <li><a href="../index.php"><i class="fa-slab fa-regular fa-house"></i><span>Inicial</span></a></li>
                <li><a href="nota.php"><i class="fa-slab fa-regular fa-clipboard"></i><span>Notas</span></a></li>
                <li><a href="questao.php"><i class="fa-slab fa-regular fa-question"></i><span>Questões</span></a></li>
                <li><a href="cartoes.php" class="ativo"><i class="fa-slab fa-regular fa-copy"></i><span>Cartões</span></a></li>
                <li><a href="quadro.php"><i class="fa-slab fa-regular fa-rectangle-wide"></i><span>Quadro</span></a></li>
                <li><a href="pasta.php"><i class="fa-slab fa-regular fa-folders"></i><span>Pastas</span></a></li>
                <li><a href="tempo.php"><i class="fa-slab fa-regular fa-stopwatch"></i><span>Temporizador</span></a></li>
            </ul>
        </nav>

        <button class="conta" type="button">
            <span class="conta-icone">
                <i class="fa-slab-press fa-regular fa-circle-user icone-repouso"></i>
                <i class="fa-slab fa-regular fa-circle-user icone-ativo"></i>
            </span>
            <span class="conta-texto">
                <strong>Minha conta</strong>
                <small>Ver perfil</small>
            </span>
        </button>
    </aside>
    <!-- ================= fim da barra lateral ================= -->

    <main class="pagina">
        <div class="pagina-interna">

            <div class="cartoes-topo">
                <header class="pagina-cabecalho" style="margin-bottom: 0;">
                    <span class="pagina-etiqueta">Cartões</span>
                    <h1>Revisão por memória</h1>
                    <p class="pagina-resumo">Clique em um cartão para ver a resposta. O baralho abaixo é apenas demonstrativo.</p>
                </header>
                <span class="cartoes-contagem">3 cartões</span>
            </div>

            <div class="cartoes-container">

                <div class="cartao" role="button" tabindex="0">
                    <div class="cartao-conteudo">
                        <div class="cartao-face">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Cartão 01</span>
                                <span class="cartao-disciplina">História</span>
                            </div>
                            <p class="cartao-texto">O que foi a Revolução Industrial?</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate"></i> Clique para virar
                            </div>
                        </div>
                        <div class="cartao-face cartao-face-verso">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Resposta</span>
                            </div>
                            <p class="cartao-texto">Processo de mecanização da produção iniciado na Inglaterra no século XVIII.</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate-left"></i> Voltar
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cartao" role="button" tabindex="0">
                    <div class="cartao-conteudo">
                        <div class="cartao-face">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Cartão 02</span>
                                <span class="cartao-disciplina">Biologia</span>
                            </div>
                            <p class="cartao-texto">Qual a função da mitocôndria?</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate"></i> Clique para virar
                            </div>
                        </div>
                        <div class="cartao-face cartao-face-verso">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Resposta</span>
                            </div>
                            <p class="cartao-texto">Produzir energia para a célula por meio da respiração celular.</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate-left"></i> Voltar
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cartao" role="button" tabindex="0">
                    <div class="cartao-conteudo">
                        <div class="cartao-face">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Cartão 03</span>
                                <span class="cartao-disciplina">Matemática</span>
                            </div>
                            <p class="cartao-texto">O que diz o Teorema de Pitágoras?</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate"></i> Clique para virar
                            </div>
                        </div>
                        <div class="cartao-face cartao-face-verso">
                            <div class="topo-cartao">
                                <span class="cartao-etiqueta">Resposta</span>
                            </div>
                            <p class="cartao-texto">Em um triângulo retângulo, a² = b² + c².</p>
                            <div class="cartao-rodape">
                                <i class="fa-slab fa-regular fa-rotate-left"></i> Voltar
                            </div>
                        </div>
                    </div>
                </div>

                <button class="cartao-novo" type="button">
                    <i class="fa-slab fa-regular fa-plus"></i>
                    Novo cartão
                </button>

            </div>

        </div>
    </main>

    <script src="../js/cartoes.js"></script>

</body>
</html>

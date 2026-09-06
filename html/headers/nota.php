<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <link rel="stylesheet" href="../../css/headers/nota.css"> <!-- link do css das notas -->
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>  <!-- fontawesome -->

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>
<body>

    <div class = "titulo">
        <h1>Ciceus</h1>
    </div>
    
    <!-- navbar -->
    <div class="navbar">
        <ul> 
            <li><a href="../index.php"><i class="fa-slab fa-regular fa-house"></i>Inicial</a></li>
            <li><a href="nota.php"><i class="fa-slab fa-regular fa-clipboard"></i>Notas</a></li>
            <li><a href="questao.php"><i class="fa-slab fa-regular fa-question"></i>Questões</a></li>
            <li><a href="cartoes.php"><i class="fa-slab fa-regular fa-copy"></i>Cartões</a></li>
            <li><a href="quadro.php"><i class="fa-slab fa-regular fa-rectangle-wide"></i>Quadro</a></li>
            <li><a href="pasta.php"><i class="fa-slab fa-regular fa-folders"></i>Pastas</a></li>
            <li><a href="tempo.php"><i class="fa-slab fa-regular fa-stopwatch"></i>Temporizador</a></li>
        </ul>
    </div>  
    <!-- fim da navbar -->

    <!-- conteudos -->
    <div class="conteudos">
        <h1>Notas</h1>
        <p>Aqui você pode acessar suas notas de estudo, organizá-las e revisá-las para melhorar seu aprendizado. Use esta seção para manter suas anotações e informações importantes sempre à mão.</p>

        <div class="editor-wrapper">
            <div id="editor-texto" style="height: 300px; background-color: white;">
            </div>
        </div>
    </div>
    <!-- fim dos conteudos -->

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="../../js/headers/nota.js"></script>


</body>
</html>

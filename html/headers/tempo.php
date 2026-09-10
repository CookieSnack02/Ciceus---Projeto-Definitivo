<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizador</title>
    <link rel="stylesheet" href="../../css/headers/tempo.css?v=<?php echo filemtime(__DIR__ . '/../../css/headers/tempo.css'); ?>">
    <script src="https://kit.fontawesome.com/5f10733ee6.js" crossorigin="anonymous"></script>  <!-- fontawesome -->

    <!-- favicon -->
    <link rel="icon" href="/logo/favicon/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/logo/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/logo/favicon/site.webmanifest">
</head>
<body>


        <!-- <svg fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M460.994,200.379c11.845-22.438,14.678-52.681,8.38-90.043c-4.739-28.113-13.077-50.284-13.43-51.214l-5.564-14.676 l-15.64,1.357c-0.988,0.084-24.503,2.192-51.819,10.261c-27.22,8.041-48.625,19.048-63.996,32.834 c-20.823-6.88-42.001-10.493-62.926-10.493c-20.926,0-42.103,3.613-62.926,10.492c-15.371-13.787-36.775-24.792-63.996-32.834 c-27.316-8.069-50.831-10.176-51.819-10.261l-15.638-1.358l-5.564,14.678c-0.353,0.93-8.69,23.1-13.43,51.214 c-6.298,37.362-3.465,67.606,8.38,90.043C18.64,247.221,0,300.363,0,348.243v13.901l256,105.411l256-105.411v-13.901 C512,300.363,493.36,247.221,460.994,200.379z M422.144,89.39c5.543,19.659,11.341,49.214,7.903,72.711 c-20.584-21.867-43.329-39.878-67.203-53.516C381.462,98.451,404.874,92.434,422.144,89.39z M256,119.919 c44.278,0,90.657,20.589,130.26,57.192c-57.491,5.184-106.619,39.792-132.178,88.611c-27.53-46.995-77.489-79.324-135.081-82.173 C160.019,142.923,209.185,119.919,256,119.919z M89.802,89.46c7.799,1.38,17.728,3.488,28.188,6.616 c12.011,3.59,22.428,7.805,31.123,12.533c-23.884,13.648-46.635,31.672-67.221,53.552C78.369,138.741,84.129,109.392,89.802,89.46 z M256,422.662l-213.88-88.07c3.028-34.691,17.289-72.182,40.192-106.486c9.255-2.156,18.783-3.252,28.392-3.252 c59.162,0,108.818,41.469,121.437,96.865h46.357c9.912-58.826,61.202-103.784,122.801-103.784c7.674,0,15.316,0.708,22.798,2.089 c26.174,36.434,42.52,77.129,45.787,114.568L256,422.662z"></path> </g> </g> <g> <g> <circle cx="359.784" cy="300.959" r="20.757"></circle> </g> </g> <g> <g> <circle cx="152.216" cy="300.959" r="20.757"></circle> </g> </g> <g> <g> <path d="M269.838,349.394H256h-13.838c-7.643,0-13.838,6.195-13.838,13.838c0,13.838,27.676,27.676,27.676,27.676 s27.676-13.838,27.676-27.676C283.676,355.59,277.48,349.394,269.838,349.394z"></path> </g> </g> </g></svg> -->
    <!-- navbar -->
    <div class="navbar">
        <div class="logo-ciceus">
            <svg fill="#c08552" height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M460.994,200.379c11.845-22.438,14.678-52.681,8.38-90.043c-4.739-28.113-13.077-50.284-13.43-51.214l-5.564-14.676 l-15.64,1.357c-0.988,0.084-24.503,2.192-51.819,10.261c-27.22,8.041-48.625,19.048-63.996,32.834 c-20.823-6.88-42.001-10.493-62.926-10.493c-20.926,0-42.103,3.613-62.926,10.492c-15.371-13.787-36.775-24.792-63.996-32.834 c-27.316-8.069-50.831-10.176-51.819-10.261l-15.638-1.358l-5.564,14.678c-0.353,0.93-8.69,23.1-13.43,51.214 c-6.298,37.362-3.465,67.606,8.38,90.043C18.64,247.221,0,300.363,0,348.243v13.901l256,105.411l256-105.411v-13.901 C512,300.363,493.36,247.221,460.994,200.379z M422.144,89.39c5.543,19.659,11.341,49.214,7.903,72.711 c-20.584-21.867-43.329-39.878-67.203-53.516C381.462,98.451,404.874,92.434,422.144,89.39z M256,119.919 c44.278,0,90.657,20.589,130.26,57.192c-57.491,5.184-106.619,39.792-132.178,88.611c-27.53-46.995-77.489-79.324-135.081-82.173 C160.019,142.923,209.185,119.919,256,119.919z M89.802,89.46c7.799,1.38,17.728,3.488,28.188,6.616 c12.011,3.59,22.428,7.805,31.123,12.533c-23.884,13.648-46.635,31.672-67.221,53.552C78.369,138.741,84.129,109.392,89.802,89.46 z M256,422.662l-213.88-88.07c3.028-34.691,17.289-72.182,40.192-106.486c9.255-2.156,18.783-3.252,28.392-3.252 c59.162,0,108.818,41.469,121.437,96.865h46.357c9.912-58.826,61.202-103.784,122.801-103.784c7.674,0,15.316,0.708,22.798,2.089 c26.174,36.434,42.52,77.129,45.787,114.568L256,422.662z"></path> </g> </g> <g> <g> <circle cx="359.784" cy="300.959" r="20.757"></circle> </g> </g> <g> <g> <circle cx="152.216" cy="300.959" r="20.757"></circle> </g> </g> <g> <g> <path d="M269.838,349.394H256h-13.838c-7.643,0-13.838,6.195-13.838,13.838c0,13.838,27.676,27.676,27.676,27.676 s27.676-13.838,27.676-27.676C283.676,355.59,277.48,349.394,269.838,349.394z"></path> </g> </g> </g></svg>
        </div>
   
        <div class="titulo">
            <h1>Ciceus</h1>
        </div>
        <ul> 
            <li><a href="../index.php"><span class="icone"><i class="fa-slab-press fa-regular fa-house icone-padrao"></i><i class="fa-slab fa-regular fa-house icone-hover"></i></span>Inicial</a></li>
            <li><a href="nota.php"><span class="icone"><i class="fa-slab-press fa-regular fa-clipboard icone-padrao"></i><i class="fa-slab fa-regular fa-clipboard icone-hover"></i></span>Notas</a></li>
            <li><a href="questao.php"><span class="icone"><i class="fa-slab-press fa-regular fa-question icone-padrao"></i><i class="fa-slab fa-regular fa-question icone-hover"></i></span>Questões</a></li>
            <li><a href="cartoes.php"><span class="icone"><i class="fa-slab-press fa-regular fa-copy icone-padrao"></i><i class="fa-slab fa-regular fa-copy icone-hover"></i></span>Cartões</a></li>
            <li><a href="quadro.php"><span class="icone"><i class="fa-slab-press fa-regular fa-rectangle-wide icone-padrao"></i><i class="fa-slab fa-regular fa-rectangle-wide icone-hover"></i></span>Quadro</a></li>
            <li><a href="pasta.php"><span class="icone"><i class="fa-slab-press fa-regular fa-folders icone-padrao"></i><i class="fa-slab fa-regular fa-folders icone-hover"></i></span>Pastas</a></li>
            <li><a href="tempo.php"><span class="icone"><i class="fa-slab-press fa-regular fa-stopwatch icone-padrao"></i><i class="fa-slab fa-regular fa-stopwatch icone-hover"></i></span>Temporizador</a></li>
        </ul>
    </div>  
    <!-- fim da navbar -->
    <!-- conteudos -->
    <div class="conteudos">
        <div class="timer-container" id="timer-container">
            <div class="drag-handle" id="drag-handle">≡</div>
            
            <h1>Temporizador</h1>
            
            <div class="circular-slider" id="circular-slider">
                <svg class="slider-svg" viewBox="0 0 200 200" width="300" height="300" id="slider-svg">
                    <!-- Fundo do círculo -->
                    <circle class="bg-circle" cx="100" cy="100" r="85" fill="none" stroke="#e0e0e0" stroke-width="15"></circle>
                    <!-- Círculo de progresso -->
                    <circle class="progress-circle" id="progress-circle" cx="100" cy="100" r="85" fill="none" stroke="#a27b5b" stroke-width="15" stroke-linecap="round" transform="rotate(-90 100 100)"></circle>
                    <!-- Bolinha de controle (thumb) -->
                    <circle class="slider-thumb" id="slider-thumb" cx="100" cy="15" r="12" fill="#fff" stroke="#a27b5b" stroke-width="4" style="cursor: pointer;"></circle>
                </svg>
                <div class="timer-display">
                    <p id="tempo" style="margin: 0;">25:00</p>
                </div>
            </div>

            <div class="controls">
                <button id="iniciar">Iniciar</button>
                <button id="pausar">Pausar</button>
                <button id="resetar">Resetar</button>
            </div>
            
            <div class="popup-toggle">
                <label style="cursor:pointer;"><input type="checkbox" id="popup-checkbox"> Abrir em Pop-up</label>
            </div>
        </div>
    </div>
    <!-- fim dos conteudos -->

    <script src="../../js/headers/timer.js?v=<?php echo filemtime(__DIR__ . '/../../js/headers/timer.js'); ?>"></script>
</body>
</html>

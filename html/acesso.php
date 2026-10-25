<?php
// quem ja esta logado nao precisa ver o login de novo
require_once __DIR__ . '/../php/sessao.php';
if (isset($_SESSION['idUsuario'])) {
    header('Location: index.php');
    exit;
}

$mensagemAviso = '';
$classeAviso = 'oculto';

if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastro') {
    $mensagemAviso = 'Conta criada com sucesso! Faça login para continuar.';
    $classeAviso = '';
} elseif (isset($_GET['erro'])) {
    $classeAviso = '';
    if ($_GET['erro'] === 'login') {
        $mensagemAviso = 'E-mail ou senha incorretos.';
    } elseif ($_GET['erro'] === 'email_duplicado') {
        $mensagemAviso = 'Este e-mail já está cadastrado.';
    } elseif ($_GET['erro'] === 'campos'|| $_GET['erro'] === 'campos_vazios') {
        $mensagemAviso = 'Preencha todos os campos obrigatórios.';
    } else {
        $mensagemAviso = 'Ocorreu um erro no servidor. Tente novamente.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso</title>

    <link rel="stylesheet" href="../css/acesso.css?v=<?php echo filemtime(__DIR__ . '/../css/acesso.css'); ?>"> <!-- link do css do acesso -->

    <!-- favicon -->
    <link rel="icon" href="/logo/favicon/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/logo/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/logo/favicon/site.webmanifest">
</head>
<body>


    <div class="acesso">

        <!-- cabeçalho -->
        <div class="acesso-cabecalho">
            <svg class="acesso-logo" viewBox="0 0 512 512" width="58" height="58" aria-label="Ciceus"><path d="M460.994,200.379c11.845-22.438,14.678-52.681,8.38-90.043c-4.739-28.113-13.077-50.284-13.43-51.214l-5.564-14.676 l-15.64,1.357c-0.988,0.084-24.503,2.192-51.819,10.261c-27.22,8.041-48.625,19.048-63.996,32.834 c-20.823-6.88-42.001-10.493-62.926-10.493c-20.926,0-42.103,3.613-62.926,10.492c-15.371-13.787-36.775-24.792-63.996-32.834 c-27.316-8.069-50.831-10.176-51.819-10.261l-15.638-1.358l-5.564,14.678c-0.353,0.93-8.69,23.1-13.43,51.214 c-6.298,37.362-3.465,67.606,8.38,90.043C18.64,247.221,0,300.363,0,348.243v13.901l256,105.411l256-105.411v-13.901 C512,300.363,493.36,247.221,460.994,200.379z M422.144,89.39c5.543,19.659,11.341,49.214,7.903,72.711 c-20.584-21.867-43.329-39.878-67.203-53.516C381.462,98.451,404.874,92.434,422.144,89.39z M256,119.919 c44.278,0,90.657,20.589,130.26,57.192c-57.491,5.184-106.619,39.792-132.178,88.611c-27.53-46.995-77.489-79.324-135.081-82.173 C160.019,142.923,209.185,119.919,256,119.919z M89.802,89.46c7.799,1.38,17.728,3.488,28.188,6.616 c12.011,3.59,22.428,7.805,31.123,12.533c-23.884,13.648-46.635,31.672-67.221,53.552C78.369,138.741,84.129,109.392,89.802,89.46 z M256,422.662l-213.88-88.07c3.028-34.691,17.289-72.182,40.192-106.486c9.255-2.156,18.783-3.252,28.392-3.252 c59.162,0,108.818,41.469,121.437,96.865h46.357c9.912-58.826,61.202-103.784,122.801-103.784c7.674,0,15.316,0.708,22.798,2.089 c26.174,36.434,42.52,77.129,45.787,114.568L256,422.662z"></path><circle cx="359.784" cy="300.959" r="20.757"></circle><circle cx="152.216" cy="300.959" r="20.757"></circle><path d="M269.838,349.394H256h-13.838c-7.643,0-13.838,6.195-13.838,13.838c0,13.838,27.676,27.676,27.676,27.676 s27.676-13.838,27.676-27.676C283.676,355.59,277.48,349.394,269.838,349.394z"></path></svg>
            <div class="acesso-marca">Ciceus</div>
            <h1 class="acesso-titulo" id="acesso-titulo">Bem-vindo de volta</h1>
            <p class="acesso-subtitulo" id="acesso-subtitulo">Entre com seu e-mail e senha para continuar.</p>
        </div>
        <!-- fim do cabeçalho -->

        <!-- cartão de acesso -->
        <div class="acesso-cartao">

            <!-- abas -->
            <div class="acesso-abas">
                <button type="button" class="aba ativa" data-aba="login">Entrar</button>
                <button type="button" class="aba" data-aba="cadastro">Criar conta</button>
            </div>
            <!-- fim das abas -->

            <!-- formulário de login -->
            <form action="../php/acessar_funcionalidade/acessar.php" class="acesso-formulario entrada-esquerda" id="formulario-login" method="POST" novalidate>
                <label class="campo">
                    <span class="campo-rotulo">E-mail</span>
                    <input class="campo-entrada" type="email" name="email" autocomplete="email" placeholder="voce@email.com">
                    <span class="campo-erro oculto" data-erro="email"></span>
                </label>
                <label class="campo">
                    <span class="campo-rotulo campo-rotulo-senha">
                        <span>Senha</span>
                        <span class="mostrar-senha">Mostrar</span>
                    </span>
                    <input class="campo-entrada" type="password" name="senha" autocomplete="current-password" placeholder="••••••••">
                    <span class="campo-erro oculto" data-erro="senha"></span>
                </label>
                <div class="esqueci-senha">
                    <a href="#">Esqueci minha senha</a>
                </div>
                <button class="acesso-botao" type="submit">Entrar</button>
            </form>
            <!-- fim do formulário de login -->

            <!-- formulário de cadastro -->
            <form action="../php/cadastro_funcionalidade/cadastrar.php" class="acesso-formulario oculto" id="formulario-cadastro" method="POST" novalidate>
                <label class="campo">
                    <span class="campo-rotulo">Nome de usuário</span>
                    <input class="campo-entrada" type="text" name="usuario" autocomplete="username" placeholder="Como quer ser chamado">
                    <span class="campo-erro oculto" data-erro="usuario"></span>
                </label>
                <label class="campo">
                    <span class="campo-rotulo">E-mail</span>
                    <input class="campo-entrada" type="email" name="email" autocomplete="email" placeholder="voce@email.com">
                    <span class="campo-erro oculto" data-erro="email"></span>
                </label>
                <label class="campo">
                    <span class="campo-rotulo campo-rotulo-senha">
                        <span>Senha</span>
                        <span class="mostrar-senha">Mostrar</span>
                    </span>
                    <input class="campo-entrada" type="password" name="senha" autocomplete="new-password" placeholder="Mínimo de 8 caracteres">
                    <span class="campo-erro oculto" data-erro="senha"></span>
                </label>
                <label class="campo">
                    <span class="campo-rotulo">Telefone</span>
                    <input class="campo-entrada" type="tel" name="telefone" autocomplete="tel" placeholder="(11) 99999-9999">
                    <span class="campo-erro oculto" data-erro="telefone"></span>
                </label>
                <div class="campo-duplo">
                    <label class="campo">
                        <span class="campo-rotulo">Data de nascimento</span>
                        <input class="campo-entrada" type="date" name="dtNascimento">
                        <span class="campo-erro oculto" data-erro="dtNascimento"></span>
                    </label>
                    <label class="campo">
                        <span class="campo-rotulo">Sexo <span class="campo-opcional">(opcional)</span></span>
                        <select class="campo-entrada" name="sexo">
                            <option value="">Prefiro não declarar</option>
                            <option value="feminino">Feminino</option>
                            <option value="masculino">Masculino</option>
                            <option value="nao-binario">Não-binário</option>
                            <option value="outro">Outro</option>
                        </select>
                    </label>
                </div>
                <button class="acesso-botao" type="submit">Criar conta</button>
                <div class="acesso-termos">Ao criar a conta você concorda com os <a href="#">termos de uso</a> e a <a href="#">política de privacidade</a>.</div>
            </form>
            <!-- fim do formulário de cadastro -->

            <div class="acesso-aviso <?php echo $classeAviso ?>" id="acesso-aviso"><?php echo htmlspecialchars($mensagemAviso) ?></div>
        </div>
        <!-- fim do cartão de acesso -->

        <div class="acesso-rodape">Seus dados ficam protegidos.</div>
    </div>

<script src="../js/acesso.js?v=<?php echo filemtime(__DIR__ . '/../js/acesso.js'); ?>"></script>

</body>
</html>

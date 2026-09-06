const abas = document.querySelectorAll('.aba');
const formularioLogin = document.getElementById('formulario-login');
const formularioCadastro = document.getElementById('formulario-cadastro');
const titulo = document.getElementById('acesso-titulo');
const subtitulo = document.getElementById('acesso-subtitulo');
const aviso = document.getElementById('acesso-aviso');

// Textos do cabeçalho de cada aba
const textos = {
    login: {
        titulo: 'Bem-vindo de volta',
        subtitulo: 'Entre com seu e-mail e senha para continuar.'
    },
    cadastro: {
        titulo: 'Crie sua conta',
        subtitulo: 'Leva menos de um minuto. Só o essencial.'
    }
};

function limparErros(formulario) {
    formulario.querySelectorAll('.campo-erro').forEach((erro) => {
        erro.textContent = '';
        erro.classList.add('oculto');
    });
}

function mostrarErro(formulario, campo, mensagem) {
    const erro = formulario.querySelector(`[data-erro="${campo}"]`);
    if (!erro) return;
    erro.textContent = mensagem;
    erro.classList.remove('oculto');
}

function esconderAviso() {
    aviso.textContent = '';
    aviso.classList.add('oculto');
}

function mostrarAviso(mensagem) {
    aviso.textContent = mensagem;
    aviso.classList.remove('oculto');
}

function trocarAba(modo) {
    const ehLogin = modo === 'login';

    abas.forEach((aba) => aba.classList.toggle('ativa', aba.dataset.aba === modo));

    formularioLogin.classList.toggle('oculto', !ehLogin);
    formularioCadastro.classList.toggle('oculto', ehLogin);

    // Reinicia a animação de entrada do formulário exibido
    formularioLogin.classList.remove('entrada-esquerda');
    formularioCadastro.classList.remove('entrada-direita');
    void formularioLogin.offsetWidth;
    formularioLogin.classList.toggle('entrada-esquerda', ehLogin);
    formularioCadastro.classList.toggle('entrada-direita', !ehLogin);

    titulo.textContent = textos[modo].titulo;
    subtitulo.textContent = textos[modo].subtitulo;

    limparErros(formularioLogin);
    limparErros(formularioCadastro);
    esconderAviso();
}

abas.forEach((aba) => {
    aba.addEventListener('click', () => trocarAba(aba.dataset.aba));
});

// Mostrar e ocultar a senha
document.querySelectorAll('.mostrar-senha').forEach((botao) => {
    botao.addEventListener('click', () => {
        const formulario = botao.closest('form');
        const senha = formulario.querySelector('input[name="senha"]');

        if (senha.type === 'password') {
            senha.type = 'text';
            botao.textContent = 'Ocultar';
        } else {
            senha.type = 'password';
            botao.textContent = 'Mostrar';
        }
    });
});

// Máscara do telefone: (11) 99999-9999
function mascaraTelefone(valor) {
    const digitos = valor.replace(/\D/g, '').slice(0, 11);

    if (digitos.length <= 2) return digitos.length ? '(' + digitos : '';
    if (digitos.length <= 6) return '(' + digitos.slice(0, 2) + ') ' + digitos.slice(2);
    if (digitos.length <= 10) return '(' + digitos.slice(0, 2) + ') ' + digitos.slice(2, 6) + '-' + digitos.slice(6);
    return '(' + digitos.slice(0, 2) + ') ' + digitos.slice(2, 7) + '-' + digitos.slice(7);
}

const telefone = formularioCadastro.querySelector('input[name="telefone"]');

telefone.addEventListener('input', () => {
    telefone.value = mascaraTelefone(telefone.value);
});

// Limpa o erro do campo assim que o usuário corrige
document.querySelectorAll('.campo-entrada').forEach((entrada) => {
    entrada.addEventListener('input', () => {
        const formulario = entrada.closest('form');
        const erro = formulario.querySelector(`[data-erro="${entrada.name}"]`);

        if (erro) {
            erro.textContent = '';
            erro.classList.add('oculto');
        }

        esconderAviso();
    });
});

function emailValido(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
}

formularioLogin.addEventListener('submit', (e) => {
    e.preventDefault();
    limparErros(formularioLogin);
    esconderAviso();

    const email = formularioLogin.querySelector('input[name="email"]').value;
    const senha = formularioLogin.querySelector('input[name="senha"]').value;
    let valido = true;

    if (!emailValido(email)) {
        mostrarErro(formularioLogin, 'email', 'Informe um e-mail válido.');
        valido = false;
    }

    if (!senha) {
        mostrarErro(formularioLogin, 'senha', 'Informe sua senha.');
        valido = false;
    }

    if (!valido) return;

    mostrarAviso('Acesso liberado. Redirecionando…');
});

formularioCadastro.addEventListener('submit', (e) => {
    e.preventDefault();
    limparErros(formularioCadastro);
    esconderAviso();

    const usuario = formularioCadastro.querySelector('input[name="usuario"]').value;
    const email = formularioCadastro.querySelector('input[name="email"]').value;
    const senha = formularioCadastro.querySelector('input[name="senha"]').value;
    const dtNascimento = formularioCadastro.querySelector('input[name="dtNascimento"]').value;
    let valido = true;

    if (usuario.trim().length < 3) {
        mostrarErro(formularioCadastro, 'usuario', 'Use ao menos 3 caracteres.');
        valido = false;
    }

    if (!emailValido(email)) {
        mostrarErro(formularioCadastro, 'email', 'Informe um e-mail válido.');
        valido = false;
    }

    if (senha.length < 8) {
        mostrarErro(formularioCadastro, 'senha', 'A senha precisa de 8 caracteres ou mais.');
        valido = false;
    }

    if (telefone.value.replace(/\D/g, '').length < 10) {
        mostrarErro(formularioCadastro, 'telefone', 'Informe DDD e número.');
        valido = false;
    }

    if (!dtNascimento) {
        mostrarErro(formularioCadastro, 'dtNascimento', 'Informe sua data de nascimento.');
        valido = false;
    } else if (new Date(dtNascimento) > new Date()) {
        mostrarErro(formularioCadastro, 'dtNascimento', 'Data no futuro.');
        valido = false;
    }

    if (!valido) return;

    mostrarAviso('Conta criada com sucesso. Verifique seu e-mail.');
});

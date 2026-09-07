/* Quadro — desenho livre em canvas (protótipo) */

const prancheta = document.getElementById('prancheta');
const canvas = document.getElementById('quadro-canvas');
const ctx = canvas.getContext('2d');

let corAtual = '#1C1A17';
let ferramenta = 'caneta';
let desenhando = false;

/* mantém o canvas na resolução real da tela, preservando o traço já feito */
function ajustarCanvas() {
    const escala = window.devicePixelRatio || 1;
    const largura = prancheta.clientWidth;
    const altura = prancheta.clientHeight;

    const copia = document.createElement('canvas');
    copia.width = canvas.width;
    copia.height = canvas.height;
    if (canvas.width && canvas.height) {
        copia.getContext('2d').drawImage(canvas, 0, 0);
    }

    canvas.width = largura * escala;
    canvas.height = altura * escala;

    ctx.setTransform(escala, 0, 0, escala, 0, 0);
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    if (copia.width && copia.height) {
        ctx.drawImage(copia, 0, 0, copia.width / escala, copia.height / escala);
    }
}

ajustarCanvas();
window.addEventListener('resize', ajustarCanvas);

function posicao(evento) {
    const area = canvas.getBoundingClientRect();
    return { x: evento.clientX - area.left, y: evento.clientY - area.top };
}

function aplicarEstilo() {
    if (ferramenta === 'borracha') {
        ctx.globalCompositeOperation = 'destination-out';
        ctx.lineWidth = 18;
    } else {
        ctx.globalCompositeOperation = 'source-over';
        ctx.strokeStyle = corAtual;
        ctx.lineWidth = 2.4;
    }
}

canvas.addEventListener('pointerdown', (evento) => {
    desenhando = true;
    canvas.setPointerCapture(evento.pointerId);
    prancheta.classList.add('rabiscada');

    const p = posicao(evento);
    aplicarEstilo();
    ctx.beginPath();
    ctx.moveTo(p.x, p.y);
});

canvas.addEventListener('pointermove', (evento) => {
    if (!desenhando) return;
    const p = posicao(evento);
    ctx.lineTo(p.x, p.y);
    ctx.stroke();
});

['pointerup', 'pointerleave', 'pointercancel'].forEach((nome) => {
    canvas.addEventListener(nome, () => {
        desenhando = false;
        ctx.closePath();
    });
});

/* ---------- barra de ferramentas ---------- */
document.querySelectorAll('.ferramenta[data-ferramenta]').forEach((botao) => {
    botao.addEventListener('click', () => {
        document.querySelectorAll('.ferramenta[data-ferramenta]')
            .forEach((b) => b.classList.remove('ativa'));
        botao.classList.add('ativa');
        ferramenta = botao.dataset.ferramenta;
    });
});

document.querySelectorAll('.ferramenta[data-cor]').forEach((botao) => {
    botao.addEventListener('click', () => {
        corAtual = botao.dataset.cor;
        ferramenta = 'caneta';

        document.querySelectorAll('.ferramenta[data-ferramenta]')
            .forEach((b) => b.classList.toggle('ativa', b.dataset.ferramenta === 'caneta'));
    });
});

document.getElementById('limpar-quadro').addEventListener('click', () => {
    ctx.save();
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.restore();
    prancheta.classList.remove('rabiscada');
});

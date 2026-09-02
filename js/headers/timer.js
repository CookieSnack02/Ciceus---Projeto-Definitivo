const tempo = document.getElementById('tempo');
const iniciar = document.getElementById('iniciar');
const pausar = document.getElementById('pausar');
const resetar = document.getElementById('resetar');
const progressCircle = document.getElementById('progress-circle');
const thumb = document.getElementById('slider-thumb');
const svg = document.getElementById('slider-svg');

let tempoInicial = 25 * 60; // 25 minutos padrão
let tempoRestante = tempoInicial;
let intervalo = null;

const radius = 85;
const circumference = 2 * Math.PI * radius;

progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;

function atualizarDisplay() {
    const minutos = Math.floor(tempoRestante / 60);
    const segundos = tempoRestante % 60;
    tempo.textContent = `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
    
    // Atualiza progresso da borda SVG
    const percent = tempoRestante / tempoInicial;
    const offset = circumference - (percent * circumference);
    progressCircle.style.strokeDashoffset = offset;
}

function setTempoInicial(minutos) {
    if (intervalo) return; // Não mudar se estiver rodando
    
    if (minutos < 10) minutos = 10;
    if (minutos > 60) minutos = 60;
    
    tempoInicial = minutos * 60;
    tempoRestante = tempoInicial;
    
    // Calcula posição visual da bolinha
    const angleDeg = (minutos === 60) ? 0 : (minutos / 60) * 360;
    const angleRad = (angleDeg - 90) * (Math.PI / 180);
    
    const cx = 100 + radius * Math.cos(angleRad);
    const cy = 100 + radius * Math.sin(angleRad);
    
    thumb.setAttribute('cx', cx);
    thumb.setAttribute('cy', cy);
    
    const percent = minutos / 60;
    const offset = circumference - (percent * circumference);
    progressCircle.style.strokeDashoffset = offset;
    
    atualizarDisplay();
}

let isDragging = false;

function handleDrag(e) {
    if (!isDragging || intervalo) return; // desativa se tiver rodando
    e.preventDefault();
    
    let clientX, clientY;
    if (e.touches) {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    } else {
        clientX = e.clientX;
        clientY = e.clientY;
    }
    
    const rect = svg.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;
    
    const x = clientX - centerX;
    const y = clientY - centerY;
    
    let angle = Math.atan2(y, x);
    let angleDeg = angle * (180 / Math.PI);
    angleDeg = (angleDeg + 90) % 360;
    if (angleDeg < 0) angleDeg += 360;
    
    let minutos = Math.round((angleDeg / 360) * 60);
    if (minutos === 0) minutos = 60;
    
    setTempoInicial(minutos);
}

// Mouse events
thumb.addEventListener('mousedown', () => isDragging = true);
svg.addEventListener('mousedown', (e) => {
    isDragging = true;
    handleDrag(e);
});
window.addEventListener('mousemove', handleDrag);
window.addEventListener('mouseup', () => isDragging = false);

// Touch events para mobile
thumb.addEventListener('touchstart', () => isDragging = true, {passive: false});
svg.addEventListener('touchstart', (e) => {
    isDragging = true;
    handleDrag(e);
}, {passive: false});
window.addEventListener('touchmove', handleDrag, {passive: false});
window.addEventListener('touchend', () => isDragging = false);

iniciar.addEventListener('click', () => {
    if (intervalo) return;
    
    iniciar.disabled = true;
    svg.style.opacity = "0.7";
    thumb.style.display = "none"; // Esconde a bolinha para não arrastar rodando
    
    intervalo = setInterval(() => {
        tempoRestante--;
        atualizarDisplay();

        if (tempoRestante <= 0) {
            clearInterval(intervalo);
            intervalo = null;
            iniciar.disabled = false;
            svg.style.opacity = "1";
            thumb.style.display = "block";
            tempoRestante = tempoInicial;
            atualizarDisplay();
        }
    }, 1000);
});

pausar.addEventListener('click', () => {
    if(!intervalo) return;
    clearInterval(intervalo);
    intervalo = null;
    iniciar.disabled = false;
    svg.style.opacity = "1";
    thumb.style.display = "block";
});

resetar.addEventListener('click', () => {
    clearInterval(intervalo);
    intervalo = null;
    iniciar.disabled = false;
    svg.style.opacity = "1";
    thumb.style.display = "block";
    setTempoInicial(tempoInicial / 60);
});

// Inicia com 25 minutos
setTempoInicial(25);

// Lógica do Pop-up Flutuante
const dragHandle = document.getElementById('drag-handle');
const timerContainer = document.getElementById('timer-container');
const popupCheckbox = document.getElementById('popup-checkbox');

popupCheckbox.addEventListener('change', (e) => {
    if (e.target.checked) {
        timerContainer.classList.add('is-popup');
        // Posição padrão quando abre
        timerContainer.style.bottom = '20px';
        timerContainer.style.right = '20px';
        timerContainer.style.top = 'auto';
        timerContainer.style.left = 'auto';
    } else {
        timerContainer.classList.remove('is-popup');
        // Reseta estilos inline
        timerContainer.style.top = '';
        timerContainer.style.left = '';
        timerContainer.style.bottom = '';
        timerContainer.style.right = '';
        timerContainer.style.width = '';
        timerContainer.style.height = '';
    }
});

let isDraggingPopup = false;
let startXPopup, startYPopup, initialLeft, initialTop;

dragHandle.addEventListener('mousedown', (e) => {
    isDraggingPopup = true;
    startXPopup = e.clientX;
    startYPopup = e.clientY;
    const rect = timerContainer.getBoundingClientRect();
    initialLeft = rect.left;
    initialTop = rect.top;
    
    // Converte para posicionamento top/left para facilitar o arraste
    timerContainer.style.bottom = 'auto';
    timerContainer.style.right = 'auto';
    timerContainer.style.left = initialLeft + 'px';
    timerContainer.style.top = initialTop + 'px';
});

window.addEventListener('mousemove', (e) => {
    if (!isDraggingPopup) return;
    const dx = e.clientX - startXPopup;
    const dy = e.clientY - startYPopup;
    timerContainer.style.left = (initialLeft + dx) + 'px';
    timerContainer.style.top = (initialTop + dy) + 'px';
});

window.addEventListener('mouseup', () => {
    isDraggingPopup = false;
});
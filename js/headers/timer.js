const tempo = document.getElementById('tempo');
const iniciar = document.getElementById('iniciar');
const pausar = document.getElementById('pausar');
const resetar = document.getElementById('resetar');

const tempoInicial = 25 * 60; 
let tempoRestante = tempoInicial;
let intervalo = null;


function atualizarDisplay(){
    const minutos = Math.floor(tempoRestante / 60);
    const segundos = tempoRestante % 60;
    tempo.textContent = `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
}

iniciar.addEventListener('click', () => {
    if (intervalo) return; // já está rodando, evita criar vários intervalos

    intervalo = setInterval(() => {
        tempoRestante--;
        atualizarDisplay();

        if (tempoRestante === 0) {
            clearInterval(intervalo);
            intervalo = null;
        }
    }, 1000);
});

pausar.addEventListener('click', () => {
    clearInterval(intervalo);
    intervalo = null;
});

resetar.addEventListener('click', () => {
    clearInterval(intervalo);
    intervalo = null;
    tempoRestante = tempoInicial;
    atualizarDisplay();
});
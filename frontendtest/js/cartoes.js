/* Cartões — vira a face ao clicar (protótipo) */

document.querySelectorAll('.cartao').forEach((cartao) => {
    function virar() {
        cartao.classList.toggle('virado');
    }

    cartao.addEventListener('click', virar);

    /* o cartão é uma div com role="button": teclado precisa ser tratado à mão */
    cartao.addEventListener('keydown', (evento) => {
        if (evento.key === 'Enter' || evento.key === ' ') {
            evento.preventDefault();
            virar();
        }
    });
});

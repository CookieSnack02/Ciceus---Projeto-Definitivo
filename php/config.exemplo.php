<?php

/* modelo das credenciais do banco. copie e preencha com os dados reais:
   - na hospedagem: salve como ciceus_config.php na pasta ACIMA da
     public_html (o deploy pelo git nao apaga e o navegador nao acessa)
   - local: salve como config.php nesta mesma pasta
   o config.php esta no .gitignore e nunca deve ir para o repositorio */

return [
    'host'         => 'localhost',
    'bancoDeDados' => 'nome_do_banco',
    'usuario'      => 'usuario_do_banco',
    'senha'        => 'senha_do_banco'
];

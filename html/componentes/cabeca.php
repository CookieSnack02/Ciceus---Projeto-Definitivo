<?php
/* <head> comum das paginas internas.
   antes de incluir, a pagina define:
     $tituloPagina -> texto da aba do navegador
     $cssPagina    -> css proprio da pagina a partir da raiz (opcional)
   os caminhos comecam com "/" para valer igual em /html/ e em /html/headers/ */

$raiz = dirname(__DIR__, 2);

// o ?v= muda quando o arquivo muda, entao o navegador nao usa um css velho do cache
function versao($caminho)
{
    global $raiz;
    return $caminho . '?v=' . @filemtime($raiz . $caminho);
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina ?? 'Ciceus'); ?> · Ciceus</title>

    <!-- fontes: as mesmas da tela de acesso -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@400;500;600&display=swap">

    <!-- icones: phosphor (gratuito, licenca MIT). "ph" e o contorno, "ph-fill" o preenchido -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/fill/style.css">

    <link rel="stylesheet" href="<?php echo versao('/css/base.css'); ?>">
<?php if (!empty($cssPagina)): ?>
    <link rel="stylesheet" href="<?php echo versao($cssPagina); ?>">
<?php endif; ?>

    <!-- favicon -->
    <link rel="icon" href="/logo/favicon/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/logo/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/logo/favicon/site.webmanifest">

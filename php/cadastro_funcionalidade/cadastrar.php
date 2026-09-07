<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nomeUsuario = trim($_POST['usuario'] ?? '');
    $emailUsuario = trim($_POST['email'] ?? '');
    $senhaUsuarioBruta = trim($_POST['senha'] ?? '');
    $telefoneUsuario = trim($_POST['telefone'] ?? '');
    $dtNascimentoUsuario = trim($_POST['dtNascimento'] ?? '');
    $sexoUsuario = trim($_POST['sexo'] ?? '');

    if($sexoUsuario === '') { //Vazio não-definido -> Prefiro não declarar
        $sexoUsuario = null; 
    }
    if($sexoUsuario === 'masculino'){
        $sexoUsuario = 'M'; 
    }
    if($sexoUsuario === 'feminino'){
        $sexoUsuario = 'F'; 
    }

    if($sexoUsuario === 'nao-binario'){
        $sexoUsuario = 'N';
    }

    if($sexoUsuario === 'outro'){
        $sexoUsuario = 'O';
    }



    if(!empty ($nomeUsuario) && !empty ($emailUsuario) && !empty ($senhaUsuarioBruta) && !empty ($telefoneUsuario) && !empty ($dtNascimentoUsuario)) {
        require_once '../conexao.php';

        try {
            $insercaoUsuario = $pdo->prepare("INSERT INTO ciceus (nmUsuario, emailUsuario, senhaUsuario, telefoneUsuario, dtNasUsuario, sxUsuario) VALUES (:nome, :email, :senha, :telefone, :dtNascimento, :sexo)");
            $insercaoUsuario->bindValue(':nome', $nomeUsuario);
            $insercaoUsuario->bindValue(':email', $emailUsuario);
            $insercaoUsuario->bindValue(':senha', password_hash($senhaUsuarioBruta, PASSWORD_DEFAULT));
            $insercaoUsuario->bindValue(':telefone', $telefoneUsuario);
            $insercaoUsuario->bindValue(':dtNascimento', $dtNascimentoUsuario);
            $insercaoUsuario->bindValue(':sexo', $sexoUsuario);
            $insercaoUsuario->execute();

            header("Location: ../../html/acesso.php?sucesso=cadastro");
            exit; 
        } catch (PDOException $e) {
            
            if(isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) { // Código de erro para violação de chave única (duplicata)
                header("Location: ../../html/acesso.php?erro=email_duplicado");
                exit; 
            } else {
                header("Location: ../../html/acesso.php?erro=banco");
                exit; 
            }
        }

    } else{
        
        header("Location: ../../html/acesso.php?erro=campos_vazios");
        exit;
    }

   } else{
    header("Location: ../../html/acesso.php");
    exit;

}
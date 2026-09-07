<?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../conexao.php';

        $emailUsuario = trim($_POST['email'] ?? ''); 
        $senhaUsuario = trim($_POST['senha'] ?? ''); 

        if(!empty($emailUsuario) && !empty($senhaUsuario)){

            try{
                $buscarDados = $pdo->prepare("SELECT * FROM ciceus WHERE emailUsuario = :email"); 
                $buscarDados->bindValue(':email', $emailUsuario); 
                $buscarDados->execute(); 

                // `PDO:FETCH_ASSOC` é uma associação que retorna os dados em vez de números o próprio nome da coluna  
                $buscarDados = $buscarDados->fetch(PDO::FETCH_ASSOC);

                if($buscarDados && password_verify($senhaUsuario, $buscarDados['senhaUsuario'])){
                    session_start(); // cria uma sessão ou continua a sessão atual baseado em um ID de sessão passado via GET ou POST, ou passado via cookie. (https://www.php.net/manual/pt_BR/function.session-start.php) -> princípio KISS — Keep It Simple, Stupid

                    //Posteriormente pode ser implementado um sistema de regeneração de ID de sessão para manter a segurança da sessão, mas por enquanto não é necessário, pois o sistema ainda não está em produção e não há risco de ataques de sequestro de sessão (session hijacking). Isso também ajudaria a previnir um Race Condition Attack, que é um ataque que ocorre quando dois processos tentam acessar o mesmo recurso ao mesmo tempo, e um deles consegue acessar antes do outro. Isso pode ser explorado por um atacante para obter acesso não autorizado a recursos do sistema.

                    $_SESSION['idUsuario'] = $buscarDados['idCiceus']; // Armazena o ID do usuário na sessão
                    $_SESSION['emailUsuario'] = $buscarDados['emailUsuario']; // Armazena o e-mail do usuário na sessão
                    header("Location: ../../html/index.php"); 
                    exit; 
                } else{ // Se o usuário não for encontrado ou a senha estiver incorreta, redireciona para a página de acesso com uma mensagem de erro
                    header("Location: ../../html/acesso.php?erro=login");
                    exit;
                }

            } catch (PDOException $e) {
                // Tratar erro
                header("Location: ../../html/acesso.php?erro=banco");
                exit;
            }

        } else{
            header("Location: ../../html/acesso.php?erro=campos_vazios");
            exit;
        }

    } else{
        header("Location: ../../html/acesso.php");
        exit;
    }



?> 

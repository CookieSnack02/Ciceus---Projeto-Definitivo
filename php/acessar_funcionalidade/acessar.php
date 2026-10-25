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
                    require_once '../sessao.php'; // abre a sessao com o cookie protegido (httponly, samesite)

                    // gera um ID de sessao novo no login: um ID que alguem tenha plantado antes
                    // no navegador da vitima deixa de valer (protege contra fixacao de sessao)
                    session_regenerate_id(true);

                    $_SESSION['idUsuario'] = $buscarDados['idCiceus']; // Armazena o ID do usuário na sessão
                    $_SESSION['nomeUsuario'] = $buscarDados['nmUsuario']; // Armazena o nome para exibir nas paginas
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

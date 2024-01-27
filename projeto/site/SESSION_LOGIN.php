<!DOCTYPE html>
<html>
    <html lang="pt-br">
    <head>
        <title>PROJETO ALPHA - MB</title>
        <meta charset="utf-8mb4">

        <link rel="stylesheet" href="css/design.css">
    </head>
    <body>
        <?php
            session_start();
            include('conexao.php');
        
            if(isset($_REQUEST['valor']) && ($_REQUEST['valor'] == 'enviado'))
            {
                $botao = $_POST['botao'];
                $emailLogin = $_POST['email_login'];
                $senhaLogin = $_POST['senha_login'];

                try
                {
                    if($botao == 'LOGAR')
                    {
                        $login = $conexao -> prepare("SELECT * FROM tb_cliente
                                                        WHERE email_cliente = ? AND senha_cliente = ?");

                        $login -> bindParam(1, $emailLogin);
                        $login -> bindParam(2, $senhaLogin);

                        if($login -> execute())
                        {
                            if($login -> rowCount() > 0)
                            {
                                while ($linha = $login -> fetch(PDO::FETCH_OBJ))
                                {
                                    $idCliente = $linha -> id_cliente;
                                    $_SESSION['idClienteLogado'] = $idCliente;

                                    $nomeCliente = $linha -> nome_cliente;
                                    $_SESSION['nomeClienteLogado'] = $nomeCliente;

                                    $enderecoCliente = $linha -> end_cliente;
                                    $_SESSION['enderecoClienteLogado'] = $enderecoCliente;

                                    $emailCliente = $linha -> email_cliente;
                                    $_SESSION['emailClienteLogado'] = $emailCliente;

                                    $senhaCliente = $linha -> senha_cliente;
                                    $_SESSION['senhaClienteLogado'] = $senhaCliente;
                                }

                                header('location:SESSION_PAGAMENTO.php');
                            }
                            else
                            {
                                echo("<script>alert(\"Login e/ou senha não encontrada!!! Tente novamente, " .
                                     "ou cadastre-se se ainda não o tiver feito.\")</script>");
        ?>
                                <meta http-equiv="refresh" content="0 URL=SESSION_LOGIN.php">
        <?php
                            }
                        }
                    }
                    if($botao == 'CADASTRAR-SE')
                    {
                        header('location:SESSION_CADASTRO.php');
                    }
                    if($botao == 'ESQUECEU SUA SENHA?')
                    {
                        header('location:SESSION_ESQ_SENHA.php');
                    }
                }
                catch(PDOException $erro)
                {
                    echo("ERRO: " . $erro -> getMessage());
                }
            }
            else
            {
        ?>
                <h2>LOGIN</h2>

                <form action="SESSION_LOGIN.php?valor=enviado" method="post">
                    <label>Usuário: </label><br>
                    <input type="email" name="email_login" maxlength="35" placeholder="Digite seu e-mail"><br><br>

                    <label>Senha: </label><br>
                    <input type="password" name="senha_login" maxlength="20"><br><br>

                    <input type="submit" name="botao" value="LOGAR" class="botao">
                    <input type="submit" name="botao" value="CADASTRAR-SE" class="botao"><br><br>

                    <input type="submit" name="botao" value="ESQUECEU SUA SENHA?" class="botao">
                </form>
        <?php
            }
        ?>
    </body>
</html>
<!DOCTYPE html>
<html>
    <html lang="pt-br">
    <head>
        <title>PROJETO ALPHA - MB</title>
        <meta charset="utf-8mb4">

        <link rel="stylesheet" href="css/design.css">
        <script>
            function SenhaCorresp()
            {
                const senha = document.querySelector('#nova_senha').value;
                const conf_senha = document.querySelector('#conf_nova_senha').value;
                const botao = document.querySelector('#botao');
                const aviso = document.querySelector('#aviso');

                if(senha == "" || conf_senha == "" || senha != conf_senha)
                {
                    botao.disabled = true;
                    aviso.innerHTML = "";
                    
                    return;
                }
                else
                {
                    botao.disabled = false;
                    aviso.innerHTML = "As senhas correspondem!!";
                    
                    return;
                }
            }
        </script>
    </head>
    <body>
        <?php
            session_start();
            include('conexao.php');

            if(isset($_REQUEST['valor']) && ($_REQUEST['valor'] == 'enviado'))
            {
                $novaSenha = $_POST['nova_senha'];
                $emailRecSenha = $_SESSION['emailRecSenha'];

                if($novaSenha == $_POST['confirm_nova_senha'])
                {
                    $recuperacao = $conexao -> prepare("UPDATE tb_cliente SET senha_cliente = ?
                                                        WHERE email_cliente = ?");

                    $recuperacao -> bindParam(1, $novaSenha);
                    $recuperacao -> bindParam(2, $emailRecSenha);

                    if($recuperacao -> execute())
                    {
                        if($recuperacao -> rowCount() > 0)
                        {
                            echo("<script>alert(\"Sua Senha foi Redefinida com Sucesso!! Você será redirecionado para a Página de Login.\")</script>");
        ?>
                            <meta http-equiv="refresh" content="0 URL=SESSION_LOGIN.php">
        <?php
                            $emailRecSenha = null;
                            $_SESSION['emailRecSenha'] = null;
                        }
                    }
                }
                else
                {
                    echo("<script>alert(\"As senhas não correspondem!!\")</script>");
        ?>
                    <meta http-equiv="refresh" content="0 URL=SESSION_REC_SENHA.php">
        <?php
                }
            }
            else
            {
        ?>
                <h2>RECUPERAÇÃO DE SENHA</h2>

                <form action="SESSION_REC_SENHA.php?valor=enviado" method="post">
                    <label>Sua nova senha:</label><br>
                    <input type="password" name="nova_senha" id="nova_senha" maxlength="20" onchange="SenhaCorresp()"><br><br>

                    <label>Confirme sua nova senha:</label><br>
                    <input type="password" name="confirm_nova_senha" id="conf_nova_senha" maxlength="20" onchange="SenhaCorresp()"><br><br>

                    <input type="submit" name="botao" id="botao" value="CONFIRMAR NOVA SENHA" class="botao" disabled><br><br>

                    <label id="aviso"></label>
                </form>
        <?php
            }
        ?>
    </body>
</html>
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

            if(isset($_REQUEST['email']) && ($_REQUEST['email'] == 'recebido'))
            {
                $emailRecSenha = $_POST['email_rec_senha'];

                $pesquisa = $conexao -> prepare("SELECT * FROM tb_cliente
                                                 WHERE email_cliente = ?");

                $pesquisa -> bindParam(1, $emailRecSenha);

                if($pesquisa -> execute())
                {
                    if($pesquisa -> rowCount() > 0)
                    {
                        $data_envio = date('d/m/Y');
                        $hora_envio = date('H:i:s');

                        require_once('phpmailer/class.phpmailer.php');
                        include('user.php');

                        $de = 'dev_murilo.php@outlook.com';
                        $de_nome = 'Murilo Rodrigues de Figueiredo';
                        $para = $emailRecSenha;
                        $assunto = 'Recuperação de Senha';
                        $corpo = "<html> <body> <p><a href=\"http://localhost/projeto20_PWE2_02may23/SESSION_REC_SENHA.php\">CLIQUE AQUI</a> para redefinir a sua senha.</p> </body> </html>";

                        function smtpmailer($para, $de, $de_nome, $assunto, $corpo)
                        {
                            global $erro;
                            $mail = new PHPMailer();
                            $mail -> IsSMTP();
                            $mail -> SMTPDebug = 0;
                            $mail -> SMTPAuth = true;
                            $mail -> SMTPSecure = 'tls';
                            $mail -> Host = 'smtp.office365.com';
                            $mail -> Port = 587;
                            $mail -> Username = USER;
                            $mail -> Password = PASSWORD;
                            $mail -> CharSet = 'UTF-8';
                            $mail -> IsHTML($corpo);
                            $mail -> SetFrom($de, $de_nome);
                            $mail -> Subject = $assunto;
                            $mail -> Body = $corpo;
                            $mail -> AddAddress($para);

                            if($mail -> Send())
                            {
                                echo("<script>alert(\"Mensagem Enviada com Sucesso!! Verifique seu e-mail.\")</script>");
                                $_SESSION['emailRecSenha'] = $para;
        ?>
                                <meta http-equiv="refresh" content="0 URL=SESSION_LOGIN.php">
        <?php
                                return true;
                            }
                            else
                            {
                                $erro = "Mail Error: " . $mail -> ErrorInfo;

                                echo("<script>alert(\"A mensagem não pôde ser enviada. Verifique se digitou seu e-mail corretamente e tente novamente.\")</script>");
        ?>
                                <meta http-equiv="refresh" content="0 URL=SESSION_LOGIN.php">
        <?php
                                return false;
                            }
                        }

                        if(smtpmailer($emailRecSenha, USER, 'Murilo Rodrigues de Figueiredo', 'Recuperação de Senha', $corpo))
                        {
                            echo("Sucesso!!");
                        }

//                      if(!empty($erro)) { echo($erro); }
                    }
                    else
                    {
                        echo("<script>alert(\"O e-mail digitado não foi cadastrado.\")</script>");
        ?>
                        <meta http-equiv="refresh" content="0 URL=SESSION_LOGIN.php">
        <?php
                    }
                }
            }
            else
            {
        ?>
                <script>
                    var emailRecSenha = prompt("Por favor, digite o e-mail da sua conta para recuperação da senha.");
                </script>

                <div width="100%" height="100%" style="cursor: wait;">
                    <form action="SESSION_ESQ_SENHA.php?email=recebido" method="post">
                        <h2>Aguarde...</h2>

                        <input type="hidden" name="email_rec_senha" id="email_rec_senha">
                        <input type="submit" value="" id="submit" style="visibility: hidden">
                    </form>

                    <script>
                        var emailRec = document.getElementById("email_rec_senha");
                        emailRec.value = emailRecSenha;

                        var submit = document.getElementById("submit");
                        submit.click();
                    </script>
                </div>
        <?php
            }
        ?>
    </body>
</html>
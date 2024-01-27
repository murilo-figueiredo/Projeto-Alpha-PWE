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
                const senha = document.querySelector('#senha').value;
                const conf_senha = document.querySelector('#conf_senha').value;
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
            if(isset($_REQUEST['confirm']) && ($_REQUEST['confirm'] == 'enviado'))
            {
                try
                {
                    session_start();
                    include('conexao.php');

                    $nomeCadastro = $_POST['nome_cadastro'];
                    $enderecoCadastro = $_POST['endereco_cadastro'];
                    $emailCadastro = $_POST['email_cadastro'];
                    $senhaCadastro = $_POST['senha_cadastro'];

                    echo("<h3>INFORMAÇÕES RECEBIDAS: </h3>");
                    echo("<label>Nome: $nomeCadastro </label><br>");
                    echo("<label>Endereço: $enderecoCadastro </label><br>");
                    echo("<label>E-mail: $emailCadastro </label><br>");
                    echo("<label>Senha: $senhaCadastro </label><br><br>");

                    $cadastro = $conexao -> prepare("INSERT INTO tb_cliente VALUES
                                                        (DEFAULT, ?, ?, ?, ?)");

                    $cadastro -> bindParam(1, $nomeCadastro);
                    $cadastro -> bindParam(2, $enderecoCadastro);
                    $cadastro -> bindParam(3, $emailCadastro);
                    $cadastro -> bindParam(4, $senhaCadastro);

                    if($cadastro -> execute())
                    {
                        if($cadastro -> rowCount() > 0)
                        {
                            echo("<script>alert(\"Cadastro Realizado com Sucesso!!!\")</script>");

                            $_SESSION['nomeCliente'] = $nomeCadastro;
                            $_SESSION['enderecoCliente'] = $enderecoCadastro;

                            $nomeCadastro = null;
                            $enderecoCadastro = null;
                            $emailCadastro = null;
                            $senhaCadastro = null;
                        }
                        else
                        {
                            echo("<script>alert(\"Erro ao tentar efetuar o cadastro!! Tente novamente.\")</script>");
        ?>
                            <meta http-equiv="refresh" content="0 URL=SESSION_CADASTRO.php">
        <?php
                        }
                    }
                    else
                    {
                        throw new PDOException("ERRO: Não foi possível executar a declaração SQL.");
                    }
                }
                catch(PDOException $erro)
                {
                    echo("ERRO: " . $erro -> getMessage());
                }

                echo("<label>Agora, continue para o <a href='SESSION_LOGIN.php'>LOGIN</a>.</label>");
            }
            else
            {
        ?>
                <h2>CADASTRO</h2>

                <form action="SESSION_CADASTRO.php?confirm=enviado" method="post">
                    <label>Nome: </label><br>
                    <input type="text" name="nome_cadastro" maxlength="60"><br><br>

                    <label>Endereço: </label><br>
                    <input type="text" name="endereco_cadastro" maxlength="120"><br><br>

                    <label>Usuário (E-mail): </label><br>
                    <input type="email" name="email_cadastro" maxlength="35"><br><br>

                    <label>Senha: </label><br>
                    <input type="password" name="senha_cadastro" id="senha" maxlength="20" onchange="SenhaCorresp()"><br><br>

                    <label>Confirme sua Senha: </label><br>
                    <input type="password" name="conf_senha_cadastro" id="conf_senha" maxlength="20" onchange="SenhaCorresp()"><br><br>

                    <input type="submit" id="botao" value="CONFIRMAR DADOS" class="botao" disabled><br><br>

                    <label id="aviso"></label>
                </form>
        <?php
            }
        ?>
    </body>
</html>
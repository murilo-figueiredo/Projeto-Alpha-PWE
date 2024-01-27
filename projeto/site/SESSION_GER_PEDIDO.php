<!DOCTYPE html>
<html>
    <html lang="pt-br">
    <head>
        <title>PROJETO ALPHA - MB</title>
        <meta charset="utf-8mb4">

        <link rel="stylesheet" href="css/design.css">
        <script>
            function EnviarNovoEndereco()
            {
                const novoEndereco = document.querySelector('#novo_endereco').value;
                const botao = document.querySelector('#alterar_endereco');

                if(novoEndereco == "")
                {
                    botao.disabled = true;

                    return;
                }
                else
                {
                    botao.disabled = false;

                    return;
                }
            }

            function EnviarComentario()
            {
                const comentario = document.querySelector('#comentario').value;
                const botao = document.querySelector('#enviar_comentario');

                if(comentario == "")
                {
                    botao.disabled = true;

                    return;
                }
                else
                {
                    botao.disabled = false;

                    return;
                }
            }
        </script>
    </head>
    <body>
        <?php
            session_start();
            include('conexao.php');

            $idPedido = $_SESSION['idPedidoPronto'];
            $nomeCliente = $_SESSION['nomeClienteLogado'];
            $enderecoCliente = $_SESSION['enderecoClienteLogado'];

            if(isset($_REQUEST['valor']) && ($_REQUEST['valor'] == 'enviado'))
            {
                $botao = $_POST['botao'];

                if($botao == 'ALTERAR ENDEREÇO')
                {
                    $novoEndereco = $_POST['novo_endereco'];

                    try
                    {
                        $alterar = $conexao -> prepare("UPDATE tb_cliente SET end_cliente = ?
                                                            WHERE nome_cliente = ? AND end_cliente = ?");

                        $alterar -> bindParam(1, $novoEndereco);
                        $alterar -> bindParam(2, $nomeCliente);
                        $alterar -> bindParam(3, $enderecoCliente);

                        if($alterar -> execute())
                        {
                            $localizar = $conexao -> prepare("SELECT * FROM tb_cliente
                                                                WHERE end_cliente = ?");

                            $localizar -> bindParam(1, $novoEndereco);

                            if($localizar -> execute())
                            {
                                if($localizar -> rowCount() > 0)
                                {
                                    while($linha = $localizar -> fetch(PDO::FETCH_OBJ))
                                    {
                                        $_SESSION['enderecoClienteLogado'] = $linha -> end_cliente;
                                    }

                                    echo("<script>alert(\"Endereço Alterado com Sucesso!!\");</script>");
        ?>
                                    <meta http-equiv="refresh" content="0 URL=SESSION_GER_PEDIDO.php">
        <?php
                                }
                            }
                        }
                    }
                    catch(PDOException $erro)
                    {
                        echo("ERRO: " . $erro -> getMessage());
                    }
                }
                if($botao == 'ENVIAR COMENTÁRIO')
                {
                    $comentarioPedido = $_POST['coment_pedido'];

                    try
                    {
                        $comentario = $conexao -> prepare("UPDATE tb_pedido SET comentario_pedido = ?
                                                            WHERE id_pedido = ?");

                        $comentario -> bindParam(1, $comentarioPedido);
                        $comentario -> bindParam(2, $idPedido);

                        if($comentario -> execute())
                        {
                            echo("<script>alert(\"Comentário Adicionado com Sucesso!!\");</script>");
        ?>
                            <meta http-equiv="refresh" content="0 URL=SESSION_GER_PEDIDO.php">
        <?php
                        }
                    }
                    catch(PDOException $erro)
                    {
                        echo("ERRO: " . $erro -> getMessage());
                    }
                }
                if($botao == 'REALIZAR OUTRO PEDIDO')
                {
                    $_SESSION['idProd'] = null;
                    $_SESSION['nomeProd'] = null;
                    $_SESSION['valorProd'] = null;
                    $_SESSION['descProd'] = null;
                    $_SESSION['idClienteLogado'] = null;
                    $_SESSION['nomeClienteLogado'] = null;
                    $_SESSION['enderecoClienteLogado'] = null;
                    $_SESSION['emailClienteLogado'] = null;
                    $_SESSION['senhaClienteLogado'] = null;
                    $_SESSION['nomeCliente'] = null;
                    $_SESSION['enderecoCliente'] = null;
                    $_SESSION['emailRecSenha'] = null;
                    $_SESSION['valorParcela'] = null;
                    $_SESSION['formaPgto'] = null;
                    $_SESSION['condicaoPgto'] = null;
                    $_SESSION['idPedidoPronto'] = null;

                    header('location:SESSION_VITRINE.php');
                }
            }
            else
            {
        ?>
                <h2>GERENCIAMENTO DE PEDIDO</h2>

                <form action="SESSION_GER_PEDIDO.php?valor=enviado" method="post">
        <?php
                    echo("<label>Você está logado como $nomeCliente.</label><br>");
                    echo("<label>Seu pedido será entregue em $enderecoCliente.</label><br><br>");
        ?>
                    <label>Caso queira, altere o endereço de entrega do seu pedido:</label><br>
                    <input type="text" name="novo_endereco" id="novo_endereco" maxlength="120" onchange="EnviarNovoEndereco()"><br><br>

                    <input type="submit" name="botao" id="alterar_endereco" value="ALTERAR ENDEREÇO" class="botao" disabled><br><br>
        <?php
                    $gerenciamento = $conexao -> prepare("SELECT * FROM tb_pedido
                                                            WHERE id_pedido = ?");

                    $gerenciamento -> bindParam(1, $idPedido);

                    $gerenciamento -> execute();
        ?>
                    <h4>TABELA DO SEU PEDIDO</h4>

                    <div class="tabela">
                        <table border="1">
                            <tr>
                                <th>Id do Pedido</th>
                                <th>Data e Hora do Pagamento</th>
                                <th>Valor (R$)</th>
                                <th>Status</th>
                                <th>Comentário do Cliente</th>
                            </tr>
        <?php
                            while($linha = $gerenciamento -> fetch(PDO::FETCH_OBJ))
                            {
                                $idGerPedido = $linha -> id_pedido;
                                $dtaGerPedido = $linha -> dta_pedido;
                                $valorGerPedido = $linha -> valor_pedido;
                                $sttGerPedido = $linha -> status_pedido;
                                $comentGerPedido = $linha -> comentario_pedido;
                            
                                echo("<tr>");
                                    echo("<td>$idGerPedido</td>");
                                    echo("<td>$dtaGerPedido</td>");
                                    echo("<td>$valorGerPedido</td>");
                                    echo("<td>$sttGerPedido</td>");
                                    echo("<td>$comentGerPedido</td>");
                                echo("</tr>");
                            }
        ?>
                        </table>
                    </div><br><br>

                    <label>Adicione um comentário ao seu pedido (opcional):</label><br>
                    <textarea name="coment_pedido" id="comentario" rows="8" cols="40" onchange="EnviarComentario()"></textarea><br><br>

                    <input type="submit" name="botao" id="enviar_comentario" value="ENVIAR COMENTÁRIO" style="cursor: pointer;" disabled><br><br><br><br>

                    <label style="font-weight: bold;">Clique aqui para voltar do início, esquecendo todos os valores digitados:</label><br>
                    <input type="submit" name="botao" value="REALIZAR OUTRO PEDIDO" style="cursor: pointer; font-weight: bold;">
                </form>
        <?php
            }
        ?>
    </body>
</html>
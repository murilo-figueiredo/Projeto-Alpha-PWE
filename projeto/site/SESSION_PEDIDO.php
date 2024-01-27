<!DOCTYPE html>
<html lang="pt-br">
<html>
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

                if($botao = 'REGISTRAR PEDIDO')
                {
                    try
                    {
                        $valorPed = $_SESSION['valorProd'];
                        $idProduto = $_SESSION['idProd'];
                        $idCliente = $_SESSION['idClienteLogado'];

                        $pedido = $conexao -> prepare("INSERT INTO tb_pedido VALUES
                                                        (DEFAULT, NOW(), ?, 'Encomendado', null, ?, ?)");

                        $pedido -> bindParam(1, $valorPed);
                        $pedido -> bindParam(2, $idProduto);
                        $pedido -> bindParam(3, $idCliente);

                        if($pedido -> execute())
                        {
                            if($pedido -> rowCount() > 0)
                            {
                                $valorPed = null;
                                $idProduto = null;
                                $idCliente = null;
                                
                                $localizar = $conexao -> prepare("SELECT * FROM tb_pedido
                                                                    ORDER BY id_pedido DESC LIMIT 1");

                                if($localizar -> execute())
                                {
                                    while($linha = $localizar -> fetch(PDO::FETCH_OBJ))
                                    {
                                        $_SESSION['idPedidoPronto'] = $linha -> id_pedido;

                                        echo("<script>alert(\"Pedido Realizado e Encomendado com Sucesso!!\");</script>");
        ?>
                                        <meta http-equiv="refresh" content="0 URL=SESSION_GER_PEDIDO.php">
        <?php
                                    }
                                }
                            }
                            else
                            {
                                echo("<script>alert(\"Erro ao tentar realizar o pedido. Tente novamente.\");</script>");
        ?>
                                <meta http-equiv="refresh" content="0 URL=SESSION_PEDIDO.php">
        <?php
                            }
                        }
                        else
                        {
                            throw new PDOException("ERRO: Não foi possível registrar o seu pedido.");
                        }
                    }
                    catch(PDOException $erro)
                    {
                        echo("ERRO: " . $erro -> getMessage());
                    }
                }
            }
            else
            {
                echo("<h2>INFORMAÇÕES DO PEDIDO</h2>");
                echo("<label>Nome: " . $_SESSION['nomeClienteLogado'] . "</label><br>");
                echo("<label>Endereço: " . $_SESSION['enderecoClienteLogado'] . "</label><br>");
                echo("<label>Forma de Pagamento: " . $_SESSION['formaPgto'] . "</label><br>");
                echo("<label>Condição de Pagamento: " . $_SESSION['condicaoPgto'] . "</label><br>");
                echo("<label>Valor da(s) Parcela(s): R$" . round($_SESSION['valorParcela'], 2) . "</label><br>");
                echo("<label>Valor Total: R$" . $_SESSION['valorProd'] . "</label><br><br>");
        ?>
                <form action="SESSION_PEDIDO.php?valor=enviado" method="post">
                    <input type="submit" name="botao" value="REGISTRAR PEDIDO" class="botao">
                </form>
        <?php
            }
        ?>
    </body>
</html>
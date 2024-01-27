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

                if($botao == 'CONFIRMAR PRODUTO')
                {
                    header('location:SESSION_LOGIN.php');
                }
            }
            else
            {
                $idProd = $_SESSION['idProd'];

                try
                {
                    $produto = $conexao -> prepare("SELECT * FROM tb_produto
                                                    WHERE id_prod = ?");
                    
                    $produto -> bindParam(1, $idProd);

                    if($produto -> execute())
                    {
                        if($produto -> rowCount() > 0)
                        {
                            while($linha = $produto -> fetch(PDO::FETCH_OBJ))
                            {
                                $nomeProduto = $linha -> nome_prod;
                                $_SESSION['nomeProd'] = $nomeProduto;

                                $valorProduto = $linha -> valor_prod;
                                $_SESSION['valorProd'] = $valorProduto;

                                $descProduto = $linha -> desc_prod;
                                $_SESSION['descProd'] = $descProduto;
                            }
                        }
                    }
                }
                catch(PDOException $erro)
                {
                    echo("Erro: " . $erro -> getMessage());
                }

                echo("<h2>PRODUTO</h2>");
        ?>
                <form action="SESSION_PRODUTO.php?valor=enviado" method="post">
        <?php
                    echo("<label>Foto do Produto:</label><br><br>");
                    if($_SESSION['idProd'] == 1) { echo("<img src=\"img/canetaCara.jpg\" width=\"25%\">"); }
                    else { echo("<img src=\"img/canetaBarata.jpg\" width=\"25%\">"); }
                    echo("<br><br>");

                    echo("<label>Nome do Produto: $nomeProduto </label><br>");
                    echo("<label>Valor: R$$valorProduto </label><br>");
                    echo("<label>Descrição: $descProduto </label><br><br>");
        ?>
                    <input type="submit" name="botao" value="CONFIRMAR PRODUTO" class="botao">
                </form>
        <?php
            }
        ?>
    </body>
</html>
<!DOCTYPE html>
<html>
    <html lang="pt-br">
    <head>
        <title>PROJETO ALPHA - MB</title>
        <meta charset="utf-8mb4">

        <link rel="stylesheet" href="css/design.css">
        <script>
            function EscolherProduto(produto)
            {
                const canetaCara = document.querySelector('#caneta_cara');
                const canetaBarata = document.querySelector('#caneta_barata');

                if(produto == 'canetaCara')
                {
                    canetaCara.click();
    
                    return;
                }
                else if(produto == 'canetaBarata')
                {
                    canetaBarata.click();
    
                    return;
                }
            }
        </script>
    </head>
    <body>
        <?php
            session_start();

            if(isset($_REQUEST['valor']) && ($_REQUEST['valor'] == 'enviado'))
            {
                $botao = $_POST['botao'];

                if($botao != '')
                {
                    if($botao == 'caneta cara') { $_SESSION['idProd'] = 1; }
                    if($botao == 'caneta barata') { $_SESSION['idProd'] = 2; }

                    header('location:SESSION_PRODUTO.php');
                }
            }
            else
            {
        ?>
                <h2>VITRINE</h2>

                <form action="SESSION_VITRINE.php?valor=enviado" method="post">
                    <label>Escolha um dos produtos a seguir para comprar:</label><br><br>
                    <img src="img/canetaCara.jpg" width="25%" onclick="EscolherProduto('canetaCara')" class="botao">
                    <img src="img/canetaBarata.jpg" width="25%" onclick="EscolherProduto('canetaBarata')" class="botao"><br><br>

                    <label>(Clique no produto que deseja comprar)</label><br>

                    <input type="submit" name="botao" id="caneta_cara" value="caneta cara" style="visibility: hidden;">
                    <input type="submit" name="botao" id="caneta_barata" value="caneta barata" style="visibility: hidden;">
                </form>
        <?php
            }
        ?>
    </body>
</html>
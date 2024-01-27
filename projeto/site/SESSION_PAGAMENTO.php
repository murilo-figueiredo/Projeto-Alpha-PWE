<!DOCTYPE html>
<html>
    <html lang="pt-br">
    <head>
        <title>PROJETO ALPHA - MB</title>
        <meta charset="utf-8mb4">

        <link rel="stylesheet" href="css/design.css">
        <script>
            function HabilitarParcela()
            {
                const formaBoleto = document.querySelector('#forma_boleto');
                const formaCredito = document.querySelector('#forma_credito');
                const formaDebito = document.querySelector('#forma_debito');
                const formaPix = document.querySelector('#forma_pix');
                const condicao = document.querySelector('#condicao')

                const parcela2 = document.querySelector('#parcela2x');
                const parcela3 = document.querySelector('#parcela3x');
                const parcela4 = document.querySelector('#parcela4x');
                const parcela5 = document.querySelector('#parcela5x');
                const parcela6 = document.querySelector('#parcela6x');
                const parcela7 = document.querySelector('#parcela7x');
                const parcela8 = document.querySelector('#parcela8x');
                const parcela9 = document.querySelector('#parcela9x');
                const parcela10 = document.querySelector('#parcela10x');
                const parcela11 = document.querySelector('#parcela11x');
                const parcela12 = document.querySelector('#parcela12x');

                if(formaBoleto.checked)
                {
                    parcela2.disabled = true;
                    parcela3.disabled = true;
                    parcela4.disabled = true;
                    parcela5.disabled = true;
                    parcela6.disabled = true;
                    parcela7.disabled = true;
                    parcela8.disabled = true;
                    parcela9.disabled = true;
                    parcela10.disabled = true;
                    parcela11.disabled = true;
                    parcela12.disabled = true;

                    condicao.value = 'À Vista';

                    return;
                }
                else if(formaCredito.checked || formaDebito.checked || formaPix.checked)
                {
                    parcela2.disabled = false;
                    parcela3.disabled = false;
                    parcela4.disabled = false;
                    parcela5.disabled = false;
                    parcela6.disabled = false;
                    parcela7.disabled = false;
                    parcela8.disabled = false;
                    parcela9.disabled = false;
                    parcela10.disabled = false;
                    parcela11.disabled = false;
                    parcela12.disabled = false;

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
                $valor = $_SESSION['valorProd'];
                $condicao = $_POST['condicao_pgto'];
                $forma = $_POST['forma_pgto'];
                $botao = $_POST['botao'];

                if($botao == 'CONFIRMAR PAGAMENTO')
                {
                    if($condicao == 'À Vista') { $_SESSION['valorParcela'] = $valor; }
                    elseif($condicao == '2x sem Juros') { $_SESSION['valorParcela'] = $valor / 2; }
                    elseif($condicao == '3x sem Juros') { $_SESSION['valorParcela'] = $valor / 3; }
                    elseif($condicao == '4x sem Juros') { $_SESSION['valorParcela'] = $valor / 4; }
                    elseif($condicao == '5x sem Juros') { $_SESSION['valorParcela'] = $valor / 5; }
                    elseif($condicao == '6x sem Juros') { $_SESSION['valorParcela'] = $valor / 6; }
                    elseif($condicao == '7x sem Juros') { $_SESSION['valorParcela'] = $valor / 7; }
                    elseif($condicao == '8x sem Juros') { $_SESSION['valorParcela'] = $valor / 8; }
                    elseif($condicao == '9x sem Juros') { $_SESSION['valorParcela'] = $valor / 9; }
                    elseif($condicao == '10x sem Juros') { $_SESSION['valorParcela'] = $valor / 10; }
                    elseif($condicao == '11x sem Juros') { $_SESSION['valorParcela'] = $valor / 11; }
                    elseif($condicao == '12x sem Juros') { $_SESSION['valorParcela'] = $valor / 12; }

                    $_SESSION['formaPgto'] = $forma;
                    $_SESSION['condicaoPgto'] = $condicao;

                    echo("<h3>INFORMAÇÕES DO PAGAMENTO</h3>");
                    echo("<label>Produto: " . $_SESSION['nomeProd'] . "</label><br>");
                    echo("<label>Valor: R$" . $_SESSION['valorProd'] . "</label><br>");
                    echo("<label>Forma de Pagamento: " . $_SESSION['formaPgto'] . "</label><br>");
                    echo("<label>Condição de Pagamento: " . $_SESSION['condicaoPgto'] . "</label><br>");
                    echo("<label>Valor da(s) Parcela(s): R$" . round($_SESSION['valorParcela'], 2) . "</label><br><br>");
                    
                    echo("<label>Agora, continue para o <a href='SESSION_PEDIDO.php'>PEDIDO</a>.</label>");
                }
            }
            else
            {
        ?>
                <h2>PAGAMENTO</h2>
        <?php
                echo("<label>Olá " . $_SESSION['nomeClienteLogado'] . "!! Por favor, escolha a forma e a condição do seu pagamento.</label><br><br>");
        ?>
                <form action="SESSION_PAGAMENTO.php?valor=enviado" method="post">
                    <label>Forma de Pagamento: </label><br>
                    <input type="radio" name="forma_pgto" id="forma_boleto" value="Boleto" onchange="HabilitarParcela()"><label>Boleto</label><br>
                    <input type="radio" name="forma_pgto" id="forma_credito" value="Crédito" onchange="HabilitarParcela()"><label>Crédito</label><br>
                    <input type="radio" name="forma_pgto" id="forma_debito" value="Débito" onchange="HabilitarParcela()"><label>Débito</label><br>
                    <input type="radio" name="forma_pgto" id="forma_pix" value="PIX" onchange="HabilitarParcela()"><label>PIX</label><br><br>

                    <label for="condicao">Condição de Pagamento: </label><br>
                    <select name="condicao_pgto" id="condicao">
                        <option default value="À Vista">À Vista</option>
                        <option value="2x sem Juros" id="parcela2x">2x sem Juros</option>
                        <option value="3x sem Juros" id="parcela3x">3x sem Juros</option>
                        <option value="4x sem Juros" id="parcela4x">4x sem Juros</option>
                        <option value="5x sem Juros" id="parcela5x">5x sem Juros</option>
                        <option value="6x sem Juros" id="parcela6x">6x sem Juros</option>
                        <option value="7x sem Juros" id="parcela7x">7x sem Juros</option>
                        <option value="8x sem Juros" id="parcela8x">8x sem Juros</option>
                        <option value="9x sem Juros" id="parcela9x">9x sem Juros</option>
                        <option value="10x sem Juros" id="parcela10x">10x sem Juros</option>
                        <option value="11x sem Juros" id="parcela11x">11x sem Juros</option>
                        <option value="12x sem Juros" id="parcela12x">12x sem Juros</option>
                    </select><br>
                    <label>Obs.: Parcelamentos disponíveis apenas em pagamentos com cartão ou PIX.</label><br><br>

                    <input type="submit" name="botao" value="CONFIRMAR PAGAMENTO" class="botao">
                </form>
        <?php
            }
        ?>
    </body>
</html>
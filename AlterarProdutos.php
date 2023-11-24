<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='estilo.css'>
            <title>Produtos</title>
        </head>
        <body><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        if(isset($_GET['id_produto'])){
          $Arquivo="SalvarDadosProdutos.php";
          $query = "select * from tbl_produto where id_produto=:idProduto";
          $select = $conn->prepare($query);
          $select->execute(['idProduto' => $_GET['id_produto']]);
          $linha=$select->fetch();
          $idProduto = $linha['id_produto'];
          $nomeProduto = $linha['nome'];
          $descProduto = $linha['descricao'];
          $precoProduto = $linha['preco'];
          $qtdeProduto = $linha['qtde_estoque'];
          $codigoVisualProduto = $linha['codigo_visual'];
          $custoProduto = $linha['custo'];
          $lucroProduto = $linha['margem_lucro'];
          $icmsProduto = $linha['icms'];
          $imagemProduto = $linha['imagem'];
          $excluidoProduto = $linha['excluido'];
          if($excluidoProduto==TRUE){
            $excluidoProduto=1;
          }
          else
            $excluidoProduto=0;
          $submit="Alterar";
        }else{
          $Arquivo="InserirProdutos.php";
          $idProduto="";
          $nomeProduto = "";
          $descProduto = "";
          $precoProduto = "";
          $qtdeProduto = "";
          $codigoVisualProduto = "";
          $custoProduto = "";
          $lucroProduto = "";
          $icmsProduto = "";
          $imagemProduto = "";
          $excluidoProduto=0;
          $submit="Inserir";
        }
        echo "<form enctype='multipart/form-data' method='post' action='$Arquivo'>
        <div class='main-login'>
            <div class='right-login'>
              <div class= card-login>";
              if(isset($_GET['id_produto'])){
                  echo "<div class='textfield'>
                    <label>Produto: $idProduto</label>
                    <label>$excluidoProduto</label>
                  </div>";}
                  echo "<input type='hidden' name='id_produto' value='$idProduto'>
                  <div class='textfield'>
                      <label>Nome do produto</label>
                      <input type='text' name='Nome_produto' placeholder='Nome do produto' value='$nomeProduto' required>
                  </div>
                  <div class='textfield'>
                      <label>Descrição</label>
                    <input type='text' name='descricao_produto' placeholder='descricao' value='$descProduto' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Preço do produto</label>
                      <input type='number' name='preco_produto' value='$precoProduto' step='0.01' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Quantidade no estoque</label>
                    <input type='number' name='qtde_produto' value='$qtdeProduto' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Código visual</label>
                    <input type='text' name='codVisual_produto' placeholder='Código visual' value='$codigoVisualProduto' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Custo de produção</label>
                    <input type='number' name='custo_produto' value='$custoProduto' step='0.01' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Margem de lucro</label>
                    <input type='number' name='lucro_produto' value='$lucroProduto' step='0.01' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>ICMS</label>
                    <input type='number' name='icms_produto' value='$icmsProduto' step='0.01' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Imagem do produto</label>
                      <input type='file' name='imagem_produto'> <br>
                      <input type='hidden' name='excluido_produto' value='$excluidoProduto'>
                  </div>
                  <input type='submit' value='$submit' class='btn-login'>
              </div>
          </div>
          </div>
          </form>
        </body>
        </html>";
?>
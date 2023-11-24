<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
    if(empty($_FILES['imagem_produto']['name'])){
    $linha = [ 'id' => $_POST['id_produto'],
    'nome' => $_POST['Nome_produto'],
    'descricao' => $_POST['descricao_produto'],
    'preco' => $_POST['preco_produto'],
    'qtde' => $_POST['qtde_produto'],
    'codVisual' => $_POST['codVisual_produto'],
    'custo' => $_POST['custo_produto'],
    'lucro' => $_POST['lucro_produto'],
    'icms' => $_POST['icms_produto'],
    'excluido' => $_POST['excluido_produto']];}
    else{
    $linha = [ 'id' => $_POST['id_produto'],
    'nome' => $_POST['Nome_produto'],
    'descricao' => $_POST['descricao_produto'],
    'preco' => $_POST['preco_produto'],
    'qtde' => $_POST['qtde_produto'],
    'codVisual' => $_POST['codVisual_produto'],
    'custo' => $_POST['custo_produto'],
    'lucro' => $_POST['lucro_produto'],
    'icms' => $_POST['icms_produto'],
    'imagem' => $_FILES['imagem_produto']['name'],
    'excluido' => $_POST['excluido_produto']];
    }
   if(empty($_FILES['imagem_produto']['name'])){
    $sql ="UPDATE tbl_produto SET nome=:nome, descricao=:descricao, preco=:preco, qtde_estoque=:qtde, 
    codigo_visual=:codVisual, custo=:custo, margem_lucro=:lucro, icms=:icms, excluido=:excluido WHERE id_produto=:id";
   }else{
    $novonome="imagens/".$_FILES['imagem_produto']['name'];
    move_uploaded_file($_FILES['imagem_produto']['tmp_name'],$novonome);
    $sql ="UPDATE tbl_produto SET nome=:nome, descricao=:descricao, preco=:preco, qtde_estoque=:qtde, 
    codigo_visual=:codVisual, custo=:custo, margem_lucro=:lucro, icms=:icms, imagem=:imagem, excluido=:excluido
    WHERE id_produto=:id";
   }
    $update = $conn->prepare($sql);
    $update->execute($linha);
    unset($conn);
    unset($update);
    Header('Location: Produtos.php');
?>
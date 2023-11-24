<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
    $linha = ['nome' => $_POST['Nome_produto'],
    'descricao' => $_POST['descricao_produto'],
    'preco' => $_POST['preco_produto'],
    'qtde' => $_POST['qtde_produto'],
    'codVisual' => $_POST['codVisual_produto'],
    'custo' => $_POST['custo_produto'],
    'lucro' => $_POST['lucro_produto'],
    'icms' => $_POST['icms_produto'],
    'imagem' => $_FILES['imagem_produto']['name'],
    'excluido' => $_POST['excluido']];
    $arquivo = $_FILES['imagem_produto']['name'];
    $sql="INSERT INTO tbl_produto (nome,descricao,preco,qtde_estoque,codigo_visual,custo,margem_lucro,icms,imagem,excluido)
    VALUES (:nome,:descricao,:preco,:qtde,:codVisual,:custo,:lucro,:icms,:imagem,:excluido)";
    $novonome="imagens/".$_FILES['imagem_produto']['name'];
    move_uploaded_file($_FILES['imagem_produto']['tmp_name'],$novonome);
    $insert = $conn->prepare($sql);
    $insert->execute($linha);
    unset($conn);
    unset($insert);
    Header('Location:Produtos.php');
?>
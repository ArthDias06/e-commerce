<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
    $id=$_GET['id_produto'];
    $query="SELECT excluido FROM tbl_produto WHERE id_produto=$id";
    $select=$conn->prepare($query);
    $select->execute();
    $excluido=$select->fetchColumn();
    if($excluido==true){
        $sql="UPDATE tbl_produto SET excluido=false WHERE id_produto=:id";
    }
    else{
        $data_exclusao=date('Y-m-d H:i:s');
        $sql="UPDATE tbl_produto SET excluido=true,data_exclusao=:data_exclusao WHERE id_produto=:id";
    }
    $update=$conn->prepare($sql);
    if($excluido!=true)
        $update->bindParam(':data_exclusao',$data_exclusao,PDO::PARAM_STR);
    $update->bindParam(':id',$id,PDO::PARAM_INT);
    $update->execute();
    unset($update);
    unset($conn);
    Header('Location:Produtos.php');
?>
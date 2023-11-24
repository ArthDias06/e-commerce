<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
    $id=$_GET['id_usuario'];
    $sql="DELETE FROM tbl_usuario WHERE id_usuario=:id";
    $update=$conn->prepare($sql);
    $update->bindParam(':id',$id,PDO::PARAM_INT);
    $update->execute();
    unset($update);
    unset($conn);
    Header('Location:Usuario.php');
?>
<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
    $linha = [ 'id' => $_POST['id_usuario'],
    'nome' => $_POST['Nome_usuario'],
    'email' => $_POST['email_usuario'],
    'senha' => $_POST['senha_usuario'],
    'tel' => $_POST['tel_usuario'],
    'cpf' => $_POST['cpf_usuario'],
    'adm' => $_POST['adm_usuario']];
    if($linha['adm']=="Sim" || $linha=="sim")
        $linha['adm']=1;
    else
        $linha['adm']=0;
    $sql ="UPDATE tbl_usuario SET nome=:nome, email=:email, senha=:senha, telefone=:tel, 
    cpf=:cpf, adm=:adm WHERE id_usuario=:id";
    $update = $conn->prepare($sql);
    $update->execute($linha);
    unset($conn);
    unset($update);
    Header('Location: Usuario.php');
?>
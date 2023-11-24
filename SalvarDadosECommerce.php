<?php 
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("util.php");

   $conn = conecta();
	$user = $_POST['nome'];
   $linha = [ 'nome'          => $_POST['nome'],
              'email'            => $_POST['email'],
              'senha'            => $_POST['senha'], 
              'telefone'         => $_POST['telefone'], 
              'cpf'              => $_POST['cpf']   ];
   $insert = $conn->prepare('INSERT INTO tbl_usuario (id_usuario, nome, email, senha, telefone, cpf, adm) VALUES (DEFAULT, :nome, :email, :senha, :telefone, :cpf, false)');
   $insert->execute($linha);
//    print_r($update->errorInfo());
  header('Location: Login.php');     

?>
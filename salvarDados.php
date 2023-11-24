<?php 
   // mostra erros do php
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("util.php");

   // pra nao ter que em todo arquivo colocar a mesma linha de conexao
   // manda vazio e no util.php deixa fixa    
   $Varconn = conecta();

   $linha = [ 'Usuario'          => $_POST['Usuario'],
              'Email'            => $_POST['Email'],
              'Senha'            => $_POST['Senha'], 
              'ConfirmarSenha'   => $_POST['ConfirmarSenha'],
              'Telefone'         => $_POST['Telefone'], 
              'CPF'              => $_POST['CPF']   ];

   $sql = "update aluno set 
             Usuario        = :Usuario, 
             Email          = :Email, 
             Senha          = :Senha, 
             ConfirmarSenha = :ConfirmarSenha,   
             Telefone       = :Telefone, 
             CPF            = :CPF   
           where id = :id"; 
   
   // prepara!
   $update = $conn->prepare($sql); 
   $update->execute($linha);

   // volta pra home 
   header('Location: Home.php');     

?>

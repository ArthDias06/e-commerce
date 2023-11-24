<?php
  // mostra erros do php
  ini_set('display_errors', 1); 
  error_reporting(E_ALL);  

  include("util.php");
  
  // inicia a sessao
  session_start();   
  $conn = conecta();


  $eh_admin = false;

if(isset($_POST['Admin']) && $_POST['Admin'] == true) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
     
    // Verifique a conexão
    try {
      $conn = conecta();
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }

    // Consulta SQL para verificar se o email e a senha correspondem a um administrador
    $sql = "SELECT * FROM tbl_usuario WHERE email = '$email' AND senha = '$senha' AND adm = true";

    $result = $conn->prepare($sql);
    $result->execute();
    $nomeUsuario=$result->fetch();
 	echo "teste:";
     echo $result->rowCount();
    if ($result->rowCount() > 0) {
        // O email e a senha correspondem a um administrador
        $eh_admin = true;
      } else {
        // O email e a senha não correspondem a um administrador
        $_SESSION['error'] = "O usuário não é um administrador.";
        header('Location: Login.php');
		exit;	
    }

} else {
  $email = $_POST['email'];
    $senha = $_POST['senha'];

      //Aqui voce verifica em seu banco de dados, se o login ja foi cadastrado.
  $sql = "SELECT * FROM tbl_usuario WHERE email = :email AND senha = :senha";
  $pegaEmail = $conn->prepare($sql);
  $pegaEmail->bindParam(':email', $email);
  $pegaEmail->bindParam(':senha', $senha);
  $pegaEmail->execute();
  $nomeUsuario=$pegaEmail->fetch();

  if ($pegaEmail->rowCount() == 0){
    $_SESSION['error'] = "E-mail ou senha incorretos!";
    header('Location: Login.php');
	exit;
  }
}
   
   DefineCookie('loginCookie', $email, 60); 
   $_SESSION['sessaoConectado'] = funcaoLogin($email,$senha,$eh_admin); 
   $_SESSION['sAdm'] = $nomeUsuario['adm'];
   $_SESSION['nome']=$nomeUsuario['nome'];
   header('Location: index.php');
?>
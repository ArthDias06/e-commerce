
<?php
    ini_set("display_errors",1);
    error_reporting(E_ALL);

    include('util.php');
    $conn = conecta();
    

    if(isset($_POST['email'])){
        $email = $_POST['email'];

        $sql = "SELECT * FROM tbl_usuario WHERE email = '$email';";
        $linha = $conn->prepare($sql);
        $execucao = $linha->execute();
        $row=$linha->rowCount();

        if($row>0){
            $usuario = $conn->query("SELECT nome FROM tbl_usuario WHERE email = '$email';")->fetch();

            $senhaNova = GeraSenha();
            $sql = "UPDATE tbl_usuario set senha = '$senhaNova' WHERE email = '$email';";
        
            ExecutaSQL($conn, $sql);
    
            EnviaEmail($email, "Nova senha", "<p>Ola, ".$usuario['nome']."!<br>Aqui esta a sua nova senha que geramos: ".$senhaNova.".<br>Atensiosamente, WristWear LTDA.</p>");
            }else{
               $_SESSION['error'] = "Email inexistente nos registros!";
               if(isset($_SESSION['error'])) {
                echo "<script>alert('".$_SESSION['error']."')</script>";  
                unset($_SESSION['error']);
              }                   
	  }

    }

    echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='estilo.css' >
    <title>Recuperar senha</title>
</head>
    <body>
   <form  method='post' action='esqueci.php'>
          <div class='main-login'>
          <div class='left-login'>
          <img src='./imagens/logo.png' class='left-login-image' alt='Logo'>
          </div>
          <div class='right-login'>
              <div class= card-login  >
                  
                  <div class='textfield'>
                  <label>Insira um email para envio da nova senha: </label><br>
           	 <input type='text' name='email' placeholder='email'>
                  <button class= 'btn-login'>Enviar</button>
              </div>
          </div>
      </div>   
       </body>
</html>";
?>


<?php
  // mostra erros do php
  ini_set ( 'display_errors' , 1); 
  error_reporting (E_ALL);   
  session_start();   

  include("util.php");
  
  // se nao estiver conectado vai pedir o login
  if (isset($_SESSION['sessaoConectado'])) {
      $sessaoConectado = $_SESSION['sessaoConectado'];
  } else { 
    $sessaoConectado = false; 
  }
  
  // se sessao nao conectada ...
  if (!$sessaoConectado) { 
     // recupera o valor do cookie com o usuario    
     if (isset($_COOKIE['loginCookie'])) {
      $loginCookie = $_COOKIE['loginCookie']; 
   } else {
      $loginCookie = '';
   }
  }

  if(isset($_SESSION['error'])) {
    echo "<script>alert('".$_SESSION['error']."')</script>";    
    unset($_SESSION['error']);
  }
  

     echo "
      <html>
      <header></header>
      <head>
         <meta charset='UTF-8'>
         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
         <link rel='stylesheet' href='estilo.css'>
        <title>Login</title>
        </head>
      <body>
          <form name='formlogin' method='post' action='Login_Sessao.php'>
          <div class='main-login'>
          <div class='left-login'>
              <h1>Faça login<br>Para continuar</h1>
              <img src='./imagens/logo.png' class='left-login-image' alt='Logo'>
          </div>
          <div class='right-login'>
              <div class= card-login  >
                  <h1>LOGIN</h1>
                  <div class='textfield'>
                      <label for='usuario'>Email</label>
                      <input type='email' name='email' placeholder='email' required>
                  </div>
                  <div class='textfield'>
                      <label for='senha'>Senha</label>
                      <input type='password' name='senha' placeholder=  'senha' required>
                  <div class='textfield'>
                      <right> <a href='esqueci.php' class='link'>Esqueci Minha Senha</a> </right> 
                  </div>
                  <div class='textfield'>
                      <right><a href='Cadastro.php' class='link'>Cadastrar-se</a> </right>    
                  </div>
                  <button class= 'btn-login'>Login</button>
              </div>
          </div>
      </div>
    </form>
   </body>
  </html>";
?>
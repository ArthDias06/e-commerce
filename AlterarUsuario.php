<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    $conn=conecta();
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='estilo.css'>
            <title>Usuários</title>
        </head>
        <body><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
          $Arquivo="SalvarDadosUsuario.php";
          $query = "select * from tbl_usuario where id_usuario=:idUsuario";
          $select = $conn->prepare($query);
          $select->execute(['idUsuario' => $_GET['id_usuario']]);
          $linha=$select->fetch();
          $idUser = $linha['id_usuario'];
          $nomeUser = $linha['nome'];
          $emailUser = $linha['email'];
          $senhaUser = $linha['senha'];
          $telUser = $linha['telefone'];
          $cpfUser = $linha['cpf'];
          if($linha['adm']==TRUE)
            $admUser="Sim";
          else
            $admUser="Não";
        echo "<form enctype='multipart/form-data' method='post' action='$Arquivo'>
        <div class='main-login'>
            <div class='right-login'>
              <div class= card-login>
              <div class='textfield'>
                    <label>Usuário: $idUser</label>
                  </div>
                  <input type='hidden' name='id_usuario' value='$idUser'>
                  <div class='textfield'>
                      <label>Nome do usuário</label>
                      <input type='text' name='Nome_usuario' placeholder='Nome do usuário' value='$nomeUser' required>
                  </div>
                  <div class='textfield'>
                      <label>Email</label>
                    <input type='text' name='email_usuario' placeholder='email' value='$emailUser' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Senha do usuário</label>
                      <input type='text' name='senha_usuario' value='$senhaUser' placeholder='Senha' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Telefone</label>
                    <input type='text' name='tel_usuario' value='$telUser' placeholder='Telefone' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>CPF</label>
                    <input type='text' name='cpf_usuario' placeholder='CPF' value='$cpfUser' required> <br>
                  </div>
                  <div class='textfield'>
                      <label>Administrador(Sim/Não)</label>
                    <input type='text' name='adm_usuario' value='$admUser' required> <br>
                  </div>
                  <input type='submit' value='Alterar' class='btn-login'>
              </div>
          </div>
          </div>
          </form>
        </body>
        </html>";
?>
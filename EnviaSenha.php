
<?php
    ini_set("display_errors",1);
    error_reporting(E_ALL);

    include('util.php');
    $conn = conecta();
    

    if(isset($_POST['email'])){
        $email = $_POST['email'];

        $sql = "SELECT * FROM tbl_usuario WHERE email = '$email';";

        if(VerificaSQL($conn, $sql)){
            $usuario = $conn->query("SELECT nome FROM tbl_usuario WHERE email = '$email';")->fetch();

            $senhaNova = GeraSenha();
            $sql = "UPDATE tbl_usuario set senha = '$senhaNova' WHERE email = '$email';";
        
            ExecutaSQL($conn, $sql);
    
            EnviaEmail($email, "Nova senha", "<p>Ola, ".$usuario['nome']."!<br>Aqui esta a sua nova senha que geramos: ".$senhaNova.".<br>Atensiosamente, WristWear LTDA.</p>");
            }else{
            echo "Email inexistente nos registros!<br>REDIGITE!<br><br>
            <form action='esqueci.php' method='post'>
            <label>Insira um email para envio da nova senha: </label><br>
            <input type='text' name='email'>
            <input type='submit' value='Enviar'>
            </form>";
        }

    }else{
        echo "<form action='esqueci.php' method='post'>
            <label>Insira um email para envio da nova senha: </label><br>
            <input type='text' name='email'>
            <input type='submit' value='Enviar'>
            </form>";
    }
?>
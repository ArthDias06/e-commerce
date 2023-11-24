<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
  //////  funcao de conexao
  //////  14-8-2023
  function conecta ($params = "")  // igual a nada pra indicar q aceita vazio !! 
  {
    if ($params == "") {
        $params="pgsql:host=pgsql.projetoscti.com.br; dbname=projetoscti23; user=projetoscti23; 
                 password=721228";
    }

    $varConn = new PDO($params);

    if (!$varConn) {
        echo "Nao foi possivel conectar";
    } else { return $varConn; }
  }
  /////////////////////////

  
  //////  funcao de login
  //////  11-9-2023
  function funcaoLogin ($paramLogin, $paramSenha, &$paramAdmin)  
  {
   // o "&" antes do nome do parametro $paramAdmin 
   // faz com que a funcao possa alterar o valor da variavel
   // usada na chamada !!!
   $conn = conecta();  
   $varSQL = " select senha,adm from tbl_usuario 
               where email = '$paramLogin' "; 
   $linha =  $conn->query($varSQL)->fetch();
   $paramAdmin = $linha['adm'] == true;
   return $linha['senha'] == $paramSenha;  
                  
                  
   // vc tb poderia procurar numa tabela de usuarios pra 
   // validar o usuario, eqto isso, .......
 

  }

  //////  funcao de definir cookie
  //////  11-9-2023
  function DefineCookie($paramNome, $paramValor, $paramMinutos) 
  {
   echo "Cookie: $paramNome Valor: $paramValor";  
   setcookie($paramNome, $paramValor, time() + $paramMinutos * 60);
  }

  function CriaPDF ( $paramTitulo, $paramHtml, $paramArquivoPDF )
  {
   $arq = false;     
   try {  
    require_once "fpdf/html_table.php"; 
    // abre classe fpdf estendida com recurso que converte <table> em pdf
  
    $pdf = new PDF();  
    // cria um novo objeto $pdf da classe 'pdf' que estende 'fpdf' em 'html_table.php'
    $pdf->AddPage();  // cria uma pagina vazia
    $pdf->SetFont('helvetica','B',20);       
    $pdf->Write(5,$paramTitulo);    
    $pdf->SetFont('helvetica','',8);     
    $pdf->WriteHTML($paramHtml); // renderiza $html na pagina vazia
    ob_end_clean();    
    // fpdf requer tela vazia, essa instrucao 
    // libera a tela antes do output
    
    // gerando um arquivo 
    $pdf->Output($paramArquivoPDF,'F');
    // gerando um download 
    $pdf->Output('D',$paramArquivoPDF);  // disponibiliza o pdf gerado pra download
    $arq = true;
   } catch (Exception $e) {
     echo $e->getMessage(); // erros da aplicação - gerais
   }
   return $arq;
  }

  function EnviaEmail ($pEmailDestino, $pAssunto, $pHtml)   
  {
    $usuario = "wristwear.cti10@outlook.com";
    $Senha = "a6a7c8d9d10";
   // troque usuario e senha !!!! 
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
   require_once './PHPMailer-master/Exception.php';
    require_once './PHPMailer-master/PHPMailer.php';
    require_once './PHPMailer-master/SMTP.php';
 
   $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->setFrom('wristwear.cti10@outlook.com');
    $mail->Username = 'wristwear.cti10@outlook.com';
    $mail->Password ='a6a7c8d9d10';
    $mail->Host = 'smtp.office365.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->FromName = "Suporte WristWear LTDA"; 
    $mail->isHTML(true);
 
    $mail->Subject = $pAssunto;
    $mail->Body = $pHtml;
    $mail->addAddress($pEmailDestino);
 
    $enviado = $mail->send();
    if (!$enviado) {
      echo "<br>Erro: " . $mail->ErrorInfo;
      echo "<br>Voltar para a home: <a href='index.php'>Home</a>";
    } else {
      echo "<br><b>Nova Senha enviada para o seu email!</b>";
      echo "<br>Voltar para a home: <a href='index.php'>Home</a>";
    }
   return $enviado;  
  }

  function ExecutaSQL( $paramConn, $paramSQL ) 
  {
    // exec eh usado para update, delete, insert
    // eh um metodo da conexao
    // retorna o nro de linhas afetadas
    $linhas = $paramConn->exec($paramSQL);

    if ($linhas > 0) { 
        return TRUE; 
    } else { 
        return FALSE; 
    }  
  }

  function VerificaSQL( $paramConn, $paramSQL ) 
  {
    $linha = $paramConn->prepare($paramSQL);
    $execucao = $linha->execute();

    if ($execucao > 0) { 
        return TRUE; 
    } else { 
        return FALSE; 
    }  
  }

  function ValorSQL( $pConn, $pSQL ) 
  {
   $linhas = $pConn->query($pSQL)->fetch();

   if ($linhas > 0) { 
       return $linhas[0]; 
   } else { 
       return "0"; 
   }  
  }

  function GeraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
  {
    //$lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';

    //$caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros)    $caracteres .= $num;
    if ($simbolos)   $caracteres .= $simb;

    $len = strlen($caracteres);
    
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    
    return $retorno;
  }


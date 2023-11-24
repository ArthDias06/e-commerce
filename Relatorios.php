<?php 

   // mostra erros do php
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);   
   session_start();
   include("util.php");

   // calcula hoje
   $hoje = date('Y-m-d');
   // calcula ontem
   $ontem = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $hoje ) ) ));
  
   echo "
   <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='estilo.css'>
        <title>Relatório</title>
    </head>
    <body>
    <div id='divfixa'>
            <div id='logo'>
                <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
            </div>
            <div id='home'>
                <img src='./imagens/relatorios.png' height='50px' width='50px'>
                <p>Relatório</p>
            </div>
        <div id='perfil'>
        <a href='Login.php' class='link'><img src='./imagens/perfil.png' height='50px' width='50px'></a>
	</div>
                <div id='hamburguer'>
                <span class='barra'></span>
                <span class='barra'></span>
                <span class='barra'></span>
            </div>
            <div>
                <ul id='menu'>
                    <a href='index.php' class='link'><li class='item'>Home</li></a>
                    <a href='Produtos.php' class='link'><li class='item'>Produtos</li></a>
                    <a href='Carrinho.php' class='link'><li class='item'>Carrinho</li></a>
                    <a href='ContateNos.php' class='link'><li class='item'>Contate-nos</li></a>
                    <a href='SobreNos.php' class='link'><li class='item'>Sobre nós</li></a>";
                    if(isset($_SESSION['sAdm']) && $_SESSION['sAdm']){
                        echo "<a href='Usuario.php' class='link'><li class='item'>Usuários</li></a>";
                        echo "<a href='Relatorios.php' class='link'><li class='item'>Relatório</li></a>";}
                    if(isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado']){
                        echo "<a href='Logout.php' class='link'><li class='item'>Sair</li></a>";}
                    echo "</ul>
            </div>
    </div>
    <div><img src='./imagens/up-arrow.png' width='50px' height='50px' id='voltar'></div>
    <script>
            const hamburguer=document.getElementById('hamburguer');
            const menu=document.getElementById('menu');
            hamburguer.addEventListener('click', ()=>{
                hamburguer.classList.toggle('active');
                menu.classList.toggle('active');
            })
        const elemento= document.getElementById('voltar');
        console.log(elemento)
        elemento.addEventListener('click', (e)=>{
            window.scroll({top: 0, left: 0, behavior:'smooth'});
        });
        window.addEventListener('scroll',()=>{
            if(window.scrollY==0){
                elemento.style.display='none';
            }
            else{
                elemento.style.display='block';
            }
        });
    </script><br><br><br><br><br><br>
     <form action='Relatorios.php' method='POST'>
     <div class='main-login'>
     <div class='left-login'>
     <div class='card-login'>
      <div class='textfield'>
      <label>Data inicial</label><br><input type='date' name='datai' value='$ontem'></div><br>
      <div class='textfield'>
      <label>Data final</label><br><input type='date' name='dataf' value='$ontem'></div><br>
      <div class='textfield'>
      <label>Onde ver?</label><br>
      <div class='radio'><input type='radio' name='modo' value='fpdf'>PDF<br>
      <input type='radio' name='modo' value='pagina'>Página</div></div><br>
      <input type='submit' value='Gerar' class='btn-login'>
     </div></div></div></form></body> ";

   if ( $_POST ) {
      // faz conexao 
      $conn = conecta();

      $datai = $_POST['datai'];
      $dataf = $_POST['dataf'];

      $SQLCompra = 
              "select tbl_compra.id_compra, tbl_compra.data_compra, tbl_usuario.nome, 
                  sum ( tbl_compra_produto.quantidade_produto * tbl_produto.preco ) total  
                from tbl_compra 
                  inner join tbl_usuario on tbl_compra.usuario = tbl_usuario.id_usuario 
                  inner join tbl_compra_produto on tbl_compra_produto.fk_id_compra = tbl_compra.id_compra
                  inner join tbl_produto on tbl_produto.id_produto = tbl_compra_produto.fk_id_produto 
                where 
                  tbl_compra.data_compra >= :datai and tbl_compra.data_compra <= :dataf and 
                  tbl_compra.status_compra = 'Concluída'  
                group by 
                  tbl_compra.id_compra, tbl_compra.data_compra, tbl_usuario.nome 
                order by tbl_compra.data_compra "; 

      $SQLItensCompra = 
                "select tbl_produto.nome, tbl_compra_produto.quantidade_produto, tbl_produto.preco, 
                  tbl_compra_produto.quantidade_produto * tbl_produto.preco subtotal 
                from tbl_compra_produto  
                  inner join tbl_produto on tbl_produto.id_produto = tbl_compra_produto.fk_id_produto 
                where 
                  tbl_compra_produto.fk_id_compra = :cod_compra   
                order by tbl_produto.descricao "; 
    
      /*   m o d e l o
      Cod  Data        Cliente               $ Total
        1  20/10/2023  JOAO DA SILVA        10000,00
          Produto      Qt   Unit        Sub
          CHAVEIRO      2   50,00    100,00
          BOTOM         1   10,00     10,00
      */
  
      // formata valores em reais 
      setlocale(LC_ALL, 'pt_BR.utf-8', );

      $html = "<html><br>";

      // abre a consulta de COMPRA do periodo
      $compra = $conn->prepare($SQLCompra);
      $compra->execute ( [ 'datai' => $datai, 
                          'dataf' => $dataf ] );
      // prepara os ITENS     
      $itens_compra = $conn->prepare($SQLItensCompra);

      
      // fetch significa carregar proxima linha
      // qdo nao tiver mais nenhuma retorna FALSE pro while
    
      /////////////  M E S T R E ////////////////////   
      // carrega a proxima linha COMPRA
      

      while ( $linha_compra = $compra->fetch() )  
      {
        $html.="<table border='1'>";
        $html .= "<tr><br><td width='220'>Id</td><td>Data</td><td>Nome</td><td>$ tot</td></b></tr>";
        $cod_compra = $linha_compra['id_compra'];
        $data       = $linha_compra['data_compra'];
        $cliente    = $linha_compra['nome'];
        $total      = number_format($linha_compra['total'], 2, ',', '.');
        
        $html .="<tr><td width='220'>$cod_compra</td><td>$data</td><td>$cliente</td><td>$total</td></tr></table><br>";               
            
        // executa ITENS passando o codigo da COMPRA atual
        $itens_compra->execute( [ 'cod_compra' => 
                              $linha_compra['id_compra'] ] );

        $html .= "<table border='1'><tr><b><td width='220'>Prod</td><td>Qtd</td><td>$ unit</td><td>$ sub</td></b></tr>";

        /////////////  D E T A L H E  ////////////////////
        // carrega a proxima linha ITENS_COMPRA
        while ( $linha_itens_compra = $itens_compra->fetch() ) 
        {
          $produto  = $linha_itens_compra['nome'];
          $qtd      = $linha_itens_compra['quantidade_produto'];
          $unit     = number_format($linha_itens_compra['preco'], 2, ',', '.');
          $subtotal = number_format($linha_itens_compra['subtotal'], 2, ',', '.');

          $html .= "<tr><td width='220'>$produto</td><td>$qtd</td><td>$unit</td><td>$subtotal</td></tr><br>";
        } 
        $html.="</table><hr>";
      }

      $html.="</html>";
      if($_POST["modo"]=="pagina")
        echo $html;
      else{
        if ( CriaPDF ( 'Relatorio de Vendas', 
                        $html, 
                        'relatorios/'.$dataf.'.pdf' ) )  {
          echo 'Gerado com sucesso';
        }
        header('Location: relatorios/'.$dataf.'.pdf');}
   }
?>
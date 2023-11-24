<?php

 // visualizar todos os erros
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 
 // incluir util.php
 include ("util.php");
 
 session_start();

 // captura session_id (garante o acesso concorrente)
 $session_id = session_id();  

 // chama conecta() e guarda a conexao default em $conn
 $conn = conecta();   // conecta com o banco e obtem a var de controle $conecta

 // se estiver logado pega o codigo do usuario atraves do $login 
 if ( isset($_SESSION['nome']) ) {
      $login = $_SESSION['nome'];
      $codigoUsuario = ValorSQL($conn, "select id_usuario from tbl_usuario
                                        where nome = '$login'");
 }
     
 // existe alguma compra associada ao session_id ??
 $existe = intval ( ValorSQL($conn,"select count(*) from tbl_compra
                                    inner join tbl_compra_temporaria
                                    on tbl_compra.id_compra = tbl_compra_temporaria.fk_id_compra
                                    where tbl_compra_temporaria.sessao = '$session_id' ") ) == 1;
 // se nao existe
 if (!$existe) {

    $dataHoje = date('Y/m/d');

    $statusCompra = 'Pendente';

    // cria um registro de compras com o usuario nulo
    ExecutaSQL($conn," insert into tbl_compra (data_compra, status_compra)
                       values ('$dataHoje','$statusCompra') ");

    // recupera o codigo usado no auto-incremento
    $codigoCompra = $conn->lastInsertId();

    // insere o tmpcompra
    ExecutaSQL($conn," insert into tbl_compra_temporaria (fk_id_compra, sessao) 
                       values ($codigoCompra,'$session_id') ");  
 
 } else {

    // como o teste mostrou que ja existe um registro de compra
    // retorna esse codigo de compra
    $codigoCompra = intval ( ValorSQL($conn," select id_compra from tbl_compra
                                              inner join tbl_compra_temporaria on tbl_compra.id_compra = 
                                              tbl_compra_temporaria.fk_id_compra 
                                              where tbl_compra_temporaria.sessao = '$session_id'"));

    // obtem o status dessa compra, se criou agora, entao eh 'pendente'
    $statusCompra = ValorSQL($conn, " select status_compra from tbl_compra 
                                      where id_compra = $codigoCompra ");
        
 }

 ////////////// se estiver logado atualiza e 'liga' a compra com o 
 ////////////// usuario

 if (isset($codigoUsuario)) {
    ExecutaSQL($conn,"update tbl_compra 
                         set usuario = $codigoUsuario 
                      where 
                         usuario is null and 
                         id_compra = $codigoCompra"); 
 }

 // se o carrinho foi chamado por COMPRAR, EXCLUIR ou FECHAR

 if (isset($_GET['operacao'])) { 
     
    $operacao = $_GET['operacao'];
    if(isset($_GET['id_produto'])){
    $codigoProduto = $_GET['id_produto'];
    $frase="select qtde_estoque from tbl_produto where id_produto=$codigoProduto";
    $selecionar=$conn->query($frase);
    $fetch=$selecionar->fetch();
    $quantidadeTotal = $fetch['qtde_estoque'];
    // obtem a qtd atual desse produto no carrinho  
    $quantidade = intval ( ValorSQL($conn," select quantidade_produto 
                                            from tbl_compra_produto 
                                            where 
                                               fk_id_produto = $codigoProduto and 
                                               fk_id_compra = $codigoCompra ") );}
    if ($operacao == 'comprar') {
        ExecutaSQL($conn,"update tbl_compra set status_compra='Concluída' where id_compra=$codigoCompra");
       ExecutaSQL($conn,"delete from tbl_compra_temporaria where fk_id_compra=$codigoCompra");
       $aviso="Compra concluída com sucesso!";
       header('location:index.php?aviso='.$aviso.'');
    } else 
    if ($operacao == 'excluir') {
        if ($quantidade == 1) { 
            ExecutaSQL($conn," delete from 
                                  tbl_compra_produto 
                               where 
                                  fk_id_produto = $codigoProduto and 
                                  fk_id_compra = $codigoCompra ");
            ExecutaSQL($conn,"update tbl_produto set qtde_estoque = qtde_estoque + 1
                              where id_produto=$codigoProduto");
        } else {
            ExecutaSQL($conn," update tbl_compra_produto 
                                   set quantidade_produto = quantidade_produto - 1 
                               where 
                                  fk_id_produto = $codigoProduto and 
                                  fk_id_compra = $codigoCompra ");
            ExecutaSQL($conn,"update tbl_produto set qtde_estoque = qtde_estoque + 1
                              where id_produto=$codigoProduto");
        }
        header('location:Carrinho.php');
        die();
    } else 
    if ($operacao == 'incluir') {
        if($quantidadeTotal>0){
            if ($quantidade == 0) {
            ExecutaSQL($conn,
                      " insert into tbl_compra_produto 
                           (fk_id_produto,fk_id_compra,quantidade_produto) 
                        values ($codigoProduto,$codigoCompra,1) ");
            ExecutaSQL($conn,"update tbl_produto set qtde_estoque = qtde_estoque - 1
                              where id_produto = $codigoProduto");
        } else 
            if($quantidade>0){
            ExecutaSQL($conn,
                      " update tbl_compra_produto 
                           set quantidade_produto = quantidade_produto + 1 
                        where 
                           fk_id_produto = $codigoProduto and 
                           fk_id_compra = $codigoCompra ");
            ExecutaSQL($conn,"update tbl_produto set qtde_estoque = qtde_estoque - 1
                              where id_produto = $codigoProduto");}
        header('location:Carrinho.php');
    }else{
        $aviso="Estoque insuficiente!";
        header('location:Carrinho.php?aviso='.$aviso.'');
    }
    die();
 }
}
 echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='estilo.css'>
    <title>Carrinho</title>
</head>
<body>
    <div id='divfixa'>
        <div id='logo'>
            <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
        </div>
        <div id='home'>
           <img src='./imagens/carrinho.png' height='50px' width='50px'>
            <p>Carrinho</p>
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
    </script>
    <div id='tudo'>";
    if(isset($_GET['aviso'])){
        echo"<script>alert('".$_GET['aviso']."')</script>";
    }
    $varQuery="select quantidade_produto from tbl_compra_produto where fk_id_compra=$codigoCompra";
    $executar=$conn->query($varQuery)->fetch();
    if($executar>0){
       echo "<center>
       <table id='tabelaCarrinho' border='3px'>
        <tr>
         <th>Produto</th>
         <th>Quantidade</th>
         <th>Unidade</th>
         <th>Subtotal</th>
         <th>Ações</th>
        </tr>";
   
 // faz a selecao pra montar a tabela
 $sql = " select tbl_produto.id_produto, 
                 tbl_produto.nome as nomeprod, 
                 tbl_compra_produto.quantidade_produto, 
                 tbl_produto.preco
          from tbl_produto 
               inner join tbl_compra_produto on 
                  tbl_produto.id_produto = tbl_compra_produto.fk_id_produto 
          where tbl_compra_produto.fk_id_compra = $codigoCompra  
          order by tbl_produto.descricao";
   
 $select = $conn->query($sql);
 $total=0;
 // cria table com itens no carrinho e seus subtotais
 while ( $linha = $select->fetch() ) {
      $codigoProduto = $linha['id_produto']; 
      $nomeProd      = $linha['nomeprod'];
      $quant         = $linha['quantidade_produto'];
      $vunit         = $linha['preco'];
      if($quant%2==0){
            $num=$quant/2;
            $sub=$num*5;
      }else{
        $num=intval($quant/2);
        $sub=$num*5;
        $sub+=$vunit;
      }
      $total+=$sub;
      // vc poderia incluir links para 'incluir' alem dos 'excluir'
      // com isso, o usuario nao precisaria voltar na home pra incrementar 
      // a quantidade do mesmo produto
      echo "<tr>
             <td>$nomeProd</td>
             <td>$quant</td>
             <td>R$$vunit,00</td>
             <td>R$$sub,00</td>
             <td><a href='Carrinho.php?operacao=excluir&id_produto=$codigoProduto'><img src='./imagens/menos.png' width='26px' height='26px' alt='Excluir'></a>
             <a href='Carrinho.php?operacao=incluir&id_produto=$codigoProduto'><img src='./imagens/mais.png' width='26px' height='26px' alt='Incluir'></a></td>
            </tr>";    
 }
 
 echo "</table>
        <div id='popup'>
        <div>
        <button id='fecharpopup' onclick='fecharPopup()'><img src='./imagens/fechar.png' width='50px' height='50px' alt='Fechar'></button>
        <p><strong>Total:</strong> R$$total,00</p>
        <p><strong>Forma de pagamento:</strong>  Ficha</p>
        </div>
        <a href='Carrinho.php?operacao=comprar'><button class='btn-login'>Comprar</button></a>
        </div>
       </center>";
 // calcula o total e mostra junto com o status da compra      
 echo "<p class='informacoes'>Status da compra: $statusCompra</p><br>";
 echo "<p class='informacoes'>Total: R$$total,00</p><br><br>";
 
 // se o login foi obtido (se esta logado), mostra link 'fechar carrinho' 
 if ( isset($login) ) 
 {
   if ($statusCompra == 'Pendente' && $login <> '') {
     echo "<center>
           <button id='finalizar' onclick='chamarPopup()'>Finalizar compra</button>
           </center>
           <script>
           const popup = document.getElementById('popup');
            function chamarPopup()
            {
                popup.style.display='flex';
                popup.css('top', $(document).scrollTop() + 'px');
            }
            function fecharPopup()
            {
                popup.style.display='none';
            }
           </script>";         
   }
 }
    }else{
         echo "<div id='carrinhoVazio'><div><b>Não há itens no carrinho!</b></div>
         <div><a href='Produtos.php'><button class='btn-login'>+Adcionar</button></a></div></div>";
    }
 echo "</div><br><br>
        <div class='rodape'>
            <p>Este é o projeto do Ecommerce desenvolvido pela equipe 02 de informática do 
            2º ano no Colégio Técnico</p>
        </div>
        </body>
        </html>";   
 
 
?>
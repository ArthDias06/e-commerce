<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include('util.php');
    session_start();
    $conn=conecta();
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='estilo.css'>
        <title>Produtos</title>
    </head>
    <body>
        <div id='divfixa'>
            <div id='logo'>
                <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
            </div>
            <div id='home'>
                <img src='./imagens/pulseira.png' height='50px' width='50px'>
                <p>Produtos</p>
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
    <div id='divbusca'>
        <input type='text' id='busca' placeholder='Pesquisar' oninput='buscar()'>&nbsp;
        <div id='Procura'></div>
        <br><br><br>";
    if(!empty($_GET['id_produto'])){
        $query = "select * from tbl_produto where id_produto=:idProduto";
        $select = $conn->prepare($query);
        $select->execute(['idProduto' => $_GET['id_produto']]);
        $linha=$select->fetch();
        // se o produto não existir
        if ($linha == NULL) {
            echo "Produto inexistente";
            die();
        }
        $idProd = $linha['id_produto'];
        $imagemProduto = $linha['imagem'];
        $descProduto = $linha['descricao'];
        $nomeProduto = $linha['nome'];
        $precoProduto = $linha['preco'];
        $qtdeProduto = $linha['qtde_estoque'];
        $excluidoProduto=$linha['excluido'];
        echo"<div id='produtoEscolhido'>
            <div id='descProduto'>
                <p>$nomeProduto<br><br>Preço: R$$precoProduto,00</p><p>$descProduto</p>";
                if(!$excluidoProduto)
                    if($qtdeProduto>0)
                        echo "<a href='Carrinho.php?id_produto=$idProd&operacao=incluir'><button class='botaoProduto'>Adicionar ao carrinho</button></a>";
                    else
                        echo "<p id='Esgotado'>Produto esgotado</p>";
                else
                echo "<p id='Esgotado'>Produto excluído</p>";
            echo "</div>
            <img id='imagemProduto' src='./imagens/$imagemProduto' height='300px' width='400px' alt='Produto escolhido'>
        </div><br><br><br>";
    }
    echo"<div id='containerProd'>";
        $sql = "select * from tbl_produto ORDER BY id_produto";
        $selecionar = $conn->query($sql);
        while($row=$selecionar->fetch()){
        $idProduto = $row['id_produto'];
        $imgProduto = $row['imagem'];
        $nomeProd = $row['nome'];
        $precoProd = $row['preco'];
        $excluido = $row['excluido'];
        if($excluido)
            $nomeBotao="Restaurar";
        else
            $nomeBotao="Excluir";
        if(isset($_SESSION['sAdm']) && $_SESSION['sAdm']){
            echo"<div class='produtos'>
            <img src='./imagens/$imgProduto' class='imgProd'>
            <div class='divProdutos'><p>$nomeProd<br>R$$precoProd,00";
	    if($excluido){
	    echo "<br>Excluido";}
	    echo "</p></div>
            <div class='divProdutos'>
            <a href='ExcluirProduto.php?id_produto=$idProduto'><button class='Funcionalidade'>$nomeBotao</button></a>
            <a href='AlterarProdutos.php?id_produto=$idProduto'><button class='Funcionalidade'>Alterar</button></a>
            <a href='Produtos.php?id_produto=$idProduto'><button class='Funcionalidade'>Ver</button></a></div>
            </div>";
        }
        else if(!$excluido){
            echo"<div class='produtos'>
                <img src='./imagens/$imgProduto' class='imgProd'>
                <div class='divProdutos'><p>$nomeProd<br>R$$precoProd,00</p></div>
                <div class='divProdutos'>
            <a href='Produtos.php?id_produto=$idProduto'><button class='Funcionalidade'>Ver</button></a></div>
            </div>";
        }
        }
    echo"</div>
    <script>
    function buscar() {
        const itemPesquisado = document.getElementById('busca');
        const Procura = document.getElementById('Procura');
        const termo = itemPesquisado.value.trim().toLowerCase();

        Procura.innerHTML = '';

        if (termo.length > 0) {
            Array.from(document.querySelectorAll('.produtos')).forEach(function (produto) {
                const produtoNome = produto.querySelector('p').textContent.toLowerCase();

                if (produtoNome.includes(termo)) {
                    Procura.appendChild(produto.cloneNode(true));
                }
            });

            if (Procura.children.length == 0) {
                Procura.innerHTML = '<p>Nenhum resultado encontrado.</p>';
            }
        } else {
            Procura.innerHTML = '';
        }
    }
    </script>";
if(isset($_SESSION['sAdm']) && $_SESSION['sAdm']){
    echo"<a href='AlterarProdutos.php'><button id='maisProd'>+ Adicionar produto</button></a>";}
    echo"<br><br>
    <div class='rodape'>
        <p>Este é o projeto do Ecommerce desenvolvido pela equipe 02 de informática do 
        2º ano no Colégio Técnico</p>
    </div>
    </body>
    </html>";
?>
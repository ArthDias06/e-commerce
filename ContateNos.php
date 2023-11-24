<?php
include('util.php');
$conn=conecta();
session_start();
echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='estilo.css' type='text/css'>
    <title>Contate-nos</title>
</head>
<body>
    <div id='divfixa'>
        <div id='logo'>
            <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
        </div>
        <div id='home'>
            <img src='./imagens/contato.png' height='50px' width='50px'>
            <p>Contatos</p>
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
    <img src='./imagens/up-arrow.png' width='50px' height='50px' id='voltar'>
    <script>
            const hamburguer=document.getElementById('hamburguer');
            const menu=document.getElementById('menu');
            hamburguer.addEventListener('click', ()=>{
                hamburguer.classList.toggle('active');
                menu.classList.toggle('active');
            })
        const elemento= document.getElementById('voltar');
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


    <div id='container_contate'>
        <div class='texto_contate'>
            <p class='titulo_contate'>Problemas? <br>Entre em contato</p>
            <p class='subtitulo_contate'>Telefone:</p>
            <p class='font_contate'>&nbsp;(14)99650 0635</p>
            <br><br>

            <p class='subtitulo_contate'>Email:</p>
            <p class='font_contate'>&nbsp;wristwear.cti@gmail.com</p>
            <br><br>

            <p class='subtitulo_contate'>Instagram:</p>
            <p class='font_contate'>&nbsp;@wristwear_pulseiras</p>
        </div>
    </div>
    <br><br>
    <div class='rodape'>
        <p>Este é o projeto do Ecommerce desenvolvido pela equipe 02 de informática do 
        2º ano no Colégio Técnico</p>
    </div>
</body>
</html>";
?>
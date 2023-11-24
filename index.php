<?php
$temposessao1hora=3600;
session_set_cookie_params($temposessao1hora);
include('util.php');
$conn=conecta();
session_start();
echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='estilo.css' >
    <title>Home</title>
</head>
<body>
    <div id='divfixa'>
        <div id='logo'>
            <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
        </div>
        <div id='home'>
            <img src='./imagens/casa.png' height='50px' width='50px'>
            <p>Home</p>
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
    </script>";
    if(isset($_GET['aviso'])){
       echo"<script>alert('".$_GET['aviso']."')</script>";
    }
    echo "<div id='grids'>
        <div class='cima'>
            <div class='slides transicao'><img src='./imagens/img_grande1.png' height='300vh' width='800vw'></div>
	    <div class='slides transicao'><img src='./imagens/img_grande2.png' height='300vh' width='800vw'></div>
	    <div class='slides transicao'><img src='./imagens/img_grande3.png' height='300vh' width='800vw'></div>
            <div id='Pontos'>
                <span class='numeroImagem' onclick='mudar(0)'></span>
		<span class='numeroImagem' onclick='mudar(1)'></span>
		<span class='numeroImagem' onclick='mudar(2)'></span>            </div>
            <script>
            let number=0;
            showSlides();
            function mudar(n){
                number=n+1;
                let i;
                let slides = document.getElementsByClassName('slides');
                let ponto = document.getElementsByClassName('numeroImagem');
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = 'none';
                }
                for (i = 0; i < ponto.length; i++) {
                    ponto[i].className = ponto[i].className.replace(' ativar', '');
                }
                slides[n].style.display = 'block';  
                ponto[n].className += ' ativar';
            }
            function showSlides() {
                let i;
                let slides = document.getElementsByClassName('slides');
                let ponto = document.getElementsByClassName('numeroImagem');
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = 'none';  
                }
                number++;
                if (number > slides.length) {number = 1}    
                for (i = 0; i < ponto.length; i++) {
                    ponto[i].className = ponto[i].className.replace(' ativar', '');
                }
                slides[number-1].style.display = 'block';  
                ponto[number-1].className += ' ativar';
                setTimeout(showSlides, 8000);
            }
            </script>
        </div>
        <div class='meio'>
            <div id='imagem1'><img src='./imagens/img_media1.png' width='250px' height='250px'></div>
            <div id='imagem2'><img src='./imagens/img_media2.png' width='250px' height='250px'></div>
            <div id='imagem3'><img src='./imagens/img_media3.png' width='250px' height='250px'></div>
        </div>
        <div class='baixo'>
            <div id='descVideo'>
                <p>Você já conhece as pulseiras artesanais Wrist Wear? Elas são acessórios disponíveis para qualquer estilo e ocasião, 
                além de serem ótimos para presentear alguém especial. As pulseiras são feitas com miçangas de diferentes cores, 
                formas e tamanhos. Você pode escolher entre vários modelos prontos ou personalizar o seu próprio, de acordo com o seu 
                gosto e criatividade. Nossos produtos são mais do que simples bijuterias: são uma forma de expressar a sua 
                personalidade e beleza. Veja o vídeo de nossa linha de produção, juntamente com alguns exemplos que irão te inspirar a 
                adquirir a seu modelo ideal !!!
                </p>
            </div>
            <div id='video'><iframe width='560' height='315' src='https://www.youtube.com/embed/UhYV8wOmIqU?si=J1z3F6AR8hqMn8pI' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>            </div>
        </div>
        <div class='maisBaixo'>
            <div id='descGeral'>
                <p>As pulseiras artesanais são acessórios que valorizam a sua beleza, realçando o seu charme e a sua personalidade. 
                São feitas com miçangas de variadas cores e modelos pensados em você!!<br>Nossos produtos atendem a demanda do público 
                interessado em harmonia e criatividade, seja este constituinte tanto de homens e mulheres que encontrarão sua 
                personalidade refletida em algum(ns) dos vários modelos existentes de nossas pulseiras!! Veja nas imagens os modelos 
                criados, contendo a combinação de cores e estilos pensados em você!!</p>
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
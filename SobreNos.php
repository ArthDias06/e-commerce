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
    <title>Sobre Nós</title>
</head>
<body>
    <div id='divfixa'>
        <div id='logo'>
            <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
        </div>
        <div id='home'>
            <img src='./imagens/sobre.png' height='50px' width='50px'>
            <p>Sobre</p>
        </div>
        <div id='perfil'>
            <a href='Login.php'><img src='./imagens/perfil.png' height='50px' width='50px'></a>
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


    <div id='container_sobre'>
        <div class='texto_sobre'>
            <p class='titulo_sobre'>Sobre Nós</p>
            <p class='subtitulo_sobre'>Nossa Empresa</p>
            
            <p>&emsp;&emsp;Bem-vindo à Wrist Wear - Sua Fonte de Pulseiras Artesanais Exclusivas!</p><br>
                
            <p>&emsp;&emsp; A Wrist Wear é uma loja virtual dedicada à venda de pulseiras artesanais que combinam perfeitamente com sua estética pessoal. Somos uma equipe apaixonada de desenvolvedores que acreditam no poder da expressão individual e no valor do artesanato. Nossa missão é oferecer a você uma seleção cuidadosamente curada de pulseiras únicas, projetadas para complementar o seu estilo e personalidade.</p>
                
            <p class='subtitulo_sobre'>Nossos Produtos</p>
                
            <p>&emsp;&emsp;Nossas pulseiras artesanais são verdadeiras obras de arte em seu pulso. Cada peça é cuidadosamente confeccionada à mão. Nosso catálogo inclui uma variedade de estilos e cores para que você possa encontrar a pulseira perfeita para qualquer ocasião.</p>
                
            <p class='subtitulo_sobre'>O Projeto Wrist Wear</p>
                
            <p>&emsp;&emsp;O projeto Wrist Wear nasceu da paixão por acessórios que refletem a individualidade. Nossa equipe de desenvolvedores, composta por Arthur Pupolin, Carol Xavier, Diogo Harada, Daniel Giraldi e Arthur de Castro, uniu forças para criar uma plataforma online que tornasse mais fácil para todos terem acesso a pulseiras artesanais incríveis. Acreditamos que a moda deve ser acessível e inclusiva, e nosso projeto visa exatamente isso.</p>
                
            <p class='subtitulo_sobre'>Desenvolvimento e Dedicação</p>
                
            <p>&emsp;&emsp;Nossa jornada foi marcada por horas de dedicação e cuidado. Trabalhamos arduamente para criar uma experiência de compra online suave e intuitiva, onde você pode navegar em nosso catálogo, fazer suas escolhas com facilidade e ter suas pulseiras exclusivas entregues à sua porta. Nosso compromisso com a qualidade é inabalável, e garantimos que cada pulseira que você adquire na Wrist Wear seja uma verdadeira representação do nosso amor pelo artesanato.</p>
                
            <p class='subtitulo_sobre'>Sobre o Site</p>
                
            <p>&emsp;&emsp;Nosso site foi projetado com você em mente. É fácil de navegar, com uma interface amigável que permite que você encontre as pulseiras perfeitas em apenas alguns cliques.</p>
            
            <p class='subtitulo_sobre'>Professores Orientadores: </p>
                
            <p>Marcelo Cabelo Peres<br>
            José Vieira Junior<br>
            Debora Barbosa Aires<br>
            Jovita Mercedes Hojas Baenas</p>
        </div>

        <br><br>

        <div class='imagens_sobre'>
            <p class='titulo_sobre'>Integrantes</p>

            <div>
                <div class='integrantes_sobre'>
                    <img src='./imagens/ArthurDeCastro_Ecommerce.png' alt='Arthur'>
                    <p>Arthur de Castro, n°06</p>
                </div>
    
                <div class='integrantes_sobre'>
                    <img src='./imagens/ArthurPupolin_Ecommerce.png' alt='Arthur'>
                    <p>Arthur Pupolin, n°07</p>
                </div>
    
                <div class='integrantes_sobre'>
                    <img src='./imagens/Carol_Ecommerce.png' alt='Carol'>
                    <p>Carol Xavier, n°08</p>
                </div>
    
                <div class='integrantes_sobre'>
                    <img src='./imagens/Daniel_Ecommerce.png' alt='Daniel'>
                    <p>Daniel Giraldi, n°09</p>
                </div>
    
                <div class='integrantes_sobre'>
                    <img src='./imagens/Diogo_Ecommerce.png' alt='Diogo'>
                    <p>Diogo Harada, n°10</p>
                </div>
            </div>


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
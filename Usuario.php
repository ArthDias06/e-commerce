<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
include ("util.php");
$conn=conecta();
session_start();
echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Usuários</title>
    <link rel='stylesheet' type='text/css' href='estilo.css'></link>
</head>
<body>
    <div id='divfixa'>
        <div id='logo'>
        <a href='index.php'><img src='./imagens/logo.png' id='logo' width='110px' height='74px'></a>
        </div>
        <div id='home'>
            <img src='./imagens/sobre.png' height='50px' width='50px'>
            <p>Usuários</p>
        </div>
        <div id='perfil'>
            <img src='./imagens/perfil.png' height='50px' width='50px'>
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
<h1 id='titulo'>Tabela de Usuários</h1>
<table id='usuarios'><tr>
        <th>Id</th>
        <th>Usuário</th>
        <th>Email</th>
        <th>Senha</th>
        <th>CPF</th>
        <th>Telefone</th>
        <th>Adm</th>
        <th>Ações</th>
    </tr>";
    $query="select * from tbl_usuario ORDER BY id_usuario";
    $select=$conn->query($query);
    while($linha=$select->fetch()){
    echo "<tr>
        <td>".$linha['id_usuario']."</td>
        <td>".$linha['nome']."</td>
        <td>".$linha['email']."</td>
        <td>".$linha['senha']."</td>
        <td>".$linha['cpf']."</td>
        <td>".$linha['telefone']."</td>";
        if($linha['adm']==TRUE)
            echo "<td>Sim</td>";
        else
            echo "<td>Não</td>";
        echo "<td><a href='ExcluirUsuario.php?id_usuario=".$linha['id_usuario']."'><img src='./imagens/excluir.png' width='20px' height='20px'></a>
            <a href='AlterarUsuario.php?id_usuario=".$linha['id_usuario']."'><img src='./imagens/alterar.png' width='20px' height='20px'></a></td>
    </tr>";
    }
echo "</table>
</body>
</html>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Cadastro</title>
</head>
<body>
    <form name='formlogin' method='post' action='SalvarDadosECommerce.php'>
    <div class="main-login">
        <div class="left-login">
            <h1>Faça seu cadastro</h1>
            <img src="./imagens/logo.png" class="left-login-image" alt="Logo">
        </div>
        <div class="right-login">
            <div class="card-login">
                <h1>CADASTRO</h1>
                <div class="textfield">
                    <!--<label for="usuario">Usuario (Nome completo)</label>-->
                    <input type="text" name="nome" placeholder="Usuario" required>
                </div>
                <div class="textfield">
                    <!--<label for="email">Email</label>-->
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="textfield">
                    <!--<label for="senha">Senha</label>-->
                    <input id='senha' type="password" name="senha" placeholder="Senha" required>
                </div>
                <div class="textfield">
                    <!--<label for="senha">Confirmar Senha</label>-->
                    <input id='confirmar' type="password" name="confirmarsenha" placeholder="Confirmar Senha" required>
                </div>
                <script>
                    var senha = document.getElementById("senha")
                    var confirmar = document.getElementById("confirmar");

                    function Confirmacao(){
                        if(senha.value != confirmar.value) {
                            confirmar.setCustomValidity("Senhas não conferem!");
                        } else {
                            confirmar.setCustomValidity('');
                        } 
                    }
                    senha.onchange = Confirmacao;
                    confirmar.onkeyup = Confirmacao;

                    const phoneNumberInput = document.getElementById('phoneNumber');
                    phoneNumberInput.addEventListener('input', function() {
                        const cleanedInput = this.value.replace(/\D/g, '');
                        if (cleanedInput.length > 0) {
                            let formattedInput = '(' + cleanedInput.substring(0, 2) + ') ';
                            formattedInput += cleanedInput.substring(2, 6) + '-';
                            formattedInput += cleanedInput.substring(6, 10);
                            this.value = formattedInput;
                        }
                    });
                </script>
                <div class="textfield">
                    <!--<label for="usuario">Telefone</label>-->
                    <input type="text" name="telefone" placeholder="Telefone" required id="tel">
                </div>
                <div class="textfield">
                    <!--<label for="usuario">CPF</label>-->
                    <input type="text" name="cpf" placeholder="CPF" required>
                </div>
                <script>
                    var senha = document.getElementById("senha")
                    var confirmar = document.getElementById("confirmar");

                    function Confirmacao(){
                        if(senha.value != confirmar.value) {
                            confirmar.setCustomValidity("Senhas não conferem!");
                        } else {
                            confirmar.setCustomValidity('');
                        } 
                    }
                    senha.onchange = Confirmacao;
                    confirmar.onkeyup = Confirmacao;
                </script>
                <button class="btn-login">Cadastrar-se</button>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    session_start(); // Inicia a sessão

    // Verifique se o usuário está logado, ou seja, se a variável de sessão 'user_id' está definida
    if (!isset($_SESSION['user_id'])) {
        // Se não estiver logado, redireciona para a página de login
        header("Location: login.php");
        exit(); // Encerra a execução do script para evitar que o conteúdo da página continue sendo carregado
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Veículos e Proprietários</title>
    <link rel="stylesheet" href="./assets/css/cadastro.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <script>
        async function cadastrarCidadao() {
            const response = await fetch('../scripts/cadastrar_cidadao.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    NumeroUnico: document.getElementById('numeroUnico').value,
                    Nome: document.getElementById('nome').value,
                    Endereco: document.getElementById('endereco').value,
                    DataNascimento: document.getElementById('dataNascimento').value
                })
            });
            const result = await response.json();
            //alert(result.success ? 'Cidadao cadastrado com sucesso!' : 'Erro ao cadastrar cidadão');
            alert(result.success ? 'Cidadao cadastrado com sucesso!' : `Erro ao cadastrar cidadão: ${result.error}`);
            //alert(result.success ? 'Cidadao cadastrado com sucesso!' : 'Erro ao cadastrar cidadão: ' + result.error); //correcão falha cadastro
            if (result.success) {
            document.getElementById('formCidadao').style.display = 'none';
            document.getElementById('formViatura').style.display = 'block';
            }
        }

        async function cadastrarViatura() {
            const response = await fetch('../scripts/cadastrar_viatura.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    Matricula: document.getElementById('matriculaViatura').value,
                    Marca: document.getElementById('marca').value,
                    Modelo: document.getElementById('modelo').value,
                    Ano: document.getElementById('ano').value,
                    Cor: document.getElementById('cor').value
                })
            });
            const result = await response.json();
            alert(result.success ? 'Viatura cadastrada com sucesso!' : 'Erro ao cadastrar viatura');

            if (result.success) {
            document.getElementById('formViatura').style.display = 'none';
            document.getElementById('formPropriedade').style.display = 'block';
            }
        }

        //PROPIEDADE
        async function cadastrarPropiedade() {
            const response = await fetch('draft_propiedade.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    Matricola: document.getElementById('MatricolaPropiedade').value,
                    NumeroBI: document.getElementById('NumeroBI').value,
                    DataInicio: document.getElementById('DataInicio').value,
                    DataFim: document.getElementById('DataFim').value,
                })
            });
            const result = await response.json();
            alert(result.success ? 'Propiedade cadastrada com sucesso!' : 'Erro ao cadastrar viatura');

            if (result.success) {
            document.getElementById('formPropriedade').style.display = 'none';
            document.getElementById('cardFinal').style.display = 'block';
            }
        }

        function recomecar(){
            document.getElementById('cardFinal').style.display = 'none';
            document.getElementById('formCidadao').style.display = 'block';

        }
    </script>
</head>
<header>
    <div class="header">
        <div class="header-left">
            <h1>LUCAR</h1>
        </div>
        <div class="header-right">
            <div class="header-right-txt">
                <h3><?php echo $_SESSION['username']?></h3>
                <p><?php echo $_SESSION['nivel']?></p>
            </div>
            <div class="user-img">
                <img src="./assets/dist/img/adicionar-usuario.png" alt="">
            </div>
        </div>
    </div>
    <div class="sub-header">
        <small>Registo e identificação de viaturas</small>
        <div>
            <a class="btn" href="index.php">&#10094 voltar</a>
        </div>
    </div>
</header>
<body>
    <div class="targuet-list">
        <a href="#" target="_self" rel="noopener noreferrer"> Inicio &#10095</a>
        <a href="#" target="_self" rel="noopener noreferrer"> Cadastro </a>
    </div>
    <div class="row float-container">
        <div class="card" id="formCidadao">
            <div class="card-header">
                <img src="./assets/dist/img/fingerprint.png" alt="">
                <h3 class="card-tittle">Formulario de cadastro de cidadãos</h3>
            </div>
            <div class="card-body">
                <label for="BI">NUMERO BI</label>
                <input type="text" id="numeroUnico"  name="BI" class="input input1" placeholder="">
                <label for="Nome">NOME</label>
                <input type="text" id="nome"  name="Marca"  class="input input1" placeholder="Nome">
                <label for="Modelo">ENDEREÇO</label>                        
                <input type="text" id="endereco"  name="Modelo"  class="input input1" placeholder="Endereço">
                <label for="Ano">DATA DE NASCIMENTO</label>                        
                <input type="date" class="input input1" id="dataNascimento"  name="Ano" placeholder="Data de nacimento" />
            </div>
            <div class="card-footer">
                <button class="btn" onclick="cadastrarCidadao()">Adicionar</button>    
            </div>
        </div>
        <div class="card" id="formViatura" style="display: none;">
            <div class="card-header">
                <img src="./assets/dist/img/car-service.png" alt="">
                <h3 class="card-tittle">Formulario de cadastro de viaturas</h3>
            </div>
            <div class="card-body">
                <label for="MatricolaViatura">MATRICULA</label>
                <input type="text" id="matriculaViatura"  name="Matricola" class="input input1" placeholder="Ex.: U-404-E">
                <label for="Marca">MARCA</label>
                <input type="text" id="marca"  name="Marca"  class="input input1" placeholder="Marca">
                <label for="Modelo">MODELO</label>                        
                <input type="text" id="modelo"  name="Modelo"  class="input input1" placeholder="Modelo">
                <label for="Ano">ANO</label>                        
                <input type="number" id="ano"  name="Ano"  class="input input1" placeholder="Ano de laçamento">
                <label for="Cor">COR</label>   
                <input type="text" id="cor"  name="Cor"  class="input input1" placeholder="Cor"> 
            </div>
            <div class="card-footer">
                <button class="btn" onclick="cadastrarViatura()">Adicionar</button>
            </div>
        </div>
        <div class="card" id="formPropriedade" style="display: none;">
            <div class="card-header">
                <img src="./assets/dist/img/fingerprint.png" alt="">
                <h3 class="card-tittle">PROPIEDADE</h3>
            </div>
            <div class="card-body">
                <label for="Matricola">Matricola</label>
                <input type="text" id="MatricolaPropiedade" name="Matricola" class="input input1" placeholder="Matricola" required>
                <label for="Marca">NumeroBI</label>
                <input type="text" id="NumeroBI" name="NumeroBI" class="input input1"placeholder="NumeroBI" required>
                <label for="Modelo">Data Aquisição</label>
                <input type="date" id="DataInicio" name="DataInicio" class="input input1" placeholder="DataInicio" required>
                <label for="Ano" style="display:none;">DataFim</label>
                <input type="date" style="display: none;" class="input input1" id="DataFim" name="DataFim" placeholder="DataFim" />
            </div>
            <div class="card-footer">
                <button onclick="cadastrarPropiedade()">Criar</button>
            </div>
        </div>
        <div class="modal" id="cardFinal">
            <div class="modal-card">
                <h2><img src="./assets/dist/img/icons8-sucesso.gif" alt=""> FINALIZADO</h2>
                <h4>Deseja confirmar a operação?</h4>
                <button class="modal-btn modal-btn-confirmar" onclick="recomecar()">Confirmar!</button>
                <button class="modal-btn modal-btn-cancelar" onclick="recomecar()">Cancelar!</button>
            </div>
        </div>
    </di>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
</body>

</html>
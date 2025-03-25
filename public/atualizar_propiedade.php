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
    <title>Atualizar Proprietários</title>
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
                    DataNascimento: document.getElementById('dataNascimento').value,
                    Genero:document.querySelector('input[name="Genero"]:checked').value,

                })
            });
            const result = await response.json();            
            if (result.success) {
                var color='green';
                var image='icons8-sucesso.gif';
                var tittle='Sucesso';
                var message='Cidadão cadastrada com sucesso!';
                exibirModal(color,image,tittle,message);

                document.getElementById('formCidadao').style.display = 'none';
                document.getElementById('BtnIrAPropiedade').style.display = 'none';
                document.getElementById('formPropriedade').style.display = 'block';
            } else {
                var color='red';
                var image='icons8-erro.gif';
                var tittle='Erro';
                var message=`Erro ao cadastrar cidadão: ${result.error}`;
                exibirModal(color,image,tittle,message);
            }
        }
        function cidadaoExistente(){
            document.getElementById('formCidadao').style.display = 'none';
            document.getElementById('BtnIrAPropiedade').style.display = 'none';
            document.getElementById('formPropriedade').style.display = 'block';
        }
        //PROPIEDADE
        async function cadastrarPropiedade() {
            const response = await fetch('../scripts/atualizar_propiedade.php', {
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
            //alert(result.success ? 'Propiedade cadastrada com sucesso!' : 'Erro ao cadastrar propiedade');
            if (result.success) {
                var color='green';
                var image='icons8-sucesso.gif';
                var tittle='Sucesso';
                var message='Propiedade cadastrada com sucesso!';
                exibirModal(color,image,tittle,message);

                document.getElementById('formCidadao').style.display = 'none';
                document.getElementById('formPropriedade').style.display = 'block';
            } else {
                var color='red';
                var image='icons8-erro.gif';
                var tittle='Erro';
                var message=`Erro ao cadastrar propiedade: ${result.error}`;
                exibirModal(color,image,tittle,message);
            }
        }
        //Modal Methods
        function exibirModal(color,image,tittle,message){
            const modal = document.getElementById('modal'); 
            modal.style="display:flex";

            const modaltittle = document.getElementById('modal-tittle');
            modaltittle.style=`color:${color};`;
            modaltittle.firstElementChild.src="./assets/dist/img/"+image;
            modaltittle.lastElementChild.innerHTML=tittle;

            const modalsubtittle = document.getElementById('modal-subtittle');
            modalsubtittle.innerHTML=message;
        }
        function fecharModal(){
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</head>
<body>
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
    <div class="targuet-list">
        <a href="#" target="_self" rel="noopener noreferrer"> Inicio &#10095</a>
        <a href="#" target="_self" rel="noopener noreferrer"> Atualizar proprietário </a>
    </div>
    <div class="col float-container">
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
                <label for="Genero">GENERO</label>                        
                <span style="margin-top:3px;font-size:13px;">
                    M<input type="radio" name="Genero" value="Mascolino" placeholder="Mascolino" />
                    F<input type="radio" name="Genero" value="Femenino" placeholder="Femenino" />
                </span>
            </div>
            <div class="card-footer">
                <button class="btn" onclick="cadastrarCidadao()">Adicionar</button>    
            </div>
        </div>
        <div class="card" id="formPropriedade" style="display: none;">
            <div class="card-header">
                <img src="./assets/dist/img/fingerprint.png" alt="">
                <h3 class="card-tittle">ATUALIZAR PROPIEDADE</h3>
            </div>
            <div class="card-body">
                <label for="Matricola">Matricola</label>
                <input type="text" id="MatricolaPropiedade" name="Matricola" class="input input1" placeholder="Matricola">
                <label for="Marca">BI do Novo propietário</label>
                <input type="text" id="NumeroBI" name="NumeroBI" class="input input1"
                    placeholder="NumeroBI">
                <p style="font-size: 10px; color:aliceblue">* A DATA DE AQUISIÇÃO É DATA EM QUE FOI VENDIDA E COMPRADA A VIATURA </p>
                <label for="Modelo">Data de Aquisição</label>
                <input type="date" id="DataInicio" name="DataInicio" class="input input1" placeholder="DataInicio">
                <label for="Ano" style="display: none;">DataFim</label>
                <input type="date" style="display: none;" class="input input1" id="DataFim" name="DataFim" placeholder="DataFim" />
            </div>
            <div class="card-footer">
                <button class="btn" onclick="cadastrarPropiedade()">Adicionar</button>
            </div>
        </div>
        <div class="modal" id="modal" style="display:none;">
            <div class="modal-card">
                <h2 id="modal-tittle"><img id="modalicon" src="./assets/dist/img/info.png" alt=""><span>FINALIZADO</span></h2>
                <h4 id="modal-subtittle"></h4>
                <!--button class="modal-btn modal-btn-confirmar" onclick="recomecar()">Confirmar!</!--button>
                <button-- class="modal-btn modal-btn-cancelar" onclick="recomecar()">Cancelar!</button-->
                <button class="modal-btn" onclick="fecharModal()">Ok</button>
            </div>
        </div>
    </di>
    <div class="divcidadaoExistente" id="BtnIrAPropiedade" style="background-color:rgba(104, 146, 168, 0.25);width:fit-content;padding:7px 60px; border-radius:5px">
        <h4 style="color:#486066;margin:5px 0px 7px 0px" >CIDÃO JÁ EXISTE ?</h4>
        <button class="btn" onclick="cidadaoExistente()">ATUALIZAR PROPIEDADE</button>
    </div>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
</body>

</html>
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar-usuário</title>
    <link rel="stylesheet" href="./assets/css/cofigurar-usuario.css">
    <link rel="stylesheet" href="./assets/css/main.css">
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
    </header>
    <div class="sub-header">
        <small>Registo e identificação de viaturas</small>
        <div>
        <a class="btn" href="index.php">&#10094 voltar</a>
        </div>
    </div>
    <div class="targuet-list">
        <a href="#" target="_self" rel="noopener noreferrer"> Inicio &#10095</a>
        <a href="#" target="_self" rel="noopener noreferrer"> Configurar usuário </a>
    </div>
    <div class="content">
        <div class="content-left">
            <img src="./assets/dist/img/usingPhone.png" alt="">
        </div>
        <div class="content-right">
            <h1>Pesquisar usuario</h1>
            <p>Introdusa o nome ou número de técnico para configurar</p>
            <input class="input" type="search" name="usuario" id="usuario" oninput="pesquisarUsuarios()">
            <button class="btn" onclick="pesquisarUsuarios()">Pesquisar</button>
            <table  id="tabelaUsuarios">
                <thead>
                   <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nº técnico</th>
                        <th>Data Criação</th>
                        <th>Ação</th>
                   </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" id="modal" style="display:none">
        <div class="modal-card" id="modal-card">
            <h2 id="modal-tittle"><img id="modalicon" src="./assets/dist/img/info.png" alt=""><span>FINALIZADO</span></h2>
            <h4 id="modal-subtittle"></h4>
            <button class="modal-btn modal-btn-confirmar" id="btnConfirmar">Confirmar!</button>
            <button class="modal-btn modal-btn-cancelar" id="btnCancelar">Cancelar!</button>
        </div>
    </div>
    <div class="modal" id="modal2" style="display:none">
        <div class="modal-card" id="modal-card">
            <h2 id="modal-tittle2"><img id="modalicon2" src="./assets/dist/img/info.png" alt=""><span>FINALIZADO</span></h2>
            <h4 id="modal-subtittle2"></h4>
            <button class="modal-btn" onclick="document.getElementById('modal2').style='display:none;'" >OK</button>
        </div>
    </div>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>

    <script>
        // Função para buscar usuários via AJAX
        function pesquisarUsuarios() {
            var termo = document.getElementById("usuario").value;

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../scripts/pesquisar_user.php?usuario=" + termo, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("Resposta do servidor:", xhr.responseText); // Verifique os dados aqui
                    var dados = JSON.parse(xhr.responseText);
                    var tabela = document.getElementById("tabelaUsuarios").getElementsByTagName("tbody")[0];
                    tabela.innerHTML = ""; // Limpa a tabela antes de adicionar novos resultados

                    dados.forEach(function(usuario) {
                        var row = tabela.insertRow();
                        row.insertCell(0).innerHTML = usuario.id;
                        row.insertCell(1).innerHTML = usuario.username;
                        row.insertCell(2).innerHTML = usuario.email;
                        row.insertCell(3).innerHTML = usuario.tech_number;
                        row.insertCell(4).innerHTML = usuario.created_at;


                        var btnRecuperar = document.createElement("button");
                        btnRecuperar.innerText = "Recuperar";
                        btnRecuperar.classList = "btnGreen";
                        btnRecuperar.onclick = function() {
                            exibirModalRecuperar('yellow','icons8-erro.gif','Aviso','mensagem',usuario.id,usuario.username);

                        };
                        row.insertCell(5).appendChild(btnRecuperar);

                        // Cria o botão de Excluir
                        var btnExcluir = document.createElement("button");
                        btnExcluir.innerText = "Excluir";
                        btnExcluir.classList = "btnRed";
                        btnExcluir.onclick = function() {
                            exibirModalExcuir('yellow','icons8-erro.gif','Aviso','mensagem',usuario.id,usuario.username);

                        };
                        row.cells[5].appendChild(btnExcluir);
                        
                    });
                }
            };
            xhr.send();
        }

        function recuperarSenha(idUsuario) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../scripts/resetar_senha.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    //alert(xhr.responseText); // Mensagem do servidor
                    exibirModal('green','icons8-sucesso.gif','Sucesso',xhr.responseText);
                }
            };
            xhr.send("id=" + idUsuario);
        }

        function excluirUsuario(idUsuario) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../scripts/excluir_usuario.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    //alert(xhr.responseText); // Mensagem do servidor
                    exibirModal('green','icons8-sucesso.gif','Sucesso',xhr.responseText);
                    pesquisarUsuarios(); // Atualiza a lista de usuários
                }
            };
            xhr.send("id=" + idUsuario);
        }

        function exibirModalRecuperar(color,image,tittle,message,idUsuario,nomeUsuario){
            const modal = document.getElementById('modal'); 
            modal.style="display:flex";

            const modaltittle = document.getElementById('modal-tittle');
            modaltittle.style=`color:${color};`;
            modaltittle.firstElementChild.src="./assets/dist/img/"+image;
            modaltittle.lastElementChild.innerHTML=tittle;
                                        
            const modalsubtittle = document.getElementById('modal-subtittle');
            modalsubtittle.innerHTML='Deseja realmente recetar o usuario: '+nomeUsuario+' ?';

            const cofirmar = document.getElementById('btnConfirmar');
            const cancelar = document.getElementById('btnCancelar');
            cofirmar.onclick=function(){
                recuperarSenha(idUsuario)
                document.getElementById('modal').style='display:none';

            };
            cancelar.onclick=function(){
                document.getElementById('modal').style='display:none';
            };
        }

        function exibirModalExcuir(color,image,tittle,message,idUsuario,nomeUsuario){
            const modal = document.getElementById('modal'); 
            modal.style="display:flex";

            const modaltittle = document.getElementById('modal-tittle');
            modaltittle.style=`color:${color};`;
            modaltittle.firstElementChild.src="./assets/dist/img/"+image;
            modaltittle.lastElementChild.innerHTML=tittle;
                                        
            const modalsubtittle = document.getElementById('modal-subtittle');
            modalsubtittle.innerHTML='Deseja realmente excluir o usuario: '+nomeUsuario+' ?';

            const cofirmar = document.getElementById('btnConfirmar');
            const cancelar = document.getElementById('btnCancelar');
            cofirmar.onclick=function(){
                excluirUsuario(idUsuario)
                document.getElementById('modal').style='display:none';

            };
            cancelar.onclick=function(){
                document.getElementById('modal').style='display:none';
            };
        }
        function exibirModal(color,image,tittle,message){
            const modal = document.getElementById('modal2'); 
            modal.style="display:flex";

            const modaltittle = document.getElementById('modal-tittle2');
            modaltittle.style=`color:${color};`;
            modaltittle.firstElementChild.src="./assets/dist/img/"+image;
            modaltittle.lastElementChild.innerHTML=tittle;
                                        
            const modalsubtittle = document.getElementById('modal-subtittle2');
            modalsubtittle.innerHTML=message;
        }
    </script>
</body>
</html>
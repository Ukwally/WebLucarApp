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
    <title>Automoblista</title>
    <link rel="stylesheet" href="./assets/css/ver_automoblista.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <script>
        async function buscarDados() {
            const automoblista = document.getElementById('automoblista').value;
            const response = await fetch(`../scripts/ver_automoblista_script.php?Automoblista=${automoblista}`);
            const viatura = await response.json();
            //document.getElementById('resultadoHistorico').innerText = JSON.stringify(viatura, null, 2);
            document.querySelector('.nomeBIAutomoblista>p').innerHTML='NOME:';
            const dadosAutomoblista = viatura.historico[0];
            if (dadosAutomoblista) {
                document.querySelector('.nomeBIAutomoblista>p').innerHTML=`NOME: ${dadosAutomoblista["Nome"]}`;
            }
            if (dadosAutomoblista !== undefined) {                                
                const btnModalMultas = document.querySelector('#btnModalMultas');
                btnModalMultas.onclick=function(){
                    document.getElementById('modal').style='display:flex;'
                };

                const btnMultar = document.querySelector('#btnMultar');
                btnMultar.onclick= function(){
                    passarMulta(dadosAutomoblista["NumeroBI"])
                };

            }
            //inicio Totais
            const totalEmPosseViaturas = viatura.historico.filter(item=>item.DataFim ==='0000-00-00').length;
            document.getElementById('totalEmPosseViaturas').innerHTML= totalEmPosseViaturas;
            document.getElementById('totalHistorioViaturas').innerHTML= viatura.historico.length;
            document.getElementById('totalMultas').innerHTML= viatura.multas.length;
            //Fim totais
            const resultado = document.getElementById('resultadoHistorico');
            resultado.innerHTML = ''; 
            
            if (viatura.historico.length === 0) {
                resultado.innerHTML = '<p style="color:red">Nenhum dado encontrado.</p>';
                return;
            }

            const table = document.createElement('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');

            thead.innerHTML = `
                <tr>
                    <th>ID</th>
                    <th>Matriciula</th>
                    <th>Marca</th>
                    <th>Cor</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Data de Aquisição</th>
                    <th>Data de largada</th>
                </tr>
            `;
            table.appendChild(thead);

            viatura.historico.forEach(item => {
                const tr = document.createElement('tr');
                item.DataFim = item.DataFim === '0000-00-00' ? 'Em posse': item.DataFim;
                tr.innerHTML = `
                    <td>${item.Id}</td>
                    <td>${item.Matricola}</td>
                    <td>${item.Marca}</td>
                    <td>${item.cor}</td>
                    <td>${item.Modelo}</td>
                    <td>${item.Ano}</td>
                    <td>${item.DataInicio}</td>
                    <td>${item.DataFim} </td>
                `;
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            resultado.appendChild(table);
        }

        async function passarMulta(NumeroBI) {
            //const response = await fetch(`../scripts/passar_multa.php?Automoblista=${automoblista}`);
            const response = await fetch('../scripts/passar_multa.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    tipo: document.getElementById('tipoMulta').value,
                    dataEmissao:document.getElementById('dataEmissaoMulta').value,
                    cidadaoMultado: NumeroBI,
                })
            });
            
            const result = await response.json();

            if (result.success) {
                var color='green';
                var image='icons8-sucesso.gif';
                var tittle='Sucesso';
                var message='Multa registada com sucesso!';
                exibirModal(color,image,tittle,message);
            } else {
                var color='red';
                var image='icons8-erro.gif';
                var tittle='Erro';
                var message=`Erro ao registar multa: ${result.error}`;
                exibirModal(color,image,tittle,message);
            }

            function exibirModal(color,image,tittle,message){
                const modal = document.getElementById('modal'); 
                modal.style="display:flex";

                const modaltittle = document.getElementById('modal-tittle');
                modaltittle.style=`color:${color};`;
                modaltittle.firstElementChild.src="./assets/dist/img/"+image;
                modaltittle.lastElementChild.innerHTML=tittle;

                const modalsubtittle = document.getElementById('modal-subtittle');
                modalsubtittle.innerHTML=message;
                modalsubtittle.style='margin:;';

                document.getElementById('modalform').style='display:none;';
                document.getElementById('btnCancelar').style='display:none';
                document.getElementById('btnMultar').style='display:none';

                document.getElementById('btnOk').style='display:block';
            }

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
    <div class="row">
        <div class="col col1">
            <div class="card">
                <p>TOTAL DE VIATURAS EM POSSE </p>
                <i class="bi bi-broadcast-pin"></i>
                <strong id="totalEmPosseViaturas">0</strong>
            </div>
            <div class="card">
                <p>TOTAL HISTORICO DE VIATURAS POSSUÍDAS</p>
                <strong id="totalHistorioViaturas">0</strong>
            </div>
            <div class="card">
                <p>TOTAL DE MULTAS</p>
                <strong id="totalMultas">0</strong>
            </div>
            <div class="card">
                <p>ESTADO DA CARTA DE CONDUÇÃO</p>
                <strong>0</strong>
            </div>
        </div>
        <div class="col col2">
            <h1>PESQUISAR PELO AUTOMOBLISTA</h1>
            <span><p><small>DIGITE O NOME OU O BI DO AUTOMOBLISTA PARA PESQUISAR</small></p></span>
            <span><input class="inputPesquisar" type="search" id="automoblista"> <button class="btn" onclick="buscarDados()">Pesquisar</button></span>
            <div class="nomeBIAcaoAutomoblista">
                <span class="nomeBIAutomoblista">
                    <p>NOME: </p>
                </span>
                <span class="acaoAutomoblista"><button class="btn" id="btnModalMultas">Passar Multas</button><button class="btn" >Atualizar Carta</button></span>
            </div>

            <h4>HISTÓRICO DE VIATURAS DO AUTOMOBLISTA</h4>

            <pre id="resultadoHistorico"></pre>
        </div>
    </div>
    <div class="modal" id="modal" style="display:none;">
        <div class="modal-card">
            <h2 id="modal-tittle"><img id="modalicon" src="./assets/dist/img/icons8-instalando-atualizações.gif" alt=""><span>PASSAR MULTA</span></h2>
            <h4 id="modal-subtittle" style="margin:3px">CIDADÃO:</h4>
            <div class="form" id="modalform">
                <div>
                    <span class="spanPaswordAntiga">
                        <label for=""><small>TIPO</small></label>
                        <input type="text" name="" id="tipoMulta">
                    </span>
                    <span class="spanPasswordNova">
                        <label for=""><small>DATA DE EMICÃO</small></label>
                        <input type="date" name="" id="dataEmissaoMulta">
                    </span>
                </div>
                <div>
                    <button class="modal-btn modal-btn-cancelar" id='btnCancelar' onclick="document.getElementById('modal').style='display:none;'">Cancelar!</button>
                    <button class="modal-btn modal-btn-confirmar" id="btnMultar">Confirmar!</button>
                </div>
            </div>
            <button class="modal-btn" id='btnOk' style="display:none; text-align:center" onclick="document.getElementById('modal').style='display:none;'">OK</button>
        </div>
    </div>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
    <script src="./assets/js/apexcharts.min.js"></script>
</body>

</html>
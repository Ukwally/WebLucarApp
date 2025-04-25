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
    <title>Visualizar Dados</title>
    <link rel="stylesheet" href="../public/assets/css/vizualizar.css">
    <link rel="stylesheet" href="../public/assets/css/main.css">
    <style>
        #resultadoDadosV{display: flex; align-items: center; height: 100%;}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tbody tr{background-color: rgb(201, 216, 221);}
        tbody tr:nth-child(even){background-color:rgb(157, 181, 187);}
        .maincard{
            display: flex;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px 20px;
            margin:5px 20px;
            box-shadow: 0px 2px 7px rgba(0, 0, 0, 0.36);
            max-width: 300px;
            max-height: 200px;
            /*background-color:#8c989b6e;*/
            background-color:rgba(104, 146, 168, 0.49);
            color: whitesmoke;
        }
        .card h2 {
            margin-top: 0;
        }
    </style>
    <script>
        
        async function buscarDadosViatura() {
            const matricula = document.getElementById('matriculaDadosV').value;

            //CORRETO var regex = /^[A-Z]{2}-\d{2}-(\d{2}-)?[A-Z]{2}$/;
            var regex = /^[A-Z]{2}-\d{3}-(\d{2}-)?[A-Z]{2}$/; //ERRADO PROVISÓRIO POR CAUSA DO LD-404-AO
            if (!regex.test(matricula)) {
                exibirModal('red','icons8-erro.gif','Erro','Formáto de matrícola inválido');
                document.getElementById("matriculaDadosV").value='';
                document.getElementById("matriculaDadosV").innerHTML='';
                return; // Não prossegue com a requisição 
            }
            const response = await fetch(`../scripts/obter_viatura.php?Matricula=${matricula}`);
            const viatura = await response.json();
            //document.getElementById('resultadoDadosV').innerText = JSON.stringify(viatura, null, 2);
            // Exibir os dados em card que substitui a linha de código comentada acima que por sua vez exibe os dados no <pre id="resultadoDadosV" class="cardBody"></pre>            
            const resultado = document.getElementById('resultadoDadosV');
            resultado.innerHTML = ''; // Limpar resultados anteriores

            //INICIO VERIFICAR VIATURA ROUBADA
            const erromsg = document.getElementById('erro-msg');
            erromsg.lastChild.innerHTML = '';
            erromsg.style.display = 'none';

            // Buscar status de roubo
            const respRoubada = await fetch(`../externo-api/viaturasRoubadasAPI.php?Matricula=${matricula}`);
            const statusRoubada = await respRoubada.json();
            const eRoubada = statusRoubada.roubada;

            if (eRoubada) {
                erromsg.lastChild.innerHTML = `VIATURA ROUBADA`;
                erromsg.style.display = 'flex';
            }
            //FIM VERIFICAR VIATURA ROUBADA

            /*  pesquisar como divdir em 2 cards e ver se vai ser igual a como eu fiz abaixo
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <h2>${viatura.Nome}</h2>
                    <p><strong>Matricola:</strong> ${viatura.Matricola}</p>
                    <p><strong>Marca:</strong> ${viatura.Marca}</p>
                    <p><strong>Modelo:</strong> ${viatura.Modelo}</p>
                    <p><strong>Ano:</strong> ${viatura.Ano}</p>
                    <p><strong>NumeroBI:</strong> ${viatura.NumeroBI}</p>
                    <p><strong>Nome:</strong> ${viatura.Nome}</p>
                    <p><strong>Endereco:</strong> ${viatura.Endereco}</p>
                    <p><strong>DataNascimento:</strong> ${viatura.DataNascimento}</p>
                `;
                resultado.appendChild(card);
            */

            if (viatura.Matricola === undefined || viatura.length === 0)  {
                resultado.innerHTML = '<p style="color:red">Nenhum dado encontrado.</p>';
                return;
            }
            
            const card = document.createElement('div');
            card.className = 'maincard';
            card.innerHTML = `
                <div class = "card">
                <p>PROPRIETÁRIO ATUAL:</p>
                <h2>${viatura.Nome}</h2>
                <p><strong>NumeroBI:</strong> ${viatura.NumeroBI}</p>
                <p><strong>Endereco:</strong> ${viatura.Endereco}</p>
                <p><strong>DataNascimento:</strong> ${viatura.DataNascimento}</p>
                </div>

                <div class = "card">
                <p>DADOS DA VIATURA</p>
                <h2>${viatura.Matricola}</h2>
                <p><strong>Ano:</strong> ${viatura.Ano}</p>
                <p><strong>Marca:</strong> ${viatura.Marca}</p>
                <p><strong>NumeroMotor:</strong> ${viatura.NumeroMotor}</p>
                </div>

                <div class = "card">
                <p><strong>MedidaPmeumaticos:</strong> ${viatura.MedidaPmeumaticos}</p>
                <p><strong>Servico:</strong> ${viatura.Servico}</p>
                <p><strong>Lotacao:</strong> ${viatura.Lotacao}</p>
                <p><strong>Cilindrada:</strong> ${viatura.Cilindrada}</p>
                <p><strong>NumeroCilindros:</strong> ${viatura.NumeroCilindros}</p>
                </div>

                <div class = "card">
                <p><strong>Combustivel:</strong> ${viatura.Combustivel}</p>
                <p><strong>PesoBruto:</strong> ${viatura.PesoBruto}</p>
                <p><strong>Tara:</strong> ${viatura.Tara}</p>
                <p><strong>NumeroQuadro:</strong> ${viatura.NumeroQuadro}</p>
                </div>
            `;
            resultado.appendChild(card);

        }

        async function buscarHistoricoPropietarios() {
            const matricula = document.getElementById('matriculaHistorico').value;

            //CORRETO var regex = /^[A-Z]{2}-\d{2}-(\d{2}-)?[A-Z]{2}$/;
            var regex = /^[A-Z]{2}-\d{3}-(\d{2}-)?[A-Z]{2}$/; //ERRADO PROVISÓRIO POR CAUSA DO LD-404-AO            
            if (!regex.test(matricula)) {
                exibirModal('red','icons8-erro.gif','Erro','Formáto de matrícola inválido');
                document.getElementById("matriculaHistorico").value='';
                document.getElementById("matriculaHistorico").innerHTML='';
                return; // Não prossegue com a requisição 
            }

            const response = await fetch(`../scripts/obter_historico.php?Matricula=${matricula}`);
            const viatura = await response.json();
            //document.getElementById('resultadoHistorico').innerText = JSON.stringify(viatura, null, 2);

            // Exibir os dados em tabela que substitui a linha de código comentada acima que por sua vez exibe os dados no <pre id="resultadoHistorico" class="cardBody"></pre>
            const resultado = document.getElementById('resultadoHistorico');
            resultado.innerHTML = ''; // Limpar resultados anteriores

            if (viatura.length === 0) {
                resultado.innerHTML = '<p style="color:red">Nenhum dado encontrado.</p>';
                return;
            }

            const table = document.createElement('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');

            thead.innerHTML = `
                <tr>
                    <th>Matricula</th>
                    <th>Proprietários</th>
                    <th>Número do BI</th>
                    <th>Endereco</th>
                    <th>DataInicio</th>
                    <th>DataFim</th>
                </tr>
            `;
            table.appendChild(thead);

            viatura.forEach(item => {
                const tr = document.createElement('tr');
                item.DataFim = item.DataFim === '0000-00-00' ? 'Em posse': item.DataFim;
                tr.innerHTML = `
                    <td>${item.Matricola}</td>
                    <td>${item.Nome}</td>
                    <td>${item.NumeroBI}</td>
                    <td>${item.Endereco}</td>
                    <td>${item.DataInicio}</td>
                    <td>${item.DataFim}</td>
                `;
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            resultado.appendChild(table);
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
</head>
<body>
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
   
    <div class="content">
        <div class="content-top">
            <div>
                <div class="content-tittle"><img src="./assets/dist/img/car-badge-48.png" alt=""><h1>Ver Dados da Viatura</h1></div>
                <h4 class="content-subtittle">Introduza uma matrícula de viatura para ver dados.</h4>
                <input type="text" id="matriculaDadosV" placeholder="Matrícula" class="input" />
                <button onclick="buscarDadosViatura()" class="btn">Buscar Dados</button>
            </div>
            <div>
                <!--pre id="resultadoDadosV"></pre-->
                <div id="resultadoDadosV"></div>
            </div>

        </div>

        <hr>
        <div class="content-bottom">
            <div class="erro" id="erro-msg" style="display: none;"> <img src="../public/assets/dist/img/icons8-erro.gif" alt=""><span></span></div>
            <div class="content-tittle"><img src="./assets/dist/img/car-badge-48.png" alt=""><h1>Ver Historico de Propietarios da Viatura</h1></div>
            <h4 class="content-subtittle">Introduza uma matrícula de viatura para ver histórico de propietários</h4>
            <input type="text" id="matriculaHistorico" placeholder="Matrícula" class="input" />
            <button onclick="buscarHistoricoPropietarios()" class="btn">Buscar Dados</button>
            <!--pre id="resultadoHistorico" class="cardBody"></pre-->
            <div id="resultadoHistorico"></div>
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
</body>
</html>

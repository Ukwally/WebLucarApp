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
            const response = await fetch(`../scripts/obter_viatura.php?Matricula=${matricula}`);
            const viatura = await response.json();
            //document.getElementById('resultadoDadosV').innerText = JSON.stringify(viatura, null, 2);
            
            // Exibir os dados em card que substitui a linha de código comentada acima que por sua vez exibe os dados no <pre id="resultadoDadosV" class="cardBody"></pre>            
            const resultado = document.getElementById('resultadoDadosV');
            resultado.innerHTML = ''; // Limpar resultados anteriores

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
                </div>
            `;
            resultado.appendChild(card);

        }

        async function buscarHistoricoPropietarios() {
            const matricula = document.getElementById('matriculaHistorico').value;
            const response = await fetch(`../scripts/obter_historico.php?Matricula=${matricula}`);
            const viatura = await response.json();
            //document.getElementById('resultadoHistorico').innerText = JSON.stringify(viatura, null, 2);

            // Exibir os dados em tabela que substitui a linha de código comentada acima que por sua vez exibe os dados no <pre id="resultadoHistorico" class="cardBody"></pre>
            const resultado = document.getElementById('resultadoHistorico');
            resultado.innerHTML = ''; // Limpar resultados anteriores

            if (viatura.length === 0) {
                resultado.innerHTML = '<p>Nenhum dado encontrado.</p>';
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
                <div class="content-tittle"><img src="./assets/dist/img/car-badge-48.png" alt=""><h1>Visualizar Dados da Viatura</h1></div>
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
            <div class="content-tittle"><img src="./assets/dist/img/car-badge-48.png" alt=""><h1>Visualizar Historico de Propietarios da Viatura</h1></div>
            <h4 class="content-subtittle">Introduza uma matrícula de viatura para ver histórico de propietários</h4>
            <input type="text" id="matriculaHistorico" placeholder="Matrícula" class="input" />
            <button onclick="buscarHistoricoPropietarios()" class="btn">Buscar Dados</button>
            <!--pre id="resultadoHistorico" class="cardBody"></pre-->
            <div id="resultadoHistorico"></div>
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

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
    <title>dashboard</title>
    <link rel="stylesheet" href="./assets/css/dashboard.css">
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
                    <h3><?php echo $_SESSION['username'] ?></h3>
                    <p><?php echo $_SESSION['nivel'] ?></p>
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
        <div class="card">
            <p>TOTAL DE VIATURAS CADASTRADAS ( <?php echo date('Y') ?> )</p>
            <i class="bi bi-broadcast-pin"></i>
            <strong id="totalViaturas">Carregando...</strong>
        </div>
        <div class="card">
            <p>TOTAL DE CARTAS EXPIRADAS ( <?php echo date('Y') ?> )</p>
            <strong id="totalCartasExpiradas">Carregando...</strong>
        </div>
        <div class="card">
            <p>TOTAL DE MULTAS ( <?php echo date('Y') ?> )</p>
            <strong id="totalMultas">Carregando...</strong>
        </div>
        <div class="card">
            <!--p>TOTAL DE VIATURAS ROUBADAS ( )</p-->
            <p>MULTAS LIQUIDAS ( <?php echo date('Y') ?> )</p>
            <strong id="totalMultasLiquidadas">Carregando...</strong>
        </div>




    </div>

    <div class="row">
        <div class="col col1">
            <!--Inicio line chart -->
            <h4 class="card-title">Relatórios <span> / Semanais </span> </h4>
            <div id="reportsChart"></div>
            <!--Fim line chart -->
        </div>

        <div class="col col2">
            <!--Inicio circle chart -->
            <h4 class="card-title">MULTAS</h4>
            <canvas id="myDoughnutChart"></canvas>
            <!--Fim circle chart -->
        </div>
        <div class="col col3">
            <h4>ULTIMAS ADIÇÕES</h4>
            <table>
                <thead>
                    <tr>
                        <th>Matricola</th>
                        <th>Data de adição</th>
                    </tr>
                </thead>
                <tbody id="vehicleTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
    <!--SCRIPT DADOS CADS -->
    <script>
        // Função para buscar os totais e preencher os cards
        function fetchTotals() {
            fetch('../scripts/dashboard_script_cards.php') // Chama o script que retorna os totais
                .then(response => response.json())
                .then(data => {
                    // Preenche os cards com os totais
                    document.getElementById('totalViaturas').textContent = data.total_viaturas;
                    document.getElementById('totalCartasExpiradas').textContent = data.total_cartas_expiradas;
                    document.getElementById('totalMultas').textContent = data.total_multas;
                    document.getElementById('totalMultasLiquidadas').textContent = data.total_multas_liquidadas;
                })
                .catch(error => console.error('Erro ao carregar os totais:', error));
        }
        // Chama a função assim que a página for carregada
        document.addEventListener('DOMContentLoaded', fetchTotals);
    </script>


    <!-- SCRIPTS PARA O LINE CHART APEX ABAIXO-->
    <script src="./assets/js/apexcharts.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetch('../scripts/dashboard_script_lineChart.php')
                .then(response => response.json())
                .then(data => {
                    const chartOptions = {
                        series: [{
                            name: 'Viaturas adicionadas',
                            data: data.viaturasAdicionadas,
                        }, {
                            name: 'Viaturas roubadas',
                            data: data.viaturasRoubadas
                        }, {
                            name: 'Cartas expiradas',
                            data: data.cartasExpiradas
                        }],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#4987aa', '#2eca6a', '#ff771d'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            categories: data.labels, // ["Sat", "Sun", "Mon", ...]
                            labels: {
                                rotate: -45
                            },
                            title: {
                                text: 'Últimos 7 dias'
                            }
                        },
                        tooltip: {
                            x: {
                                show: true
                            },
                        }
                    };

                    new ApexCharts(document.querySelector("#reportsChart"), chartOptions).render();
                })
                .catch(error => {
                    console.error('Erro ao carregar dados do dashboard:', error);
                });
        });
    </script>
    <!-- script VERSÃO ORIGINAL LINE CHART APEX>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Viaturas adicionadas',
                    data: [31, 40, 28, 51, 42, 82, 56],
                }, {
                    name: 'Multas',
                    data: [11, 32, 45, 32, 34, 52, 41]
                }, {
                    name: 'Cartas expiradas',
                    data: [15, 11, 32, 18, 9, 24, 11]
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                markers: {
                    size: 4
                },
                colors: ['#4987aa', '#2eca6a', '#ff771d'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                        "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                        "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                        "2018-09-19T06:30:00.000Z"
                    ]
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                }
            }).render();
        });
    </script-->

    <!--SCRIPT PARA O CHART CIRCULO ABAIXO -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../scripts/dashboard_script_doughnutChart.php')
                .then(response => response.json())
                .then(data => {
                    // Organizar os dados na ordem: Pago, Vencido, Pendente
                    const chartData = [
                        data['Pago'] || 0,
                        data['Vencido'] || 0,
                        data['Pendente'] || 0
                    ];

                    var ctx = document.getElementById('myDoughnutChart').getContext('2d');
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Liquidadas', 'Vencidas', 'Pendentes'],
                            datasets: [{
                                label: 'Distribuição de Multas',
                                data: chartData,
                                backgroundColor: ['#00803a', '#36A2EB', '#5c7ea2'],
                                hoverBackgroundColor: ['#00b44b', '#4dc3ff', '#6c91b8'],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar dados do gráfico:', error);
                });
        });
    </script>
    <!-- SCRIPTS VERSÃO ORIGINAL CHART CIRCULO>
    <script>
        var ctx = document.getElementById('myDoughnutChart').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut', // Tipo de gráfico: rosca
            data: {
                labels: ['Liquidas', 'Vencidas', 'Pendentes'], // Rótulos
                datasets: [{
                    label: 'Distribuição',
                    data: [30, 40, 30], // Valores de cada categoria
                    backgroundColor: ['#00803a', '#36A2EB', '#5c7ea2'], // Cores
                    hoverBackgroundColor: ['#00803a', '#36A2EB', '#5c7ea2'], // Cores ao passar o mouse
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script -->

    <!--SCRIPT PARA TABELA ULTIMA ADIÇÃO -->
    <script>
        // Função para buscar as últimas viaturas e atualizar a tabela
        function fetchLatestVehicles() {
            fetch('../scripts/dashboard_script_tabela.php') // Chama o script que retorna as viaturas
                .then(response => response.json())
                .then(data => {
                    // Se não houver erro, atualiza a tabela
                    if (!data.error) {
                        const tableBody = document.getElementById('vehicleTableBody');
                        tableBody.innerHTML = ''; // Limpa a tabela antes de inserir os novos dados

                        // Itera sobre as viaturas retornadas e adiciona à tabela
                        data.forEach(vehicle => {
                            const row = document.createElement('tr');

                            const cellMatricola = document.createElement('td');
                            cellMatricola.textContent = vehicle.Matricola;

                            const cellCreatedAt = document.createElement('td');
                            const createdAtDate = new Date(vehicle.created_at);
                            const formattedDate = createdAtDate.toLocaleString(); // Formata a data
                            cellCreatedAt.textContent = formattedDate;

                            row.appendChild(cellMatricola);
                            row.appendChild(cellCreatedAt);
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => console.error('Erro ao carregar viaturas:', error));
        }
        // Chama a função assim que a página for carregada
        document.addEventListener('DOMContentLoaded', fetchLatestVehicles);
        // Atualiza a tabela a cada 30 segundos (30000 milissegundos)
        setInterval(fetchLatestVehicles, 30000);
    </script>

</body>

</html>
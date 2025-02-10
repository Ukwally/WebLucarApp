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
    <div class="row">
        <div class="card">
            <p>TOTAL DE VIATURAS CADASTRADAS ( <?php echo date('Y')?> )</p>
            <i class="bi bi-broadcast-pin"></i>
            <strong>207</strong>
        </div>
        <div class="card">
            <p>TOTAL DE CARTAS EXPIRADAS ( <?php echo date('Y')?> )</p>
            <strong>81</strong>
        </div>
        <div class="card">
            <p>TOTAL DE MULTAS ( <?php echo date('Y')?> )</p>
            <strong>52</strong>
        </div>
        <div class="card">
            <p>TOTAL DE VIATURAS ROUBADAS ( <?php echo date('Y')?> )</p>
            <strong>35</strong>
        </div>
    </div>

    <div class="row">
        <div class="col col1">
            <!--Inicio gráfico -->
            <h4 class="card-title">Relatórios <span> / Semanais </span> </h4>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
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
            </script>
            <!-- End Line Chart -->
        </div>
        <!-- Fim grafico -->

        <div class="col col2"> RODA</div>
        <div class="col col3">
            <h4>ULTIMAS ADIÇÕES</h4>
            <table>
                <thead>
                    <tr>
                        <th>Matricola</th>
                        <th>Data de adição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>LD-404-AO</td>
                        <td>LD-404-AO</td>
                    </tr>
                    <tr>
                        <td>LD-404-AO</td>
                        <td>LD-404-AO</td>
                    </tr>
                    <tr>
                        <td>LD-404-AO</td>
                        <td>LD-404-AO</td>
                    </tr>
                    <tr>
                        <td>LD-404-AO</td>
                        <td>LD-404-AO</td>
                    </tr>
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
    <script src="./assets/js/apexcharts.min.js"></script>
</body>

</html>
<?php
    session_start();
    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php'); // Redireciona para a página de login se não estiver autenticado
        exit;
    }
    $isAdmin = isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'Administrador';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/main.css">
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
        <div class="sub-header-left">
            <a href="dashboard.php">DASHBOARD</a>
            <div class="menu" onclick="mostrarMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div class="userdata">
        <ul class="hidden aparecerY" id="menu-data">
            <li><b>DADOS DO USUÁRIO	</b></li>
            <li><b>Id de usuário: </b> <?php echo $_SESSION['user_id']?></li>
            <li><b>E-mail: </b> <?php echo $_SESSION['email']?></li>
            <li><b>Número de técnico: </b> <?php echo $_SESSION['tech_number']?></li>
            <li><button>ALTERAR PASSWORD</button></li>
        </ul>
    </div>
    <div class="targuet-list">
        <a href="#" target="_self" rel="noopener noreferrer">Inicio</a>
    </div>
    <div class="welcome">
        <h1>Bem Vindo ao Lucar!</h1> 
        <h4>Escolha uma opção para começar...</h4> 
    </div>
    <div class="content">
        <a class="a-inicial" href="cadastrar.php">Nova Propiedade</a>
        <a href="atualizar_propiedade.php">Atualizar Propietário</a>
        <a class="a-final" href="visualizar_dados.php">Visualizar Dados</a>
    </div>
    <?php if($isAdmin) : ?>
    <div class="content2" style="margin-top: 40px;">
        <div class="img-side">
            <img src="../public/assets/dist/img/gerente.png" alt="">
        </div>
        <div class="txt-side">
            <p>Ferramentas do<br><b>ADMINISTRADOR</b></p>
        </div>
        <div class="btn-side">
            <a class="a-inicial" href="registar_usuario.php">Registrar Usuário</a>
            <a class="a-final" href="configurar_usuario.php">Cofigurar Usuário</a>
        </div>  
    </div>
    <?php endif?>
    
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
    <script src="./assets/js/index.js"></script>
</body>
</html
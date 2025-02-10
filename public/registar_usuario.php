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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="./assets/css/cadastro.css">
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
    <div class="row float-container">
    <form method="POST" action="../scripts/registar_usuario_script.php">
        <div class="card">
            <div class="card-header">
                <img src="./assets/dist/img/adicionar-usuario.png" alt="">
                <h3 class="card-tittle">CADASTRAR NOVO USUÁRIO</h3>
            </div>
            <div class="card-body">
                <label for="username"><span class="required">* </span> Nome de Usuário:</label>
                <input type="text" name="username" id="username" required class="input input1"><br>   

                <label for="password"><span class="required">* </span> Senha:</label>
                <input type="password" name="password" id="password" required class="input input1"><br>

                <label for="email"><span class="required">* </span> E-mail:</label>
                <input type="email" name="email" id="email" required class="input input1"><br>

                <label for="tech_number"><span class="required">* </span> Número do Técnico:</label>
                <input type="number" name="tech_number" id="tech_number" required class="input input1"><br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn">Registrar</button>
            </div>
        </div>
    </form>
    </di>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
</body>
</html>

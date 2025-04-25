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
    <link rel="stylesheet" href="../public/assets/css/pesquisar_viatura.css">
    <link rel="stylesheet" href="../public/assets/css/main.css">
    <style>

    </style>
</head>

<body>
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

    <div class="content">

    </div>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
</body>

</html>
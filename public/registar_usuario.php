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
    <div class="row float-container">
        <form method="POST" action="../scripts/registar_usuario_script.php">
        <div class="card">
            <div class="card-header">
                <img src="./assets/dist/img/adicionar-usuario.png" alt="">
                <h3 class="card-tittle">CADASTRAR NOVO USUÁRIO</h3>
            </div>
            <div class="card-body">
                <label for="username"><span class="required">* </span> Nome de Usuário:</label>
                <input type="text" name="username" id="username"  class="input input1"><br>   

                <label for="password"><span class="required">* </span> Senha:</label>
                <input type="password" name="password" id="password"  class="input input1"><br>

                <label for="email"><span class="required">* </span> E-mail:</label>
                <input type="email" name="email" id="email"  class="input input1"><br>

                <label for="tech_number"><span class="required">* </span> Número do Técnico:</label>
                <input type="number" name="tech_number" id="tech_number"  class="input input1"><br>

                <label for="numeroBI"><span class="required">* </span> Número do BI:</label>
                <input type="text" name="numeroBI" id="numeroBI"  class="input input1"><br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn">Registrar</button>
            </div>
        </div>
        </form>
        <?php if(isset($_SESSION['erro'])):?>
        <div class="modal" id="modal">
            <div class="modal-card">
                <h2 id="modal-tittle" style="color:red"><img id="modalicon" src="./assets/dist/img/icons8-erro.gif" alt=""><span>Erro</span></h2>
                <h4 id="modal-subtittle"><?php echo $_SESSION['erro']; ?></h4>
                <button class="modal-btn" onclick="document.getElementById('modal').style='display:none'">Ok</button>
            </div>
        </div>
        <?php unset($_SESSION['erro']);  endif?>

        <?php if(isset($_SESSION['sucesso'])):?>
        <div class="modal" id="modal2">
            <div class="modal-card">
                <h2 id="modal-tittle" style="color:green"><img id="modalicon" src="./assets/dist/img/icons8-sucesso.gif" alt=""><span>Sucesso</span></h2>
                <h4 id="modal-subtittle"><?php echo $_SESSION['sucesso']; ?></h4>
                <button class="modal-btn" onclick="document.getElementById('modal2').style='display:none'">Ok</button>
            </div>
        </div>
        <?php unset($_SESSION['sucesso']);  endif?>

    </di>
    <div class="div-footer">
        <p>Lucar 2024 - Direitos reservados</p>
        <form action="../scripts/logout.php" method="post">
            <button type="submit"> Logout <img src="./assets/dist/img/logout2.png" alt="Logout"></button>
        </form>
    </div>
</body>
</html>

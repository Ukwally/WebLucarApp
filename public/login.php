<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <div class="content">
        <div class="section-left">
            <h1 class="icon-text">LUCAR</h1>
            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
        </div>
        <div class="section-right">
            <div class="FormLogin">
                <div class="form-set">
                    <P class="texto-form"><span class="seta-voltar">&#10096</span> Voltar</P>
                    <div class=" texto-form texto-destacado"> Bem-Vindo!</div>
                    <div class=" texto-form"> Logar Como Administrador ou técnico</div>
                    <form action="../scripts/login_script.php" method="post">
                        <label for="tech_number">ID</label>
                        <input type="text" name="tech_number">
                        <label for="password">Password</label>
                        <input type="password" name="password">
                        <button type="submit">Login</button>
                        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                        <a href="index.php">Esqueçeu ?</a>
                    </form>
                    <?php if (!empty($error)): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>


                    <div class="formaDeLogin">
                        <p>Logar com:</p>
                        <a href="">Google</a>   
                    </div>
               </div> 
            </div>
        </div>
    </div> 
</body>
</html>
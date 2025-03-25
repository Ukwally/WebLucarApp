<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $tech_number = $_POST['tech_number'];
    $numeroBI = $_POST['numeroBI'];

    $erro;
    $erroNome = $erroPassword = $erroTechNumber = "";


    //if (!preg_match("/^[a-zA-Z-' ]*$/",$username)) {
    //    $erroNome="Apenas letras e espaços em branco";
    //}
   
    // Entre 8 e 16 caracteres, pelo menos 1 maiúscula, 1 minúscula, 1 número e 1 caractere especial ninimo 8 e maximo 16
    // $padrao = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,16}$/";

    if (empty($username) || empty($password) || empty($email) || empty($tech_number) || empty($numeroBI)) {
        $erro='Preencha todos os campos obrigatórios';
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $erro='email inválido';
        }else{    
            // Cria um hash seguro da senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Verifica se o e-mail ou número de técnico já existem
            $sql = "SELECT id FROM usuarios WHERE email = :email OR tech_number = :tech_number";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':tech_number', $tech_number, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Se o e-mail ou número de técnico já estiver em uso, exibe um erro
                $erro='E-mail ou número de técnico já estão em uso';

            } else {
                // Se os dados não estiverem em uso, registra o novo usuário
                $sql = "INSERT INTO usuarios (username, password, email, tech_number,numeroBI) VALUES (:username, :password, :email, :tech_number, :numeroBI)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':tech_number', $tech_number, PDO::PARAM_STR);
                $stmt->bindParam(':numeroBI', $numeroBI, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $_SESSION['sucesso']='Usuário registrado com sucesso!';
                    header('Location:../public/registar_usuario.php');                   
                } else {
                    $erro='Erro ao registrar o usuário.';
                }
            }
        }

    }   
    if (!empty($erro)) {
        $_SESSION['erro']=$erro;
        header('Location:../public/registar_usuario.php');
    }    
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
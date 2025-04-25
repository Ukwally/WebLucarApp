<?php
session_start();
require_once 'db.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $tech_number = $_POST['tech_number'] ?? ''; // Usando null coalescing operator
    $password = $_POST['password'] ?? ''; // Usando null coalescing operator

    if (empty($tech_number) || empty($password)) {

        $erro = 'Por favor, preencha ambos os campos.';

    } else {

        // Preparar a consulta SQL para verificar o usuário
        $sql = "SELECT id, username, password, nivel, email, numeroBI FROM usuarios WHERE tech_number = :tech_number LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tech_number', $tech_number, PDO::PARAM_STR);
        
        // Executa a consulta
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha é válida
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; 
            $_SESSION['nivel'] = $user['nivel']; 
            $_SESSION['email'] = $user['email']; 
            $_SESSION['numeroBI'] = $user['numeroBI']; 
            $_SESSION['tech_number'] = $tech_number; 

            // Redireciona para a página inicial (index.php)
            header('Location:../public/index.php');
            exit;
        } else {
            $erro = 'Credenciais erradas!';
        }

    }

    if (!empty($erro)) {
        $_SESSION['erro']=$erro;
        header('Location:../public/login.php');
    }

}
?>

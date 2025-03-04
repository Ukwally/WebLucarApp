<?php
session_start();
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $tech_number = $_POST['tech_number'] ?? ''; // Usando null coalescing operator
    $password = $_POST['password'] ?? ''; // Usando null coalescing operator

    if (empty($tech_number) || empty($password)) {
        echo 'Por favor, preencha ambos os campos';
    } else {

        // Preparar a consulta SQL para verificar o usuário
        $sql = "SELECT id, username, password, nivel, email FROM usuarios WHERE tech_number = :tech_number LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tech_number', $tech_number, PDO::PARAM_STR);
        
        // Executa a consulta
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha é válida
        if ($user && password_verify($password, $user['password'])) {
            // Se as credenciais forem válidas, inicia a sessão
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
            $_SESSION['username'] = $user['username']; // Armazena o nome de usuário
            $_SESSION['nivel'] = $user['nivel']; // Armazena o nome de usuário
            $_SESSION['email'] = $user['email']; // Armazena o nome de usuário
            $_SESSION['tech_number'] = $tech_number; // Armazena o nome de usuário

            // Redireciona para a página inicial (index.php)
            header('Location:../public/index.php');
            exit;
        } else {
            // Se as credenciais estiverem erradas, exibe um erro
            //$error = 'Usuário ou senha inválidos.';
            echo 'credenciais errados';
        }

    }


}
?>

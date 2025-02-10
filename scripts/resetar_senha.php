<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do usuário foi enviado e se é válido
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']); // Garante que o ID seja um número inteiro

        try {
            /*
            function gerarSenha($tamanho = 8) {
                $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*';
                return substr(str_shuffle($caracteres), 0, $tamanho);
            }
            $novaSenha = gerarSenha(); */
            

            // Define a nova senha (por exemplo, uma senha padrão ou gerada aleatoriamente)

            $novaSenha = 'senhaPadrao123'; // Substitua por sua lógica de geração
            $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT); // Hash da nova senha

            // Prepara a consulta para atualizar a senha
            $stmt = $pdo->prepare("UPDATE usuarios SET password = :senha WHERE id = :id");
            $stmt->bindParam(':senha', $hashSenha);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "A senha do usuário com ID $id foi redefinida para: $novaSenha";
            } else {
                echo "Erro ao redefinir a senha.";
            }
        } catch (PDOException $e) {
            echo "Erro ao executar a redefinição de senha: " . $e->getMessage();
        }
    } else {
        echo "ID de usuário inválido ou não fornecido.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>

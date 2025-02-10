<?php
// Inclui o arquivo de conexão
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do usuário foi enviado e se é válido
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']); // Garante que o ID seja um número inteiro

        try {
            // Prepara a consulta para excluir o usuário
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Usuário com ID $id foi excluído com sucesso.";
            } else {
                echo "Erro ao excluir o usuário.";
            }
        } catch (PDOException $e) {
            echo "Erro ao executar a exclusão: " . $e->getMessage();
        }
    } else {
        echo "ID de usuário inválido ou não fornecido.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>

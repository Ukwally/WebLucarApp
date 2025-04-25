<?php
include 'db.php';

header('Content-Type: application/json');

// Consulta para contar as multas por status
$sql = "
    SELECT status, COUNT(*) as total
    FROM multas
    GROUP BY status
";

try {
    // Executa a consulta usando PDO
    $stmt = $pdo->query($sql);

    // Inicializa as contagens com zero
    $data = [
        'Pago' => 0,
        'Vencido' => 0,
        'Pendente' => 0,
    ];

    // Preenche as contagens de acordo com os resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['status']] = (int)$row['total'];
    }

    // Retorna os dados em formato JSON
    echo json_encode($data);
} catch (PDOException $e) {
    // Caso haja algum erro, exibe uma mensagem
    echo json_encode(['error' => 'Erro ao executar a consulta: ' . $e->getMessage()]);
}
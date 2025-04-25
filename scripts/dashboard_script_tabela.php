<?php
include 'db.php';

header('Content-Type: application/json');

// Consulta SQL para pegar as últimas 5 viaturas
$sql = "
    SELECT Matricola, created_at
    FROM viatura
    ORDER BY created_at DESC
    LIMIT 5
";

try {
    // Executa a consulta usando PDO
    $stmt = $pdo->query($sql);

    // Inicializa um array para armazenar os dados
    $vehicles = [];

    // Preenche o array com as últimas 5 viaturas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $vehicles[] = [
            'Matricola' => $row['Matricola'],
            'created_at' => $row['created_at'],
        ];
    }

    // Retorna os dados como JSON
    echo json_encode($vehicles);
} catch (PDOException $e) {
    // Caso ocorra algum erro na consulta
    echo json_encode(['error' => 'Erro ao buscar viaturas: ' . $e->getMessage()]);
}
?>

<?php
include 'db.php';

$Matricola = $_POST['Matricola'];
$NumeroBI = $_POST['NumeroBI'];
$DataInicio = $_POST['DataInicio'];
$DataFim = $_POST['DataFim'];

try {
    // Primeira etapa: Atualizar o registro existente, se houver
    $updateSql = "UPDATE propriedade SET DataFim = :DataInicio WHERE Matricola = :Matricola AND (DataFim IS NULL OR DataFim = '0000-00-00')";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([
        ':Matricola' => $Matricola,
        ':DataInicio' => $DataInicio
    ]);

    // Segunda etapa: Inserir um novo registro com os dados fornecidos
    $insertSql = "INSERT INTO propriedade (Matricola, NumeroBI, DataInicio, DataFim) VALUES (:Matricola, :NumeroBI, :DataInicio, :DataFim)";
    $insertStmt = $pdo->prepare($insertSql);
    $insertStmt->execute([
        ':Matricola' => $Matricola,
        ':NumeroBI' => $NumeroBI,
        ':DataInicio' => $DataInicio,
        ':DataFim' => $DataFim
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

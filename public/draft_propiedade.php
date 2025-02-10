<?php
include '../scripts/db.php';

$Matricola = $_POST['Matricola'];
$NumeroBI = $_POST['NumeroBI'];
$DataInicio = $_POST['DataInicio'];
$DataFim = $_POST['DataFim'];

try{
    $sql = "INSERT INTO propriedade (Matricola, NumeroBI, DataInicio, DataFim) VALUES (:Matricola, :NumeroBI, :DataInicio, :DataFim)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':Matricola' => $Matricola,
        ':NumeroBI' => $NumeroBI,
        ':DataInicio' => $DataInicio,
        ':DataFim' => $DataFim
    ]);
    echo json_encode(['success' => true]); }

catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>
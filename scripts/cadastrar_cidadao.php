<?php
include 'db.php';

$NumeroUnico = $_POST['NumeroUnico'];
$Nome = $_POST['Nome'];
$Endereco = $_POST['Endereco'];
$DataNascimento = $_POST['DataNascimento'];

$sqlCheck = "SELECT COUNT(*) FROM cidadao WHERE NumeroBI = :NumeroUnico";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':NumeroUnico' => $NumeroUnico]);
$exists = $stmtCheck->fetchColumn();

if ($exists > 0) {
    echo json_encode(['success' => false, 'error' => 'Cidadão já existe!']);
} else {
    $sqlInsert = "INSERT INTO cidadao (NumeroBI, Nome, Endereco, DataNascimento) VALUES (:NumeroUnico, :Nome, :Endereco, :DataNascimento)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':NumeroUnico' => $NumeroUnico,
        ':Nome' => $Nome,
        ':Endereco' => $Endereco,
        ':DataNascimento' => $DataNascimento
    ]);
    echo json_encode(['success' => true]);
}
?>


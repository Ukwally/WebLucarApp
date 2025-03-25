<?php
include 'db.php';

$tipo=$_POST['tipo'];
$dataEmissao=$_POST['dataEmissao'];
$cidadaoMultado=$_POST['cidadaoMultado'];

if ( empty($tipo) || empty($dataEmissao)) {
    echo json_encode(['success' => false, 'error' => 'Preencha todos os campos']);
} else {
    try {
        // Primeira etapa: Atualizar o registro existente, se houver
        $updateSql = "INSERT INTO multas (tipo,dataEmissao,cidadaoMultado) 
        VALUES (:tipo, :dataEmissao, :cidadaoMultado)
        ";
    
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':tipo' => $tipo,
            ':dataEmissao' => $dataEmissao,
            ':cidadaoMultado' => $cidadaoMultado,
        ]);
    
        echo json_encode(['success' => true]);
    
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}




?>
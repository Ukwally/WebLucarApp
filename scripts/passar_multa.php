<?php
include 'db.php';

$tipo=$_POST['tipo'];
$dataEmissao=$_POST['dataEmissao'];
$cidadaoMultado=$_POST['cidadaoMultado'];


// validar tipo de multa 
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $tipo)){
    echo json_encode(['success' => false, 'error' => ' Tipo de multa suporta apenas letras e espaços ']);
    exit;
}

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
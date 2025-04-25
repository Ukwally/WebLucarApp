<?php
include 'db.php';

$Matricola = $_POST['Matricola'];
$NumeroBI = $_POST['NumeroBI'];
$DataInicio = $_POST['DataInicio'];
$DataFim = $_POST['DataFim'];

//Verifica se a matrícula tem o formato(ex: AB-12-CD)
//function validarMatricula($matricula) {
//    return preg_match("/^[A-Z]{2}-\d{2}-[A-Z]{2}$/", strtoupper($matricula));
//}

//Para suportar ambos os formatos (como AB-12-CD e AB-12-13-CD)
//function validarMatricula($matricula) {
//    return preg_match("/^[A-Z]{2}-\d{2}-(\d{2}-)?[A-Z]{2}$/", strtoupper($matricula));
//}

//Verifica se a matrícula tem o formato (ex: AB-12-13-CD)
if (!preg_match("/^[A-Z]{2}-\d{2}-\d{2}-[A-Z]{2}$/",  strtoupper($Matricola))) {
    echo json_encode(['success' => false, 'error' => 'Formáto de matrícula inválido']);
    exit;
}

// Verifica se o BI tem o formato adequado (ex: 004351746UE066)
if (!preg_match("/^\d{9}[A-Z]{2}\d{3}$/",  strtoupper($NumeroBI))) {
    echo json_encode(['success' => false, 'error' => 'BI inválido']);
    exit;
}


$sqlCheck = "SELECT COUNT(*) FROM cidadao WHERE NumeroBI = :NumeroBI";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':NumeroBI' => $NumeroBI]);
$cidadaoExiste = $stmtCheck->fetchColumn();

if (empty($Matricola) ||empty($NumeroBI) ||empty($DataInicio)) {
    echo json_encode(['success' => false, 'error' => 'Preencha todos os campos!']);
} else {
    if ($cidadaoExiste > 0) {
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
    } else {
        echo json_encode(['success' => false, 'error' => 'Cidadão não existe no sistema']); 
    }
    
}

?>

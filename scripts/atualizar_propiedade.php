<?php
include 'db.php';

$Matricola = $_POST['Matricola'];
$NumeroBI = $_POST['NumeroBI'];
$DataInicio = $_POST['DataInicio'];
$DataFim = $_POST['DataFim'];

// Função para validar matrícula (assumindo o formato português: 2 letras, 2 números, 2 letras)
//function validarMatricula($matricula) {
//    // Verifica se a matrícula tem o formato adequado (ex: AB-12-CD)
//    return preg_match("/^[A-Z]{2}-\d{2}-[A-Z]{2}$/", strtoupper($matricula));
//}

// Expressão regular para validar o número do BI
//$padrao = "/^\d{3}\d{6}[A-Z]{2}\d{3}$/";

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

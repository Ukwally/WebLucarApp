<?php
include 'db.php';

$NumeroUnico = $_POST['NumeroUnico'];
$Nome = $_POST['Nome'];
$Endereco = $_POST['Endereco'];
$DataNascimento = $_POST['DataNascimento'];
$Genero = $_POST['Genero'];

$sqlCheck = "SELECT COUNT(*) FROM cidadao WHERE NumeroBI = :NumeroUnico";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':NumeroUnico' => $NumeroUnico]);
$exists = $stmtCheck->fetchColumn();



if (empty($NumeroUnico ) || empty($Nome) || empty($Endereco) || empty($DataNascimento) || empty($Genero)) {
    echo json_encode(['success'=> false, 'error'=> 'Prencha todos os campos']);
} else {







    // Validar o formato do NumeroUnico (apenas números e 2 maiúsculos)
    //!preg_match('/^\d{1,10}[A-Z]{2}$/', $NumeroUnico)
    
    // Validar o formato do NumeroUnico (apenas números, 2 maiúsculos e opcionalmente mais números)
    if (!preg_match('/^\d{1,10}[A-Z]{2}\d*$/', $NumeroUnico)) {
        echo json_encode(['success' => false, 'error' => 'Número do BI inválido']);
        exit; // Interrompe o script se a validação falhar
    }
    //   ^\d{1,10}: Começa com de 1 a 10 números.
    //   [A-Z]{2}: Seguido de exatamente 2 letras maiúsculas.
    //   \d*$: E opcionalmente pode continuar com zero ou mais números (por isso o *).
    
    // Validar o Nome (apenas letras e espaços permitidos)
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $Nome)) {
        echo json_encode(['success' => false, 'error' => 'Nome deve conter apenas letras e espaços']);
        exit; // Interrompe o script se a validação falhar
    }
    // Validar o Endereco (pelo menos 5 caracteres e não permitir números ou caracteres especiais)
    if (strlen($Endereco) < 5 || !preg_match('/^[a-zA-ZÀ-ÿ0-9\s,.-]+$/', $Endereco)) {
        echo json_encode(['success' => false, 'error' => 'Endereço inválido, deve conter pelo menos 5 caracteres e não incluír caracteres especiais']);
        exit; // Interrompe o script se a validação falhar
    }








    if ($exists > 0) {
        echo json_encode(['success' => false, 'error' => 'Cidadão já existe!']);
    } else {
        $sqlInsert = "INSERT INTO cidadao (NumeroBI, Nome, Endereco, DataNascimento,Genero) VALUES (:NumeroUnico, :Nome, :Endereco, :DataNascimento, :Genero)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':NumeroUnico' => $NumeroUnico,
            ':Nome' => $Nome,
            ':Endereco' => $Endereco,
            ':DataNascimento' => $DataNascimento,
            ':Genero' => $Genero
        ]);
        echo json_encode(['success' => true]);
    }
}


?>


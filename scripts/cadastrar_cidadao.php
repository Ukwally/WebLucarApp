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

    //Validar o formato do BI (apenas números, 2 maiúsculos e opcionalmente mais números)
    //if (!preg_match('/^\d{1,10}[A-Z]{2}\d*$/', $NumeroUnico)) {
    //    echo json_encode(['success' => false, 'error' => 'Número do BI inválido']);
    //    exit;
    //}
    //   ^\d{1,10}: Começa com de 1 a 10 números.
    //   [A-Z]{2}: Seguido de exatamente 2 letras maiúsculas.
    //   \d*$: E opcionalmente pode continuar com zero ou mais números (por isso o *).


    
    // Verifica se o BI tem o formato adequado,precisamente (ex: 004351746UE066)
    if (!preg_match("/^\d{9}[A-Z]{2}\d{3}$/",  strtoupper($NumeroUnico))) {
        echo json_encode(['success' => false, 'error' => 'BI inválido']);
        exit; // Interrompe o script se a validação falhar
    }

    // Validar o Nome (apenas letras e espaços permitidos)
    //(!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $Nome)) {
    $nomeMaxLength = 100;
    if (strlen($Nome) > $nomeMaxLength || !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $Nome)) {
        echo json_encode(['success' => false, 'error' => 'Nome deve ter até ' . $nomeMaxLength . ' caracteres e conter apenas letras e espaços']);
        exit;
    }

    // Validar o Endereco (pelo menos 5 caracteres e não permitir números ou caracteres especiais)
    if (strlen($Endereco) < 5 || !preg_match('/^[a-zA-ZÀ-ÿ0-9\s,.-]+$/', $Endereco)) {
        echo json_encode(['success' => false, 'error' => 'Endereço inválido, deve ter pelo menos 5 caracteres e não incluír caracteres especiais']);
        exit;
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


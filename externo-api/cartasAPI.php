<?php
include 'dbExterno.php';

header('Content-Type: application/json');


$dataAtual = date('Y-m-d H:i:s');

$numeroBI = $_GET['numeroBI'];

//Verificar Estado
$sqlStatus = "SELECT * FROM cartas WHERE numeroBI = ? 
LIMIT 1";
$stmtStatus = $pdo->prepare($sqlStatus);
$stmtStatus->execute([$numeroBI]);
$status = $stmtStatus->fetch(PDO::FETCH_ASSOC);


//Buscar carta
$sqlCarta = "SELECT * FROM cartas WHERE numeroBI = ? 
LIMIT 1";
//AND data_expiracao < CURRENT_DATE

$stmtCarta = $pdo2->prepare($sqlCarta);
$stmtCarta->execute([$numeroBI]);
$carta = $stmtCarta->fetch(PDO::FETCH_ASSOC);

if ($status && isset($status['data_expiracao'])) {
    if ($status['data_expiracao'] >= $dataAtual) {
        $status='ativo';
    } else {
        $status ='expirado';
    }
} else {
    $status = 'não encontrado';
}

echo json_encode(['carta' => $carta, 'status'=>$status]);

/* entender
// Preparar a resposta com o status e a carta
$response = [];

if ($status && isset($status['data_expiracao'])) {
    if ($status['data_expiracao'] >= $dataAtual) {
        $response['status'] = 'ativo';
    } else {
        $response['status'] = 'expirado';
    }
} else {
    $response['status'] = 'não encontrado';
}

// Adicionar a carta ao retorno, se encontrada
if ($carta) {
    $response['carta'] = $carta;
} else {
    $response['carta'] = null;
}

// Retornar a resposta como JSON
echo json_encode($response);
*/
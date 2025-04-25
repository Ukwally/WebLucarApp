<?php
include 'db.php';
include '../externo-api/dbExterno.php';

header('Content-Type: application/json');

// Data dos últimos 7 dias
$dates = [];
for ($i = 6; $i >= 0; $i--) {
    $dates[] = date('Y-m-d', strtotime("-$i days"));
}

// Arrays para os dados
$viaturasAdicionadas = [];
$viaturasRoubadas = [];
$cartasExpiradas = [];

foreach ($dates as $date) {
    // Viaturas adicionadas
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM viatura WHERE DATE(created_at) = ?");
    $stmt->execute([$date]);
    $viaturasAdicionadas[] = $stmt->fetchColumn();

    // Viaturas roubadas
    $stmt = $pdo2->prepare("SELECT COUNT(*) FROM viaturasroubadas WHERE DATE(data_roubo) = ?");
    $stmt->execute([$date]);
    $viaturasRoubadas[] = $stmt->fetchColumn();

    // Cartas expiradas
    $stmt = $pdo2->prepare("SELECT COUNT(*) FROM cartas WHERE DATE(data_expiracao) = ? AND data_expiracao < CURRENT_DATE");
    $stmt->execute([$date]);
    $cartasExpiradas[] = $stmt->fetchColumn();
}

echo json_encode([
    'labels' => array_map(function($date) {
        return date('D', strtotime($date)); // Formato abreviado (Seg, Ter, etc.)
    }, $dates),
    'viaturasAdicionadas' => $viaturasAdicionadas,
    'viaturasRoubadas' => $viaturasRoubadas,
    'cartasExpiradas' => $cartasExpiradas
]);
/*
   'viaturasAdicionadas' => [50,43,64,10,4,21,13],
    'viaturasRoubadas' => [50,43,64,10,4,21,13],
    'cartasExpiradas' => [50,43,64,10,4,21,13]
*/
?>

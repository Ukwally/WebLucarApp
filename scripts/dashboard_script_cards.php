<?php
include 'db.php'; // Conexão com o banco
include '../externo-api/dbExterno.php';

header('Content-Type: application/json');

// Consulta para total de viaturas cadastradas no ano atual
$sql_viaturas = "SELECT COUNT(*) AS total_viaturas FROM viatura WHERE YEAR(created_at) = YEAR(CURDATE())";
$stmt_viaturas = $pdo->query($sql_viaturas);
$total_viaturas = $stmt_viaturas->fetch(PDO::FETCH_ASSOC)['total_viaturas'];

// Consulta para total de cartas expiradas no ano atual
$sql_cartas_expiradas = "SELECT COUNT(*) AS total_cartas_expiradas FROM cartas WHERE YEAR(data_expiracao) = YEAR(CURDATE()) AND data_expiracao < CURDATE()";
$stmt_cartas_expiradas = $pdo2->query($sql_cartas_expiradas);
$total_cartas_expiradas = $stmt_cartas_expiradas->fetch(PDO::FETCH_ASSOC)['total_cartas_expiradas'];

// Consulta para total de multas no ano atual
$sql_multas = "SELECT COUNT(*) AS total_multas FROM multas WHERE YEAR(dataEmissao) = YEAR(CURDATE())";
$stmt_multas = $pdo->query($sql_multas);
$total_multas = $stmt_multas->fetch(PDO::FETCH_ASSOC)['total_multas'];

// Consulta para total de multas liquidadas no ano atual
$sql_multas_liquidadas = "SELECT COUNT(*) AS total_multas_liquidadas FROM multas WHERE YEAR(dataLiquidacao) = YEAR(CURDATE()) AND status = 'Pago'";
$stmt_multas_liquidadas = $pdo->query($sql_multas_liquidadas);
$total_multas_liquidadas = $stmt_multas_liquidadas->fetch(PDO::FETCH_ASSOC)['total_multas_liquidadas'];

// Montando o array com todos os totais
$data = [
    'total_viaturas' => $total_viaturas,
    'total_cartas_expiradas' => $total_cartas_expiradas,
    'total_multas' => $total_multas,
    'total_multas_liquidadas' => $total_multas_liquidadas
];

// Retorna os dados como JSON
echo json_encode($data);
?>

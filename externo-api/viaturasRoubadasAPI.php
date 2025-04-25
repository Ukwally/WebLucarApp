<?php
include 'dbExterno.php';

header('Content-Type: application/json');

$matricula = $_GET['Matricula'];

$sql = "SELECT * FROM viaturasroubadas WHERE matricula = ? LIMIT 1";
$stmt = $pdo2->prepare($sql);
$stmt->execute([$matricula]);
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(['roubada' => $resultado ? true : false]);
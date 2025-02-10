<?php
include 'db.php';

$matricula = $_POST['Matricula'];
$marca = $_POST['Marca'];
$modelo = $_POST['Modelo'];
$ano = $_POST['Ano'];
$cor = $_POST['Cor'];

$sql = "INSERT INTO viatura (Matricola, Marca, Modelo, Ano, Cor) VALUES (:matricula, :marca, :modelo, :ano, :cor)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':matricula'=>$matricula, 
    ':marca'=>$marca, 
    ':modelo'=>$modelo, 
    ':ano'=>$ano, 
    ':cor'=>$cor,
]);

echo json_encode(['success' => true]);
?>

					
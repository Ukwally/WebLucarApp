<?php

include 'db.php';

header('Content-Type: application/json');

$matricula = $_GET['Matricula'];

/*$sql = "SELECT * FROM viatura WHERE Matricola = ?";*/

/* Método para buscar os dados da viatura antes de remover a tabela propietario
    $sql = "SELECT v.Matricola, v.Marca,v.Modelo,v.Ano,v.Cor,p.ProprietarioID,c.Nome,c.Endereco,c.DataNascimento
    FROM viatura v
    JOIN propriedade pr ON v.Matricola = pr.Matricola
    JOIN proprietario p ON pr.ProprietarioID = p.ProprietarioID
    JOIN cidadao c ON p.NumeroBI = c.NumeroBI
    WHERE v.Matricola = ?
    AND pr.DataFim IS NULL;
    ";
*/

$sql = "SELECT v.Matricola, v.Marca, v.Modelo, v.Ano, v.Cor, v.NumeroMotor, v.MedidaPmeumaticos, v.Servico, v.Lotacao, v.Cilindrada, v.NumeroCilindros, v.Combustivel, v.PesoBruto, v.Tara, v.NumeroQuadro,      pr.NumeroBI, c.Nome, c.Endereco, c.DataNascimento
FROM Viatura v
JOIN Propriedade pr ON v.Matricola = pr.Matricola
JOIN Cidadao c ON pr.NumeroBI = c.NumeroBI
WHERE v.Matricola = ?
AND (pr.DataFim IS NULL OR pr.DataFim = '0000-00-00');
";




$stmt = $pdo->prepare($sql);
$stmt->execute([$matricula]);
$viatura = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($viatura);
?>

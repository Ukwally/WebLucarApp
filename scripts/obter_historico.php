<?php
include 'db.php';

$matricula = $_GET['Matricula'];

/*$sql = "SELECT p.*, c.Nome, c.Endereco FROM propriedade pr
        JOIN proprietario p ON pr.ProprietarioID = p.ProprietarioID
        JOIN cidadao c ON p.CidadaoID = c.CidadaoID
        WHERE pr.Matricola = ?";
*/

/* Método para buscar o istórico antes de eliminar a tabela propietario
        $sql = "SELECT pr.Matricola, pr.DataInicio, pr.DataFim, c.Nome, c.Endereco
        FROM propriedade pr
        JOIN proprietario p ON pr.ProprietarioID = p.ProprietarioID
        JOIN cidadao c ON p.NumeroBI = c.NumeroBI
        WHERE pr.Matricola = ?";
*/

$sql ="SELECT pr.Matricola, pr.NumeroBI, pr.DataInicio, pr.DataFim, c.Nome, c.Endereco
FROM Propriedade pr
JOIN Cidadao c ON pr.NumeroBI = c.NumeroBI
WHERE pr.Matricola = ?
ORDER BY pr.DataInicio";



$stmt = $pdo->prepare($sql);
$stmt->execute([$matricula]);
$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($historico);
?>

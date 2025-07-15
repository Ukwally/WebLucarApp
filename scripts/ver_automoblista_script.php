<?php
include 'db.php';
$automoblista = $_GET['Automoblista'];

//VALIDAR AQUI O automoblista NÃO VAZIO NEM CARACTERES ESPECIAIS

$sqlHistorico ="SELECT pr.Id, pr.Matricola, pr.NumeroBI, pr.DataInicio, pr.DataFim, c.Nome, c.genero, c.Endereco,v.Marca,v.Modelo,v.Ano,v.cor 
FROM Propriedade pr
JOIN viatura v ON pr.Matricola = v.Matricola
JOIN Cidadao c ON pr.NumeroBI = c.NumeroBI
WHERE c.NumeroBI = ?
ORDER BY pr.DataInicio";

$stmtHistorico = $pdo->prepare($sqlHistorico);
$stmtHistorico->execute([$automoblista]);
$historico = $stmtHistorico->fetchAll(PDO::FETCH_ASSOC);

$sqlMultas="SELECT * FROM multas
WHERE (dataLiquidacao IS null OR dataLiquidacao = '0000-00-00')
AND cidadaoMultado = ?
";

$stmtMultas = $pdo->prepare($sqlMultas);
$stmtMultas->execute([$automoblista]);
$multas = $stmtMultas->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['historico'=>$historico,'multas'=>$multas]);

?>
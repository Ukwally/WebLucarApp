<?php
// Incluir o arquivo de conexão com o banco de dados
include('db.php');

// Obter o termo de pesquisa
$termo = isset($_GET['usuario']) ? $_GET['usuario'] : '';

// Preparar a consulta SQL para buscar usuários
$sql = "SELECT * FROM usuarios WHERE username LIKE :termo OR tech_number LIKE :termo ORDER BY username";
$stmt = $pdo->prepare($sql);

// Adicionar os parâmetros de pesquisa
$termo_completo = "%" . $termo . "%"; // % é utilizado para buscar por correspondências parciais
$stmt->bindParam(':termo', $termo_completo, PDO::PARAM_STR);

// Executar a consulta
$stmt->execute();

// Obter os resultados
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar os dados em formato JSON
echo json_encode($usuarios);
?>

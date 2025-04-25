<?php
$host2 = 'localhost';
$db2   = 'externo_api';
$user2 = 'root';
$pass2 = '';

try {
    $pdo2 = new PDO("mysql:host=$host2;dbname=$db2", $user2, $pass2);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e2) {
    die("Não foi possível conectar ao banco de dados externo_api:" . $e2->getMessage());
}
?>
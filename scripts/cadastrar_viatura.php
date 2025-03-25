<?php
include 'db.php';

$matricula = $_POST['Matricula'];
$marca = $_POST['Marca'];
$modelo = $_POST['Modelo'];
$ano = $_POST['Ano'];
$cor = $_POST['Cor'];

$NumeroMotor = $_POST['NumeroMotor'];
$MedidaPmeumaticos = $_POST['MedidaPmeumaticos'];
$Servico = $_POST['Servico'];
$Lotacao = $_POST['Lotacao'];
$Cilindrada = $_POST['Cilindrada'];
$NumeroCilindros = $_POST['NumeroCilindros'];
$Combustivel = $_POST['Combustivel'];
$PesoBruto = $_POST['PesoBruto'];
$Tara = $_POST['Tara'];
$NumeroQuadro = $_POST['NumeroQuadro'];

// O campo deve conter apenas letras (maiúsculas e minúsculas), números, hífen e vírgula
//$padrao = "/^[A-Za-z0-9\-,]+$/";


if (empty($matricula) || empty($marca) || empty($modelo) || empty($cor) || empty($NumeroMotor) || empty($MedidaPmeumaticos) || empty($Cilindrada) || empty($NumeroCilindros) || empty($Combustivel) || empty($NumeroQuadro)) {
    echo json_encode(['success' => false, 'error' =>'Preencha todos os campos obrigatórios']);
} else {

    try {

        $sql = "INSERT INTO viatura (Matricola, Marca, Modelo, Ano, Cor, NumeroMotor, MedidaPmeumaticos, Servico, Lotacao, Cilindrada, NumeroCilindros, Combustivel, PesoBruto, Tara, NumeroQuadro) VALUES (:matricula, :marca, :modelo, :ano, :cor, :NumeroMotor, :MedidaPmeumaticos, :Servico, :Lotacao, :Cilindrada, :NumeroCilindros, :Combustivel, :PesoBruto, :Tara, :NumeroQuadro)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':matricula'=>$matricula, 
            ':marca'=>$marca, 
            ':modelo'=>$modelo, 
            ':ano'=>$ano, 
            ':cor'=>$cor,
            ':NumeroMotor'=>$NumeroMotor,
            ':MedidaPmeumaticos'=>$MedidaPmeumaticos,
            ':Servico'=>$Servico,
            ':Lotacao'=>$Lotacao,
            ':Cilindrada'=>$Cilindrada,
            ':NumeroCilindros'=>$NumeroCilindros,
            ':Combustivel'=>$Combustivel,
            ':PesoBruto'=>$PesoBruto,
            ':Tara'=>$Tara,
            ':NumeroQuadro'=>$NumeroQuadro,
        ]);
    
        echo json_encode(['success' => true]);
    
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    
}

?>

					
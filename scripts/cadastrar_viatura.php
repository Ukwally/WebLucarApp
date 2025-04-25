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

//$tipoCaixa = $_POST['TipoCaixa'];
//$distanciaEixos = $_POST['DistanciaEixos'];

//Para suportar ambos os formatos (como AB-12-CD e AB-12-13-CD)
//function validarMatricula($matricula) {
//    return preg_match("/^[A-Z]{2}-\d{2}-(\d{2}-)?[A-Z]{2}$/", strtoupper($matricula));
//}

//Verifica se a matrícula tem o formato (ex: AB-12-13-CD)
if (!preg_match("/^[A-Z]{2}-\d{2}-\d{2}-[A-Z]{2}$/",  strtoupper($matricula))) {
    echo json_encode(['success' => false, 'error' => 'Formáto de matrícula inválido']);
    exit;
}

// Função para validar a marca
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $marca)){
 echo json_encode(['success' => false, 'error' => 'Marca - apenas letras e espaços ']);
    exit;
}

// Função para validar o número do motor (formato: 6G72-ST5360)
if (!preg_match('/^[A-Za-z0-9-]+$/', $NumeroMotor)){
 echo json_encode(['success' => false, 'error' => 'Numero de motor - aceita letras, números e hífens ']);
    exit;
}

// Função para validar a cor (apenas letras e espaços)
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $cor)){
 echo json_encode(['success' => false, 'error' => 'Cor -  Apenas letras e espaços ']);
    exit;
}

// Função para validar as medidas dos pneumáticos (formato: 265-70R16)
if (!preg_match('/^\d{3}-\d{2}R\d{2}$/', $MedidaPmeumaticos)){
 echo json_encode(['success' => false, 'error' => 'Medidas pneomáticos - Digite no formato correto . EX: 265-70R16 ']);
    exit;
}

// Função para validar o serviço (apenas uma string simples, como PARTICULAR)
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $Servico)){
 echo json_encode(['success' => false, 'error' => 'Serviço - Apenas letras e espaços ']);
    exit;
}

// Função para validar a data de emissão (formato: dd/mm/aaaa)
//if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dataEmissao)){
// echo json_encode(['success' => false, 'error' => ' Digite no formato correto . EX: 15/3/2009 ']);
//    exit;
//}

// Função para validar a lotação (ex: 7 LUGARES)
if (!preg_match('/^\d+\sLUGARES$/', $Lotacao)){
 echo json_encode(['success' => false, 'error' => 'Lotação - Digite no formato correto . EX: 7 LUGARES ']);
    exit;
}

// Função para validar o modelo (ex: PAJERO-V6-2,97-2007)
if (!preg_match('/^[A-Za-z0-9\s\-,]+$/', $modelo)){
 echo json_encode(['success' => false, 'error' => 'Modelo - Aceita letras, números, espaços, vírgulas e hífens ']);
    exit;
}

// Função para validar o número da quadra (ex: JMYLRV93W7J708569)
if (!preg_match('/^[A-Za-z0-9]+$/', $NumeroQuadro)){
 echo json_encode(['success' => false, 'error' => 'Numero quadro - Aceita letras e números ']);
    exit;
}

// Função para validar a cilindrada (formato: 2972 c.c)
if (!preg_match('/^\d+\s*c\.c$/', $Cilindrada)){
 echo json_encode(['success' => false, 'error' => 'Cilindrada - Digite no formato correto . EX: 2972 c.c ']);
    exit;
}

// Função para validar o número de cilindros (apenas número)
if (!preg_match('/^\d+$/', $NumeroCilindros)){
 echo json_encode(['success' => false, 'error' => 'Numero cilindros - Apenas números ']);
    exit;
}

// Função para validar o combustível (ex: GASOLINA)
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $Combustivel)){
 echo json_encode(['success' => false, 'error' => 'Conbustível - apenas letras e espaços ']);
    exit;
}

// Função para validar o peso bruto (não foi dado um formato específico, então podemos apenas verificar se é um número)
if (!is_numeric($PesoBruto)){
 echo json_encode(['success' => false, 'error' => 'Peso bruto - Verifica se é um número ']);
    exit;
}

// Função para validar a tara (ex: 157 kg)
if (!preg_match('/^\d+\s*kg$/', $Tara)){
 echo json_encode(['success' => false, 'error' => 'Tara - Digite no formato correto . EX: 157 kg ']);
    exit;
}

/* Função para validar o tipo de caixa (ex: FECHADA)
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $tipoCaixa)){
 echo json_encode(['success' => false, 'error' => 'Tipo de caixa - Apenas letras e espaços ']);
    exit;
}

// Função para validar a distância entre eixos (formato: 297cm)
if (!preg_match('/^\d+cm$/', $distanciaEixos)){
 echo json_encode(['success' => false, 'error' => ' Distância entre eixos - Digite no formato correto . EX: 297cm ']);
    exit;
}*/



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

					
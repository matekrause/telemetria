<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentar</title>
</head>

<body>
    <?php
    include "bd/conexaobd.php";

    $conexao = conectar();

    $sql = "SELECT MAX(tentativa) AS max_tentativa FROM master";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($result);
    $tentativa = $row["max_tentativa"] + 1;

    echo "$tentativa";

    $setor = 0;

    function gerarSetor($tempo)
    {
        if (intval($tempo / 3) == 0) {
            $setor = 1;
        } else if (intval($tempo / 3) == 1) {
            $setor = 2;
        } else if (intval($tempo / 3) == 2) {
            $setor = 3;
        } else if (intval($tempo / 3) == 3) {
            $setor = 4;
        }

        return $setor;
    }

    for ($tempo = 1; $tempo <= 9; $tempo++) {
        $values = "('" . $tentativa . "', '" . $tempo . "', '" . gerarSetor($tempo) . "', '"
            . rand(95, 100) . "', '" . rand(95, 100) . "', '" . rand(95, 100) . "', '" . rand(1, 50) / 100 . "', '"
            . rand(1, 10) / 100 . "', '" . rand(90, 100) / 100 . "', '" . rand(0, 40) . "', '" . rand(0, 40) . "')";
        $sql = "INSERT INTO `telemetriabd`.`master` (`tentativa`, `tempo`, `setor`, `velocidadeDesejada`, `velocidadeMotorEsquerdo`, `velocidadeMotorDireito`, `p`, `d`, `i`, `erro`, `erroAcumulado`) 
                VALUES $values";
        mysqli_query($conexao, $sql)  or  die("Erro ao inserir. " . mysqli_error($conexao));
    }

    ?>

    ok

</body>

</html>
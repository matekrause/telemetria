<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentar</title>
</head>

<body>
    <?php
    include_once "../bd/conexaobd.php";
    include_once "perlin.php";

    $conexao = conectar();

    $perlin = new Perlin();

    $sql = "SELECT MAX(tentativa) AS max_tentativa FROM master";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($result);
    $tentativa = $row["max_tentativa"] + 1;

    echo "$tentativa";

    $setor = 0;

    function gerarSetor($tempo, $columnsPerRow)
    {
        if($tempo >= 0 && $tempo < $columnsPerRow * 1){
            return 1;
        } else if($tempo >= $columnsPerRow * 1 && $tempo < $columnsPerRow * 2){
            return 2;
        }else if($tempo >= $columnsPerRow * 2 && $tempo < $columnsPerRow * 3){
            return 3;
        }else if($tempo >= $columnsPerRow * 3 && $tempo < $columnsPerRow * 4){
            return 4;
        }else if($tempo >= $columnsPerRow * 4 && $tempo < $columnsPerRow * 5){
            return 5;
        }else if($tempo >= $columnsPerRow * 5 && $tempo < $columnsPerRow * 6){
            return 6;
        }else if($tempo >= $columnsPerRow * 6 && $tempo < $columnsPerRow * 7){
            return 7;
        }else if($tempo >= $columnsPerRow * 7 && $tempo < $columnsPerRow * 8){
            return 8;
        }else if($tempo >= $columnsPerRow * 8 && $tempo < $columnsPerRow * 9){
            return 9;
        }else if($tempo >= $columnsPerRow * 9 && $tempo < $columnsPerRow * 10){
            return 10;
        }else if($tempo >= $columnsPerRow * 10 && $tempo < $columnsPerRow * 11){
            return 11;
        }else if($tempo >= $columnsPerRow * 11 && $tempo < $columnsPerRow * 12){
            return 12;
        }else if($tempo >= $columnsPerRow * 12 && $tempo < $columnsPerRow * 13){
            return 13;
        }else if($tempo >= $columnsPerRow * 13 && $tempo < $columnsPerRow * 14){
            return 14;
        }else if($tempo >= $columnsPerRow * 14 && $tempo < $columnsPerRow * 15){
            return 15;
        }else if($tempo >= $columnsPerRow * 15 && $tempo < $columnsPerRow * 16){
            return 16;
        }else if($tempo >= $columnsPerRow * 16 && $tempo < $columnsPerRow * 17){
            return 17;
        }else if($tempo >= $columnsPerRow * 17 && $tempo < $columnsPerRow * 18){
            return 18;
        }else if($tempo >= $columnsPerRow * 18 && $tempo < $columnsPerRow * 19){
            return 19;
        }

    }

    $arrayPerlin = $perlin->generatePerlinNoite2D(501);

    // echo "<br>";
    // foreach($arrayPerlin as $current){
    //     echo $current;
    //     echo "<br>";
    // }
    // echo "<br>";

    $velDesejada = 50;

    function calcVelEsq($tempo, $arrayPerlin, $velDesejada){
        return intval($arrayPerlin[$tempo]);
    }

    function calcVelDir($tempo, $arrayPerlin, $velDesejada){
        $atual = $arrayPerlin[$tempo];
        $dif = $atual - $velDesejada;
        return intval($velDesejada - $dif);
    }

    $columnsPerRow = 500;

    // implementar PERLIN NOISE !!!!
    // https://gist.github.com/dazld/2173820
    
    for ($tempo = 1; $tempo <= $columnsPerRow; $tempo++) {
        $tempoComplete = date("Y-m-d") . " 00:00:00.00" . $tempo;
        $values = "('" . $tentativa . "', '" . $tempoComplete . "', '" . gerarSetor($tempo, $columnsPerRow) . "', '"
            . $velDesejada . "', '" . calcVelEsq($tempo, $arrayPerlin, $velDesejada) . "', '" . calcVelDir($tempo, $arrayPerlin, $velDesejada) . "', '" . rand(1, 50) / 100 . "', '"
            . rand(1, 10) / 100 . "', '" . rand(90, 100) / 100 . "', '" . rand(0, 40) . "', '" . rand(0, 40) . "')";
        $sql = "INSERT INTO `telemetriabd`.`master` (`tentativa`, `tempo`, `setor`, `velocidadeDesejada`, `velocidadeMotorEsquerdo`, `velocidadeMotorDireito`, `p`, `d`, `i`, `erro`, `erroAcumulado`) 
                VALUES $values";
        mysqli_query($conexao, $sql)  or  die("Erro ao inserir. " . mysqli_error($conexao));
    }

    ?>

    ok

</body>

</html>
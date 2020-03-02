<!DOCTYPE html>
<html lang="ptbr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telemetria</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

    <?php
    include_once "bd/conexaobd.php";
    include_once "gerarDados.php";
    include_once "data.php";

    //-------------------------------------
    $data = new Data();
    //-------------------------------------

    ?>

    <script src="node_modules/chart.js/dist/Chart.js"></script>

    <div class="control clearfix">
        <form action="index.php" method="get">

            <fieldset>
                <legend>Informações eixo Y</legend>
                <?php
                $resultsInfo = getFieldsInfo();
                $resultsInfoArray = getFieldsInfoArray();

                ?>

                <!-- atualmente mostrando apenas erro acumulado -->

                <div style="width: 100%;">
                    <div class="float-left">
                        <input type="checkbox" id="1a" name="velocidadeDesejada" <?php echo $resultsInfo["velocidadeDesejada"] ?>>
                        <label for="1a">Velocidade Desejada</label> <br>
                        <input type="checkbox" id="2a" name="velocidadeMotorEsquerdo" <?php echo $resultsInfo["velocidadeMotorEsquerdo"] ?>>
                        <label for="2a">Velocidade Motor Esquerdo</label> <br>
                        <input type="checkbox" id="3a" name="velocidadeMotorDireito" <?php echo $resultsInfo["velocidadeMotorDireito"] ?>>
                        <label for="3a">Velocidade Motor Direito</label> <br>
                        <input type="checkbox" id="4a" name="erroAcumulado" <?php echo $resultsInfo["erroAcumulado"] ?>>
                        <label for="4a">Erro Acumulado</label>
                    </div>
                    <div class="float-left">
                        <input type="checkbox" id="5a" name="erro" <?php echo $resultsInfo["erro"] ?>>
                        <label for="5a">Erro</label> <br>
                        <input type="checkbox" id="6a" name="p" <?php echo $resultsInfo["p"] ?>>
                        <label for="6a">P</label> <br>
                        <input type="checkbox" id="7a" name="d" <?php echo $resultsInfo["d"] ?>>
                        <label for="7a">D</label> <br>
                        <input type="checkbox" id="8a" name="i" <?php echo $resultsInfo["i"] ?>>
                        <label for="8a">I</label> <br>
                    </div>
                </div>
            </fieldset>
            <?php
            ?>
            <fieldset style="margin-left: 1pc;">
                <legend>Tentativas</legend>
                <div style="width: 100%;">

                    <?php
                    $conexao = conectar();

                    $sql = "SELECT DISTINCT tentativa AS numtent FROM master";
                    $result = mysqli_query($conexao, $sql);

                    $count = 0;

                    if (mysqli_num_rows($result) == 0) {
                        echo 'Não há dados cadastrados.';
                    }

                    echo "<div class='float-left'>";

                    $tentativasArray = array();

                    while ($registro = mysqli_fetch_assoc($result)) {
                        $count++;

                        $id = $registro['numtent'];
                        $tentCheck = $_GET["tentativa$id"];
                        if ($tentCheck != "") {
                            $tentCheck = "checked";
                            array_push($tentativasArray, $id);
                            $data->addData($id, $resultsInfoArray); //adiciona a info da tent no array
                        }

                        echo "
                        <input type='checkbox' id='$id' name='tentativa$id' $tentCheck>
                        <label for='$id'>Tentativa $id</label> <br>
                        ";

                        if (($count % 4) == 0) {
                            echo "
                            </div>
                            <div class='float-left'>
                            ";
                        }
                    }

                    if (intval($tempo / 4) == 0) {
                    }
                    ?>

                </div>
            </fieldset>
            <fieldset style="margin-left: 1pc">
                <legend>Linha do tempo</legend>
                <div>
                    <input type="radio" id="contactChoice1" name="contact" value="email">
                    <label for="contactChoice1">Tempo (s)</label>

                    <input type="radio" id="contactChoice2" name="contact" value="phone">
                    <label for="contactChoice2">Setor</label>
                </div>
                <br>
                <div style="width: 100%;" class="clearfix">
                    <div class="float-left">
                        <div>
                            <label for="start">Iniciar em: </label>
                        </div>
                        <div>
                            <label for="start">Terminar em: </label>
                        </div>
                    </div>
                    <div class="float-left">
                        <div>
                            <input type="number" step="0.00001" id="start"> <br>
                        </div>
                        <div>
                            <input type="number" step="0.00001" id="finish">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset style="margin-left: 1pc;">
                <legend>coiso</legend>
                <div class="controls">
                    <input type="button" value="Tela Cheia">
                    <input type="reset" value="Resetar"><br>
                    <input type="submit" value="Gerar">
                </div>
            </fieldset>
        </form>
    </div>


    <br><br>

    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <!------------ GERAR GRAFICO ------------>

    <?php

    //gerar o necessario para usar no grafico 
    $string = generateString($tentativasArray);
    $qntString = stringCount($tentativasArray);
    $qntArrays = arraysCount($data);

    //coisos pro setor
    $resultsTentativaInfoArray = getTentativasInfoArray();
    $maxValue = $data->maxValue;

    if (count($resultsTentativaInfoArray) == 1) {
        $conexao = conectar();
        $sql = "SELECT setor AS setor FROM master WHERE tentativa = '$resultsTentativaInfoArray[0]'";
        $result = mysqli_query($conexao, $sql);
        $setorOrderByTime = [];
        while ($registro = mysqli_fetch_assoc($result)) {
            array_push($setorOrderByTime, $registro["setor"]);
        }
    }else{
        echo "Não é possível!!!!";
    }

    print_r($setorOrderByTime);
    echo "<br>";


    $data = $data->getData();

    ?>

    <script>
        var data = {
            labels: [<?php echo $string ?>],
            datasets: [

                <?php

                $qntString += 6;

                for ($q = 0; $q < $qntArrays; $q++) {

                    $nome = $data[$q][0];
                    $r = $data[$q][2];
                    $g = $data[$q][3];
                    $b = $data[$q][4];
                    $i = $data[$q][5];

                    echo "
                    {
                        label: '$nome',
                        fill: false,
                        lineTension: 0,
                        borderColor: 'rgba($r,$g,$b,$i)', //cor da linha
                        borderWidth: 2,
                        data: [
                    ";
                    for ($i = 6; $i < $qntString; $i++) {
                        echo $data[$q][$i];
                        echo ", ";
                    }

                    echo "]}";

                    if ($q != $qntArrays /*- 1*/) {
                        echo ",";
                    }
                }


                //tentar realmente usar metodo do array::
                $last = 0;
                $first = true;
                $num = 0;
                foreach($setorOrderByTime as $setor){
                    $pass = false;
                    if($last != $setor){
                        if($first == false){
                            echo "
                                ]},
                            ";
                        }
                        $r = rand(10,255);
                        $g = rand(10,255);
                        $b = rand(10,255);
                        echo "
                            {
                                label: 'Setor $setor',
                                fill: true,
                                lineTension: 0,
                                showLine: true,
                                backgroundColor: 'rgba($r, $g, $b, .1)',
                                borderWidth: .1,
                                pointRadius: 0,
                                pointBorderWidth: 0,
                                data:[
                        ";
                        for($i = 0; $i < $num; $i++){
                            echo " ,";
                        }
                        $last = $setor;

                        echo $maxValue;
                        $pass = true;
                    }

                    if($first != true){
                        echo ",";
                    }
                    if($pass == false){
                        echo $maxValue;
                    }

                    $first = false;
                    $num++;
                }

                echo "
                    ]}
                ";


                ?>
            ]
        };


        var options = {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: false,
                    gridLines: {
                        display: true,
                        color: "rgba(255,99,132,0.2)" //cor da linha de fundo
                    },
                    ticks: {
                        beginAtZero: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        };

        Chart.Line('chart', {
            options: options,
            data: data
        });
    </script>

    <?php
    echo $maxValue;
    ?>

</body>

</html>
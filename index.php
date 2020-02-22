<!DOCTYPE html>
<html lang="ptbr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telemetria</title>
</head>

<style>
    body {
        padding: 16px;
    }

    .clearfix {
        overflow: auto;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .chart-container {
        position: relative;
        margin: auto;
        height: 60vh;
        width: 80vw;
    }

    .control {
        position: relative;
        margin: auto;
        width: 80vw;
    }

    .control fieldset {
        max-width: 47%;
        float: left;
    }

    .float-left {
        float: left;
    }

    #addDataset {
        display: none;
    }

    #rmDataset {
        display: none;
    }
</style>

<body>

    <?php
    include_once "bd/conexaobd.php";
    include_once "gerarDados.php";
    ?>

    <script src="node_modules/chart.js/dist/Chart.js"></script>

    <div class="control clearfix">
        <form action="index.php" method="get">
            
            <fieldset>
                <legend>Informações eixo Y</legend>
                <?php 
                $resultsInfo = getFieldsInfo(); 
                echo $resultsInfo["1"];?>
                <div style="width: 100%;">
                    <div class="float-left">
                        <input type="checkbox" id="1a" name="velocidadeDesejada" <?php echo $resultsInfo["velocidadeDesejada"]?>>
                        <label for="1a">Velocidade Desejada</label> <br>
                        <input type="checkbox" id="2a" name="velocidadeMotorEsquerdo" <?php echo $resultsInfo["velocidadeMotorEsquerdo"]?>>
                        <label for="2a">Velocidade Motor Esquerdo</label> <br>
                        <input type="checkbox" id="3a" name="velocidadeMotorDireito" <?php echo $resultsInfo["velocidadeMotorDireito"]?>>
                        <label for="3a">Velocidade Motor Direito</label> <br>
                        <input type="checkbox" id="4a" name="erroAcumulado" <?php echo $resultsInfo["erroAcumulado"]?>>
                        <label for="4a">Erro Acumulado</label>
                    </div>
                    <div class="float-left">
                        <input type="checkbox" id="5a" name="erro" <?php echo $resultsInfo["erro"]?>>
                        <label for="5a">Erro</label> <br>
                        <input type="checkbox" id="6a" name="p" <?php echo $resultsInfo["p"]?>>
                        <label for="6a">P</label> <br>
                        <input type="checkbox" id="7a" name="d" <?php echo $resultsInfo["d"]?>>
                        <label for="7a">D</label> <br>
                        <input type="checkbox" id="8a" name="i" <?php echo $resultsInfo["i"]?>>
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
                    
                    while ($registro = mysqli_fetch_assoc($result)) {
                        $count++;

                        $id = $registro['numtent'];

                        echo "
                        <input type='checkbox' id='$id' name='tentativa$id'>
                        <label for='$id'>Tentativa $id</label> <br>
                        ";

                        if(($count % 4) == 0){
                            echo "
                            </div>
                            <div class='float-left'>
                            ";
                        }

                        if(intval($tempo / 4) == 0){

                        }
                    }
                    ?>
                    
                </div>
            </fieldset>
            <fieldset style="margin-left: 1pc;">
                <legend>Linha do tempo</legend>
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
                <div>
                    <br>
                    <input type="button" value="Resetar">
                </div>
            </fieldset>
            <div style="margin-top: 10px;" class="clearfix float-left">
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </div>


    <br><br>

    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <?php

    $string = generateString();
    $data = generateData();
    $qntString = stringCount();
    $qntArrays = arraysCount();

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

                    if ($q != $qntArrays - 1) {
                        echo ",";
                    }
                }

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
                        beginAtZero: true
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

</body>

</html>
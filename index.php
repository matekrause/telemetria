<!DOCTYPE html>
<html lang="ptbr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telemetria 2</title>
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

    <script src="node_modules/chart.js/dist/Chart.js"></script>

    <div class="control clearfix">
        <form action="index.php" method="get">
            <fieldset>
                <legend>Informações eixo Y</legend>
                <div style="width: 100%;">
                    <div class="float-left">
                        <input type="checkbox" id="1a" name="velocidadeDesejada">
                        <label for="1a">Velocidade Desejada</label> <br>
                        <input type="checkbox" id="2a" name="velocidadeMotorEsquerdo">
                        <label for="2a">Velocidade Motor Esquerdo</label> <br>
                        <input type="checkbox" id="3a" name="velocidadeMotorDireito">
                        <label for="3a">Velocidade Motor Direito</label> <br>
                        <input type="checkbox" id="4a" name="erroAcumulado">
                        <label for="4a">Erro Acumulado</label>
                    </div>
                    <div class="float-left">
                        <input type="checkbox" id="5a" name="erro">
                        <label for="5a">Erro</label> <br>
                        <input type="checkbox" id="6a" name="p">
                        <label for="6a">P</label> <br>
                        <input type="checkbox" id="7a" name="d">
                        <label for="7a">D</label> <br>
                        <input type="checkbox" id="8a" name="i">
                        <label for="8a">I</label> <br>
                    </div>
                </div>
            </fieldset>
            <fieldset style="margin-left: 1pc;">
                <legend>Tentativas</legend>
                <div style="width: 100%;">
                    <div class="float-left">
                        <input type="checkbox" id="1" name="tentativa">
                        <label for="1">Tentativa X</label> <br>
                        <input type="checkbox" id="2" name="tentativa">
                        <label for="2">Tentativa X</label> <br>
                        <input type="checkbox" id="3" name="tentativa">
                        <label for="3">Tentativa X</label> <br>
                        <input type="checkbox" id="4" name="tentativa">
                        <label for="4">Tentativa X</label>
                    </div>
                    <div class="float-left">
                        <input type="checkbox" id="5" name="tentativa">
                        <label for="5">Tentativa X</label> <br>
                        <input type="checkbox" id="6" name="tentativa">
                        <label for="6">Tentativa X</label> <br>
                        <input type="checkbox" id="7" name="tentativa">
                        <label for="7">Tentativa X</label> <br>
                        <input type="checkbox" id="8" name="tentativa">
                        <label for="8">Tentativa X</label> <br>
                    </div>
                    <div class="float-left">
                        <input type="checkbox" id="9" name="tentativa">
                        <label for="9">Tentativa X</label> <br>
                        <input type="checkbox" id="10" name="tentativa">
                        <label for="10">Tentativa X</label> <br>
                        <input type="checkbox" id="11" name="tentativa">
                        <label for="11">Tentativa X</label> <br>
                        <input type="checkbox" id="12" name="tentativa">
                        <label for="12">Tentativa X</label> <br>
                    </div>
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

    include_once "bd/conexaobd.php";
    include_once "gerarDados.php";

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
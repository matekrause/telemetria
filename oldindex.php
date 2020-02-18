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
    
    .chart-container {
        position: relative;
        margin: auto;
        height: 60vh;
        width: 80vw;
    }
    
    .dialog {
        border: 1px solid gray;
        width: 300px;
        margin-top: 1pc;
        padding: 5px;
    }
    
    .control {
        position: relative;
        margin: auto;
        width: 80vw;
    }
    
    #addDataset {
        display: none;
    }
    
    #rmDataset {
        display: none;
    }
</style>

<body>

    <script src="/Projetos/telemetria/node_modules/chart.js/dist/Chart.js"></script>
    <script src="scripts/dialogs.js"></script>

    <div class="control">
        <label for="eixoY">Informação eixo Y:</label>
        <select name="eixoY" id="eixoY">
            <option value="velocidadeDesejada">velocidadeDesejada</option>
            <option value="velocidadeMotorEsquerdo">velocidadeMotorEsquerdo</option>
            <option value="velocidadeMotorDireito">velocidadeMotorDireito</option>
            <option value="p">p</option>
            <option value="d">d</option>
            <option value="i">i</option>
            <option value="erro">erro</option>
            <option value="erroAcumulado">erroAcumulado</option>
        </select>
        <input type="button" value="Adicionar Tentativa" onclick="clickAction('addDataset')">
        <input type="button" value="Remover Tentativas" onclick="clickAction('rmDataset')">

        <div class="dialog" id="addDataset">
            <form action="">
                <p>Disponíveis: X ~ Y</p>
                <input type="number" placeholder="Digite">
                <input type="submit" value="Adicionar">
            </form>
        </div>

        <div class="dialog" id="rmDataset">
            <form action="">
                <p>Selecione tentativas para remover:</p>
                <input type="checkbox" value="Tentativa X">Tentativa X <br>
                <input type="checkbox" value="Tentativa Y">Tentativa Y <br>
                <input type="checkbox" value="Tentativa Z">Tentativa Z <br>
                <input type="submit" value="Remover">
            </form>
        </div>

    </div>


    <br><br>

    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <script>
        var data = {
            labels: ["0s", "1s", "2s", "3s", "4s", "5s", "6s", "8s", "9s"],
            datasets: [{
                label: "Tentativa XX",
                fill: false,
                lineTension: 0,
                borderColor: "rgba(255,99,132,1)", //cor da linha
                borderWidth: 2,
                data: [65, 59, 20, 20, 56, 55, 40, 41, 42],
            }, {
                label: "Tentativa YY",
                fill: false,
                lineTension: 0,
                borderColor: "rgba(40,100,200,1)", //cor da linha
                borderWidth: 2,
                data: [65, 11, 15, 20, 30, 40, 50, 60, 42],
            }]

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
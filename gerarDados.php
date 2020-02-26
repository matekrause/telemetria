<?php

$conexao = conectar();

// EXEMPLO DE DADOS VALIDOS
// $string = "'0s', '1s', '2s', '3s', '4s', '5s', '6s', '8s', '9s'";
// $data = array(
//     array("Nome A", 1, 0, 255, 200, 1, 65, 54, 35, 10, 46, 10, 50, 20, 42),
//     array("Nome B", 1, 100, 0, 255, 1, 60, 57, 36, 30, 56, 45, 40, 10, 45),
//     array("Nome C", 1, 200, 100, 0, 1, 65, 50, 37, 40, 66, 44, 30, 12, 50),
//     array("Nome D", 1, 255, 200, 100, 1, 10, 20, 30, 20, 30, 20, 40, 50, 60)
// );
// $qntString = 9;
// $qntArrays = 4;


class data
{
    public $data;

    function generateData()
    {
        $this->data = array(
            // inserir dados de exemplo aqui
            // array("Nome A", 1, 0, 255, 200, 1, 65, 54, 35, 10, 46, 10, 50, 20, 42),
            // array("Nome B", 1, 100, 0, 255, 1, 60, 57, 36, 30, 56, 45, 40, 10, 45),
            // array("Nome C", 1, 200, 100, 0, 1, 65, 50, 37, 40, 66, 44, 30, 12, 50),
            // array("Nome D", 1, 255, 200, 100, 1, 10, 20, 30, 20, 30, 20, 40, 50, 0)
        );
    }

    function addData($idTentativa)
    {
        $conexao = conectar();
        $busca = "erroAcumulado";
        $sql = "SELECT $busca FROM master WHERE tentativa = '$idTentativa'";
        $result = mysqli_query($conexao, $sql);
        $name = "Nome X";

        //cor de perfil
        $r = rand(0,255);
        $g = rand(0,255);
        $b = rand(0,255);

        $values = array($name, 1, 0, $r, $g, $b);

        while ($registro = mysqli_fetch_assoc($result)) {
            //$values .= ", " . $registro["$busca"];
            array_push($values, $registro["$busca"]);
        }

        array_push($this->data, $values);
    }

    function getData()
    {
        return $this->data;
    }
}

function getFieldsInfo()
{
    //tem uma maneira mais fácil de fazer isso mas ja ta tarde tenho que dormir
    $velocidadeDesejada = $_GET["velocidadeDesejada"];
    $velocidadeMotorEsquerdo = $_GET["velocidadeMotorEsquerdo"];
    $velocidadeMotorDireito = $_GET["velocidadeMotorDireito"];
    $erroAcumulado = $_GET["erroAcumulado"];
    $erro = $_GET["erro"];
    $p = $_GET["p"];
    $d = $_GET["d"];
    $i = $_GET["i"];

    $resultsInfo = [
        "velocidadeDesejada" => "",
        "velocidadeMotorEsquerdo" => "",
        "velocidadeMotorDireito" => "",
        "erroAcumulado" => "",
        "erro" => "",
        "p" => "",
        "d" => "",
        "i" => "",
    ];

    if ($velocidadeDesejada != "") $resultsInfo[""] = "checked";
    if ($velocidadeMotorEsquerdo != "") $resultsInfo["velocidadeMotorEsquerdo"] = "checked";
    if ($velocidadeMotorDireito != "") $resultsInfo["velocidadeMotorDireito"] = "checked";
    if ($erroAcumulado != "") $resultsInfo["erroAcumulado"] = "checked";
    if ($erro != "") $resultsInfo["erro"] = "checked";
    if ($p != "") $resultsInfo["p"] = "checked";
    if ($d != "") $resultsInfo["d"] = "checked";
    if ($i != "") $resultsInfo["i"] = "checked";

    return $resultsInfo;

    //percebi que não é a forma mais facil de fazer mas to com preguiça de terminar
}

function generateString()
{
    return "'0s', '1s', '2s', '3s', '4s', '5s', '6s', '8s', '9s'";
}

function stringCount()
{
    //retornar quantidade de elementos na $string (gerado no index utilizando generateString())
    return 9;
}

function arraysCount()
{
    //retornar quantidade de linhas no array #data (gerado no index utilizando generateData())
    return 6;
}

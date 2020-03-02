<?php

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

    if ($velocidadeDesejada != "") $resultsInfo["velocidadeDesejada"] = "checked";
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

function getFieldsInfoArray()
{

    $velocidadeDesejada = $_GET["velocidadeDesejada"];
    $velocidadeMotorEsquerdo = $_GET["velocidadeMotorEsquerdo"];
    $velocidadeMotorDireito = $_GET["velocidadeMotorDireito"];
    $erroAcumulado = $_GET["erroAcumulado"];
    $erro = $_GET["erro"];
    $p = $_GET["p"];
    $d = $_GET["d"];
    $i = $_GET["i"];

    $arrayFields = array();

    if ($velocidadeDesejada != "") array_push($arrayFields, "velocidadeDesejada");
    if ($velocidadeMotorEsquerdo != "") array_push($arrayFields, "velocidadeMotorEsquerdo");
    if ($velocidadeMotorDireito != "") array_push($arrayFields, "velocidadeMotorDireito");
    if ($erroAcumulado != "") array_push($arrayFields, "erroAcumulado");
    if ($erro != "") array_push($arrayFields, "erro");
    if ($p != "") array_push($arrayFields, "p");
    if ($d != "") array_push($arrayFields, "d");
    if ($i != "") array_push($arrayFields, "i");

    return $arrayFields;
}

function getTentativasInfoArray(){
    $array = array();

    
    $conexao = conectar();
    $sql = "SELECT max(tentativa) AS resp FROM master;";
    $result = mysqli_query($conexao, $sql);
    $i = mysqli_fetch_assoc($result);
    $i = $i["resp"];

    $a= 0;
    while($a < $i){
        $a++;
        if(isset($_GET["tentativa$a"])){
            if($_GET["tentativa$a"] == "on") array_push($array, $a);
        }
    }

    return $array;

}


function generateString($tentativasArray)
{

    $conexao = conectar();

    $previous = 0;

    foreach ($tentativasArray as $tentativa) {
        $sql = "SELECT TIMESTAMPDIFF(MICROSECOND, (SELECT MAX(tempo) FROM master WHERE $tentativa = 1) , (SELECT MIN(tempo) FROM master WHERE $tentativa = 1)) / 1000;";
        $result = mysqli_query($conexao, $sql);

        if ($result > $previous) {
            $biggerTentativa = $tentativa;
        }
    }

    $sql = "SELECT tempo FROM master WHERE tentativa = $biggerTentativa";
    $result = mysqli_query($conexao, $sql);

    while ($registro = mysqli_fetch_assoc($result)) {
        //valor padrao do resultado: 2020-02-26 00:00:00.001
        $string .= "'" . substr($registro["tempo"], -5) . "s', ";
    }

    $string = substr($string, 0, -2);

    return $string;
}

function stringCount($tentativasArray)
{
    //retornar quantidade de elementos na $string (gerado no index utilizando generateString())
    $conexao = conectar();

    $previous = 0;

    foreach ($tentativasArray as $tentativa) {
        $sql = "SELECT TIMESTAMPDIFF(MICROSECOND, (SELECT MAX(tempo) FROM master WHERE $tentativa = 1) , (SELECT MIN(tempo) FROM master WHERE $tentativa = 1)) / 1000;";
        $result = mysqli_query($conexao, $sql);

        if ($result > $previous) {
            $biggerTentativa = $tentativa;
        }
    }

    $sql = "SELECT COUNT(tempo) AS numero FROM master WHERE tentativa = '$biggerTentativa'";
    $result = mysqli_query($conexao, $sql);
    $resposta = mysqli_fetch_assoc($result);

    return $resposta["numero"];
}

function arraysCount($data)
{
    //retornar quantidade de linhas no array #data (gerado no index utilizando createData())
    $array = $data->getData();
    return count($array);
}
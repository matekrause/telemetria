<?php

class Data
{
    private $data;
    public $maxValue;

    function createData()
    {
        $this->data = array(
            // inserir dados de exemplo aqui
            // array("Nome A", '1', 0, 255, 200, 1, 65, 54, 35, 10, 46, 10, 50, 20, 42),
            // array("Nome B", 1, 100, 0, 255, 1, 60, 57, 36, 30, 56, 45, 40, 10, 45),
            // array("Nome C", 1, 200, 100, 0, 1, 65, 50, 37, 40, 66, 44, 30, 12, 50),
            // array("Nome D", 1, 255, 200, 100, 1, 10, 20, 30, 20, 30, 20, 40, 50, 0)
        );
    }

    function addData($idTentativa, $resultsInfoArray)
    {
        $conexao = conectar();

        foreach ($resultsInfoArray as $atualValue) {
            $busca = $atualValue;
            $sql = "SELECT $busca FROM master WHERE tentativa = '$idTentativa'";
            $result = mysqli_query($conexao, $sql);
            $name = "Tentativa $idTentativa";

            //cor de perfil
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);

            $values = array($name, 1, $r, $g, $b, 1);

            while ($registro = mysqli_fetch_assoc($result)) {
                //$values .= ", " . $registro["$busca"];
                if($registro["$busca"] > $this->maxValue) $this->maxValue = $registro["$busca"];
                array_push($values, $registro["$busca"]);
            }

            array_push($this->data, $values);
        }
    }

    function getData()
    {
        return $this->data;
    }

}

?>
<?php

    function conectar() {

        $conexao = mysqli_connect("localhost", "root", "123123", "telemetriabd");

        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, "SET character_set_connection=utf8");
        mysqli_query($conexao, "SET character_set_client=utf8");
        mysqli_query($conexao, "SET character_set_results=utf8");

        return $conexao;

    }

?>

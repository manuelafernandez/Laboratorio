<?php

/**Conexion con la base de datos */
include_once("../labo/conexionDB.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actualizar'])) {
    if (!empty($_POST['dni'])) {
        if (!isset($_POST['dni'])) { } else {
            $dni = $_POST["dni"];
            $sql = "SELECT nombreapellido,sexo,fechanacimiento,localidad,domicilio,celular,mail FROM clientes WHERE documento='$dni'";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                // output data of each row
                while ($row = $resultado->fetch_assoc()) {
                    $nombreapellido =  $row["nombreapellido"];
                    $sexo = $row["sexo"];
                    $fechanacimiento = $row["fechanacimiento"];
                    $localidad = $row["localidad"];
                    $domicilio = $row["domicilio"];
                    $celular = $row["celular"];
                    $mail = $row["mail"];
                }

                if (isset($_POST['nombreapellido']))
                    $nombreapellido = $_POST["nombreapellido"];

                if (isset($_POST['sexo']))
                    $sexo = $_POST["sexo"];

                if (isset($_POST['fechanacimiento']))
                    $fechanacimiento = $_POST["fechanacimiento"];

                if (isset($_POST['localidad']))
                    $localidad = $_POST["localidad"];

                if (isset($_POST['domicilio']))
                    $domicilio = $_POST["domicilio"];

                if (isset($_POST['celular']))
                    $celular = $_POST["celular"];

                if (isset($_POST['mail']))
                    $mail = $_POST["mail"];

                $e = 0;

                $sql = "UPDATE `clientes` SET `nombreapellido` = '$nombreapellido', `documento` = '$dni', `sexo` = '$sexo', `fechanacimiento` = '$fechanacimiento', `edad` = '$e', `localidad` ='$localidad', `domicilio`= '$domicilio', `celular`='$celular', `mail` = '$email' 
                WHERE `documento` = '$dni'"; 
                $conn->query($sql);

               
            }
        }
    }
    Header("Location: buscar.html");
}

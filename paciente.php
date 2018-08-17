<?php

    /**Conexion con la base de datos */
    include_once("../Laboratorio/conexionDB.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['guardar']))
    {
     
        $nombreapellido = $_POST["nombreapellido"];
        $documento = $_POST["documento"];
        $sexo = $_POST["sexo"];
        $nacimiento = $_POST["nacimiento"];
        $edad = $_POST["edad"];
        $localidad = $_POST["localidad"];
        $domicilio = $_POST["domicilio"];
        $celular = $_POST["celular"];
        $mail = $_POST["mail"];

        $sql = "INSERT INTO pacientes(nombreapellido, documento, sexo, fechanacimiento, edad, localidad, domicilio, celular, mail) 
        VALUES ('$nombreapellido','$documento','$sexo','$nacimiento','$edad','$localidad','$domicilio','$celular','$mail')";
        $conn->query($sql);

        Header("Location: gestion.html"); 

    }

?>
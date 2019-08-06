<?php

    /**Conexion con la base de datos */
    include_once("../labo/conexionDB.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['guardar']))
    {
     
        $nombreapellido = $_POST["nombreapellido"];
        $documento = $_POST["documento"];
        $sexo = $_POST["sexo"];
        $nacimiento = $_POST["nacimiento"];
        $e = 0;
        $edad = busca_edad($e); //VERRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
        $localidad = $_POST["localidad"];
        $domicilio = $_POST["domicilio"];
        $celular = $_POST["celular"];
        $mail = $_POST["mail"];

        $sql = "INSERT INTO clientes(nombreapellido, documento, sexo, fechanacimiento, edad, localidad, domicilio, celular, mail) 
        VALUES ('$nombreapellido','$documento','$sexo','$nacimiento','$edad','$localidad','$domicilio','$celular','$mail')";
        $conn->query($sql);

        Header("Location: analisis.html"); 

    }

    function busca_edad($fecha_nacimiento){
        $dia=date("d");
        $mes=date("m");
        $ano=date("Y");
        
        
        $dianaz=date("d",strtotime($fecha_nacimiento));
        $mesnaz=date("m",strtotime($fecha_nacimiento));
        $anonaz=date("Y",strtotime($fecha_nacimiento));
        
        
        //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
        
        if (($mesnaz == $mes) && ($dianaz > $dia)) {
        $ano=($ano-1); }
        
        //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
        
        if ($mesnaz > $mes) {
        $ano=($ano-1);}
        
         //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
        
        $edad=($ano-$anonaz);
        
        
        return $edad;
        
        
        }

?>
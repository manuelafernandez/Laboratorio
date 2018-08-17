<?php

    /**Conexion con la base de datos */
    include_once("../Laboratorio/conexionDB.php");
    
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['buscar']))
    {
     
        $documento = $_POST["documento"];
        $sql = "SELECT nombreapellido FROM pacientes WHERE documento='$documento'";
        $resultado = $conn->query($sql);
    
        if ($resultado->num_rows > 0) {
            // output data of each row
            while($row = $resultado->fetch_assoc()) {

                $_SESSION['nombreapellido'] = $row["nombreapellido"];
                $_SESSION['fecha'] = getdate();
                $_SESSION['documento'] = $documento;
                $_SESSION['mail'] = $row["mail"];
                Header("Location: prueba.html"); 
            }
        } else {
            Header("Location: paciente.html"); 
        }
    
        //Header("Location: gestion.html"); 

    }

?>
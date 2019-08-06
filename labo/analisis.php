<?php

    /**Conexion con la base de datos */
    include_once("../labo/conexionDB.php");
    
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['buscar']))
    {
     
        if(empty($_POST['documento'])) { 
            if(!isset($_POST['nombreapellido'])) { 
            }else {
                $nombreapellido = $_POST["nombreapellido"];
                $sql = "SELECT documento,mail FROM clientes WHERE nombreapellido='$nombreapellido'";
                $resultado = $conn->query($sql);
        
                if ($resultado->num_rows > 0) {
                    // output data of each row
                    while($row = $resultado->fetch_assoc()) {
    
                        $_SESSION['nombreapellido'] = $nombreapellido;
                    // $_SESSION['fecha'] = getdate();
                        $_SESSION['documento'] = $row["documento"];
                        $_SESSION['mail'] = $row["mail"];
    
                        Header("Location: gestion.html"); 
                    }
                } else {
                    Header("Location: paciente.html"); 
                }
            }
        }else {
            $documento = $_POST["documento"];
            $sql = "SELECT nombreapellido,mail FROM clientes WHERE documento='$documento'";
            $resultado = $conn->query($sql);
    
            if ($resultado->num_rows > 0) {
                // output data of each row
                while($row = $resultado->fetch_assoc()) {

                    $_SESSION['nombreapellido'] = $row["nombreapellido"];
                // $_SESSION['fecha'] = getdate();
                    $_SESSION['documento'] = $documento;
                    $_SESSION['mail'] = $row["mail"];
                    Header("Location: gestion.html"); 
                }
            } else {
                Header("Location: paciente.html"); 
            }
        }
       
    }

?>
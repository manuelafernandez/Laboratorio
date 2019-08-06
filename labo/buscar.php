<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comprobante</title>

    <!-- Icono -->
    <link rel="icon" type="image/png" href="images/icono.png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <div class="top-right links">
      <a href="home.html">Principal</a>
    </div>

    <br>
    
    <div class="row justify-content-md-center">
        <div class="col-6">
            <div class="text-center"><h3>Ficha del paciente</h3></div>

                <?php
                /**Conexion con la base de datos */
                include_once("../labo/conexionDB.php");

                if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['buscar'])) {

                    if (!empty($_POST['dni'])) {
                        if (!isset($_POST['dni'])) { } else {
                            $dni = $_POST["dni"];
                            $sql = "SELECT nombreapellido,sexo,fechanacimiento,localidad,domicilio,celular,mail FROM clientes WHERE documento='$dni'";
                            $resultado = $conn->query($sql);

                            if ($resultado->num_rows > 0) {
                                // output data of each row
                                while ($row = $resultado->fetch_assoc()) {
                                    $paciente = '';
                                    $nombreapellido =  $row["nombreapellido"];
                                    $sexo = $row["sexo"];
                                    $fechanacimiento = $row["fechanacimiento"];
                                    $localidad = $row["localidad"];
                                    $domicilio = $row["domicilio"];
                                    $celular = $row["celular"];
                                    $mail = $row["mail"];
                                }
                            } else {
                                $paciente = 'No se encontro paciente ';
                                $nombreapellido =  '-';
                                $sexo = '-';
                                $fechanacimiento = '-';
                                $localidad = '-';
                                $domicilio = '-';
                                $celular = '-';
                                $mail = '-';
                                $dni = '-';
                            }
                        }
                    } else {
                        $paciente = 'No se encontro paciente';
                        $nombreapellido =  '-';
                        $sexo = '-';
                        $fechanacimiento = '-';
                        $localidad = '-';
                        $domicilio = '-';
                        $celular = '-';
                        $mail = '-';
                        $dni = '-';
                    }
                }
                ?>

                <form action="actualizar.php" method="post">
                    <div class="form-group row">                  
                        <label for="nombreapellido">Nombre y apellido</label>
                        <input type="text" class="form-control" id="nombreyapellido" name="nombreyapellido" placeholder="<?php echo $nombreapellido; ?>">
                    </div>

                    <fieldset disabled>
                    <div class="form-group row">                  
                        <label for="dni">Número de documento</label>
                        <input type="number" class="form-control" id="dni" name="dni" value="<?php echo $dni; ?>">
                    </div>
                    </fieldset>

                    <div class="form-group row">                  
                        <label for="sexo">Sexo</label>
                        <input type="text" class="form-control" id="sexo" name="sexo" placeholder="<?php echo $sexo; ?>">
                    </div>

                    <div class="form-group row">                  
                        <label for="fechanacimiento">Fecha de nacimiento: <?php echo $fechanacimiento; ?></label>
                        <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" placeholder="<?php echo $fechanacimiento; ?>">
                    </div>
            
                    <div class="form-group row">  
                        <div class="col">                
                            <label for="domicilio">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="<?php echo $domicilio; ?>">  
                        </div>                
          
                         <div class="col">                
                            <label for="localidad">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" placeholder="<?php echo $localidad; ?>">  
                        </div>                
                    </div>
                    
                    <div class="form-group row">                  
                        <label for="celular">Celular</label>
                        <input type="number" class="form-control" id="celular" name="celular" placeholder="<?php echo $celular; ?>">
                    </div>

                    <div class="form-group row">                  
                        <label for="mail">E-mail</label>
                        <input type="email" class="form-control" id="mail" name="mail" placeholder="<?php echo $mail; ?>">
                    </div>

                    <div class="text-center">
                        <button type="submit" name="actualizar" class="btn btn-success">Editar paciente</button>
                        <a href="buscar.html" class="btn btn-success">Volver</a>
                    </div>
                    <br><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>

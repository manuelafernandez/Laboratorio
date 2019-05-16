<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
session_start();

/**Conexion con la base de datos */
include_once("../labo/conexionDB.php");

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      $image_file = K_PATH_IMAGES.'tcpdf_logo.jpg';
      $this->Image($image_file, 5, 10, 30, 15, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // Set font
      $this->SetFont('courier', '', 20);
      // Title
      //$this->MultiCell(0, 15, 'Laboratorio de Análisis Clínicos', 0, 'C', 0, 1, '', '', false);
      $this->Write(0, 'Laboratorio de Análisis Clínicos', '', 0, 'R', true, 0, false, false, 0);
      //Subtitulo
      $this->SetFont('courier', '', 10);
      $this->MultiCell(0, 15, '9 de Julio 1073 - Campana - Tel.: 03489 - 468523', 'B', 'C', 0, 2, '' ,15, false);
      $this->MultiCell(0, 15, 'E-mail: laboratorio.laccampana@gmail.com', 'B', 'C', 0, 2, '' ,15, false);
  }

    // Page footer
    public function Footer() {
        // Position at 20 mm from bottom
        $this->SetY(-30);
        // Set font
        $this->SetFont('courier', '', 10);
        // Page number
        $this->MultiCell(0, 10, 'Alejandra Fernández        Paula Girardi'."\n".'BIOQUIMICA               BIOQUIMICA'."\n".'M.P.: 6237               M.P.: 7256', '', 'C', 0, 1, '' ,'', false);

        $this->SetFont('courier', '', 8);
        $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', false, 'C', 0, '', 0, false, 'T', 'M');
      }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------

// set font
$pdf->SetFont('courier', '', 10);

// add a page
$pdf->AddPage();

//recupero la informacion de la sesion
/*
$nombreapellido = 'Paciente: '.$_SESSION["nombreapellido"];
$documento = 'DNI: '.$_SESSION["documento"];
$protocolo = 'Protocolo N: ';
$dra = 'Solicita Dr/a.: ';
if(!empty($_POST['doc']))
    $dra = 'Solicita Dr/a.: '.$_POST['doc'];   
    
$fe=date("m/d/Y");
$fecha = 'Fecha: '.$fe;
$mail = 'E-mail: '.$_SESSION["mail"];

$pdf->Ln(5);
$pdf->Write(0, $nombreapellido, '', 0, '', true, 0, false, false, 0);
$pdf->Write(0, $documento, '', 0, '', true, 0, false, false, 0);
$pdf->Write(0, $mail, '', 0, '', true, 0, false, false, 0);

$pdf->Ln(5);
$pdf->Write(0, $protocolo, '', 0, '', true, 0, false, false, 0);

if(!empty($_POST['doc']))
    $dra = 'Solicita Dr/a.: '.$_POST['doc'];   

$pdf->Write(0, $dra, '', 0, '', true, 0, false, false, 0);
$pdf->Cell(0, 0, $fecha, 'B', false, 'L', 0, '', 0, false, 'T', 'M');  
*/

//recupero la informacion de la sesion
/*
$sql = "SELECT numprotocolo FROM protocolo WHERE id=1";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
   while($row = $resultado->fetch_assoc()) {
        $numprot = $row["numprotocolo"];
   }
}
else {
    $numprot=5;
    $id=1;
    $sql = "INSERT INTO protocolo(numprotocolo,id) VALUES ('$numprot','$id')";
    $conn->query($sql);
}

$sql = "UPDATE protocolo SET numprotocolo=$numprot+1 WHERE id=1";

if (mysqli_query($conn, $sql)) {
} else {
    echo "Error en el numero de protocolo: " . mysqli_error($conn);
}
*/
// sql to delete a record
//$sql = "DELETE FROM protocolo WHERE id=1";


    $protocolo = 'Protocolo N: ';

    if(!empty($_POST['doc']))
        $protocolo = 'Protocolo N: '.$_POST["numeroprotocolo"];
        
    $nombreapellido = 'Paciente: '.$_SESSION["nombreapellido"];

    $dra = 'Solicita Dr/a.: ';
    if(!empty($_POST['doc']))
        $dra = 'Solicita Dr/a.: '.$_POST['doc']; 
    $documento = 'DNI: '.$_SESSION["documento"].'                           '.$dra;

    //$fe=date("d/m/Y");

    $fecha = 'Fecha: ';
    if(!empty($_POST['fecha'])){   
        $fe = $_POST['fecha'];
        $f =  date("d/m/Y", strtotime($_POST['fecha']));
        $fecha = 'Fecha: '.$f;
    }
    $mail = $fecha.'                       '.$protocolo;

    $pdf->Ln(5);
    $pdf->Write(0, $nombreapellido, '', 0, '', true, 0, false, false, 0);
    $pdf->Write(0, $documento, '', 0, '', true, 0, false, false, 0);
    $pdf->Cell(0, 0, $mail, 'B', false, 'L', 0, '', 0, false, 'T', 'M');  

//------------------------------------------------------------

$pdf->Ln(1);
 
if(!isset($_POST['checkHemograma'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}
else {
    // set font
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 14);
    $nombre = 'HEMOGRAMA';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $pdf->SetFont('courier', '', 12);
    $nombre = 'Hematies     : '.$_POST['resultHematies'].' por mm3'.'    Vol.corp.Medio   :  '.$_POST['resultVCM'].' f/l';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Hematocrito  : '.$_POST['resultHematocrito'].' %'.'               Hb.corp.media    :  '.$_POST['resultHCM'].' pg';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Hemoglobina  : '.$_POST['resultHemoglobina'].' gr/100ml'.'      Conc. Hb corp.   :  '.$_POST['resultCHCM'].' g/dl';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $pdf->Ln(4);

    $nombre = 'Glob. blancos  : '.$_POST['resultGlobBlancos'].' por mm3';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    //PLAQUETAS

    $pdf->Ln(4);

    $pdf->SetFont('courier', '', 12);
    $nombre = 'Fórmula leucocitaria             Relativa            Absoluta';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->Ln(4);

    $result = ($_POST['resultGlobBlancos']*$_POST['resultBasofilosR'])/100;
    $nombre = 'Basofilos        :                   '.$_POST['resultBasofilosR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $result = ($_POST['resultGlobBlancos']*$_POST['resultEosinofilosR'])/100;
    $nombre = 'Eosinofilos      :                   '.$_POST['resultEosinofilosR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $result = ($_POST['resultGlobBlancos']*$_POST['resultNeutrofilosCR'])/100;
    $nombre = 'Neutr.en Cayado  :                   '.$_POST['resultNeutrofilosCR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $result = ($_POST['resultGlobBlancos']*$_POST['resultNeutrofilosSR'])/100;
    $nombre = 'Neutr.Segmentados:                   '.$_POST['resultNeutrofilosSR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $result = ($_POST['resultGlobBlancos']*$_POST['resultLinfocitosR'])/100;
    $nombre = 'Linfocitos       :                   '.$_POST['resultLinfocitosR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    $result = ($_POST['resultGlobBlancos']*$_POST['resultMonocitosR'])/100;
    $nombre = 'Monocitos        :                   '.$_POST['resultMonocitosR'].' %            '.$result;
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

    if(!isset($_POST['checkPlaquetas'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'RECUENTO DE PLAQUETAS  : '.$_POST['resultPlaquetas'].' mm3';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Analizador Mindray BC-5380'."\n".'        Valor de referencia: 150.000 A 350.000 mm3 mm3';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkMMicroscopica'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Morfologia microscopica  : '.$_POST['resultMMicroscopica'];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
}

if($pdf->getY()+5>250){
$pdf->addPage();
$pdf->Ln(7);
}

    if(!isset($_POST['checkEritrosedimentacionP'])) { 
        if(!isset($_POST['checkEritrosedimentacionS'])) { 
        }else {
            $pdf->SetFont('courier', '', 12);
            $pdf->Ln(5);
            $nombre = 'ERITROSEDIMENTACION  (Método Westergreen)';
            $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
            $pdf->Ln(4);
            $nombre = 'Segunda hora             : '.$_POST['resultEritrosedimentacionS']."\n";
            $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        }
    }else {
        $pdf->SetFont('courier', '', 12);
        $pdf->Ln(5);
        $nombre = 'ERITROSEDIMENTACION  (Método Westergreen)';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->Ln(4);
        $nombre = 'Primera hora             : '.$_POST['resultEritrosedimentacionP']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

        if(!isset($_POST['checkEritrosedimentacionS'])) { 
        }else {
            $nombre = 'Segunda hora             : '.$_POST['resultEritrosedimentacionS']."\n";
            $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        }
    }



    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    $pdf->SetFont('courier', '', 12);
    if(!isset($_POST['checkGlucemia'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'GLUCEMIA                 : '.$_POST['resultGlucemia'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Enzimatico GOD-POD'."\n".'        Valor de referencia: de 70 a 110 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkUremia'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'UREMIA                   : '.$_POST['resultUremia'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: CINETICO UV'."\n".'        Valor de referencia: de 15 a 55 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkAUrico'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'ÁCIDO ÚRICO              : '.$_POST['resultAUrico'].' mg/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Enzimatico'."\n".'        Valor de referencia: Hombre = 2,5 a 7,0 mg/100 ml'."\n".'                             Mujer = 2,0 a 6,0 mg/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkCreatinina'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'CREATININA               : '.$_POST['resultCreatinina'].' mg/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Cinetico'."\n".'        Valor de referencia: 0,80 a 1,40 mg/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkColesterol'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'COLESTEROL               : '.$_POST['resultColesterol'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Enzimatico CHOD-PAP'."\n".'        Valor de referencia: 160 a 220 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkColesterolHDL'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'COLESTEROL LIGADO A HDL  : '.$_POST['resultColesterolHDL'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Valor de referencia: Hombre = 30 a 65 mg/dl'."\n".'                             Mujer = 30 a 80 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkColesterolLDL'])) {
    }else {
        $pdf->Ln(5);
        $nombre = 'COLESTEROL LDL           : '.$_POST['resultColesterolLDL'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Valor de referencia: Riesgo bajo o nulo: menor a 140 mg/dl'."\n".'                             Riesgo moderado: 140 a 190 mg/dl'."\n".'                             Riesgo elevado: mayor a 190 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkTrigliceridos'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'TRIGLICERIDOS            : '.$_POST['resultTrigliceridos'].' mg/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Enzimatico'."\n".'        Valor de referencia: hasta 150 mg/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if(!isset($_POST['checkHepatograma'])) {
       }
       else {
           $pdf->Ln(5);
           $pdf->SetFont('helvetica', 'B', 14);
           $nombre = 'HEPATOGRAMA COMPLETO';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
           $pdf->SetFont('courier', '', 12);
       }

       if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    if(!isset($_POST['checkBilirrubinemia'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'BILIRRUBINEMIA             '."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 10);
        $total=$_POST['resultBilirrubinemiaD']+$_POST['resultBilirrubinemiaI'];
        $nombre = 'Directa                                      : '.$_POST['resultBilirrubinemiaD'].' mg/dl  V.R.: hasta 0.30'."\n".'Indirecta                                    : '.$_POST['resultBilirrubinemiaI'].' mg/dl  V.R.: hasta 0.70'."\n".'Total                                        : '.$total.' mg/dl  V.R.: hasta 1.00'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkColesterolHC'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'COLESTEROL                           : '.$_POST['resultColesterolHC'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Enzimatico CHOD-PAP'."\n".'        Valor de referencia: 160 a 220 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkTGO'])) {
    }else {
        $pdf->Ln(5);
        $nombre = 'TRANSAMINASA GLUTAMICO OXALACETICA   : '.$_POST['resultTGO'].' mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: DGKC'."\n".'        Valor de referencia: hasta 50 mU/ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkTGP'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'TRANSAMINASA GLUTAMICO PIRUVICA      : '.$_POST['resultTGP'].' mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: DGKC'."\n".'        Valor de referencia: hasta 50 mU/ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      
    if(!isset($_POST['checkFosfatasa'])) {
    }else {
        $pdf->Ln(5);
        $nombre = 'FOSFATASA ALCALINA                   : '.$_POST['resultFosfatasa'].' mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Cinetico IFCC -'."\n".'        Valor de referencia: Adultos = 60 a 300 mU/ml'."\n".'                             Niños y adolescentes = hasta 645 mU/ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkProteinas'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'PROTEINAS TOTALES                    : '.$_POST['resultProteinas'].' gr/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Gornall'."\n".'        Valor de referencia: de 6.5 a 7.8 gr/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkAlbumina'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'ALBUMINA                             : '.$_POST['resultAlbumina'].' gr/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Verde de Bromo Cresol'."\n".'        Valor de referencia: de 3,70 a 5,50 gr/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkGlobulinas'])) { 
    }else {
        $pdf->Ln(5);
        $globulina = $_POST['resultProteinas'] - $_POST['resultAlbumina'];
        $nombre = 'GLOBULINAS TOTALES                   : '.$globulina.' gr/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkRelacionAG'])) { 
    }else {
        $pdf->Ln(5);
        $totale = $_POST['resultAlbumina']/$globulina;
        $total = number_format($totale, 2, '.', '');
        $nombre = 'Relación Albumina/Globulina          : '.$total.' gr/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      
      if(!isset($_POST['checkAlfaAmilasa'])) { // Comprobamos si el nombre esta vacio
        // Aqui saltaria el error ya que el campo nombre esta vacio
    }else {
        $pdf->Ln(5);
        $pdf->SetFont('courier', '', 12);
        $nombre = 'ALFA AMILASA                         :'.$_POST['resultAlfaAmilasa'].' Unidades/l'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Cinetico 405 IFCC'."\n".'         Valor de referencia: de 60 a 160 Unidades/l'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkGGTP'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'GAMMA GUTAMIL TRANS PEP. -GGT-       : '.$_POST['resultGGTP'].' mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: SZASZ'."\n".'         Valor de referencia: Hombres: 6 a 28 mU/ml'."\n".'                              Mujeres: 4 a 18 mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkCalcemia'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'CALCEMIA                             : '.$_POST['resultCalcemia'].' mg/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Colorimétrico CFX'."\n".'        Valor de referencia: de 8,50 a 10,50 mg/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkFosforo'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'FOSFORO                              : '.$_POST['resultFosforo'].' mg/100 ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: U.V.'."\n".'        Valor de referencia: Adultos = 3,0 - 4,5 mg/100 ml'."\n".'                             Niños = 4,0 - 6,5 mg/100 ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkMagnesio'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'MAGNESIO SERICO                      : '.$_POST['resultMagnesio'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Orange - Rhein Mod.'."\n".'        Valor de referencia: de 1,58 a 2,55 mg/dl';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkIonograma'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'IONOGRAMA PLASMATICO'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = 'Método: Ión Selectivo (DIESTRO 103 AP)'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 12); 

        $nombre = 'Sodio                                : '.$_POST['resultSodio'].' meq/l';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $total = '        Valor de referencia: de 135 a 148 meq/l'."\n";
        $pdf->Write(0, $total, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
        
        $nombre = 'Potasio                              : '.$_POST['resultPotasio'].' meq/l';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $total = '        Valor de referencia: de 3,70 a 5,30 meq/l'."\n";
        $pdf->Write(0, $total, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);

        $nombre = 'Cloro                                : '.$_POST['resultCloro'].' meq/l';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $total = '        Valor de referencia: de 98 a 109 meq/l'."\n";
        $pdf->Write(0, $total, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkCPK'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'CREATINFOSFOKINASA -CPK-             : '.$_POST['resultCPK'].' mU/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: CINETICO U.V.'."\n".'        Valor de referencia: Varones: 24 - 195 mU/ml'."\n".'                             Mujeres: 24 - 170 mU/ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkLactatoD'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'Lactato Deshidrogenasa -LDH-         : '.$_POST['resultLactatoD'].' U/l'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: U.V. Optimizado'."\n".'        Valor de referencia: 230 - 460 U/l';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      if(!isset($_POST['checkOrina24'])) { 
       }
       else {
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 14);
            $nombre = 'EXAMEN COMPLETO DE ORINA 24HS.';
            $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
            $pdf->SetFont('courier', '', 12);       
        }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      if(!isset($_POST['checkVol24hs'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'Volumen                              : '.$_POST['resultVol24hs']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkPeso'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'Peso                                 : '.$_POST['resultPeso']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    
    if(!isset($_POST['checkAltura'])) {
    }else {
        $pdf->Ln(5);
        $nombre = 'Altura                               : '.$_POST['resultAltura']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    
        
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkDosajeCO'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE DE CALCIO EN ORINA            : '.$_POST['resultDosajeCO'].' mg/ 24hs'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Método complexométrico'."\n".'        Valor de referencia: de 60 a 200 mg /24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->Ln(4);
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkDosajeFO'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE DE FOSFORO EN ORINA           : '.$_POST['resultDosajeFO'].' g /24hs'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: U.V.'."\n".'        Valor de referencia: de 0,34 a 1,0 g /24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkMagnesioO'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE DE MAGNESIO EN ORINA                    : '.$_POST['resultMagnesioO'].' mg /24hs'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: DMANN AUTOMATIZADO'."\n".'        Valor de referencia: de 50 - 150 mg /24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    if(!isset($_POST['checkDosajePU'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE DE PROTEINAS URINARIAS        : '.$_POST['resultDosajePU'].' g/24hs'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: rojo de Pirogalol'."\n".'        Valor de referencia: hasta 0.20 g/24hs'."\n".'                             Hasta 200 mg/24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->Ln(4);
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkDosajeAO'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE ALBUMINA EN ORINA             : '.$_POST['resultDosajeAO'].' mg/24hs'."\n".'         (Microalbuminuria)'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: CLIA'."\n".'        Valor de referencia: hasta 30.0 mg/24hs'."\n".'                             Orina espontanea: Hasta 20 mg/l. mg/24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->Ln(4);
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    
    if(!isset($_POST['checkDosajeAUO'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'DOSAJE DE ACIDO URICO EN ORINA       : '.$_POST['resultDosajeAUO'].' mg/24hs %'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Valor de referencia: 250 a 750 mg/24hs %';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
//-------------------------------------------------------------------------------
  

 if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkCreatinuriag/24'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'CREATINURIA                          : '.$_POST['resultCreatinuriag/24'].' g/24 hs'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '        Método: Cinético'."\n".'        Valor de referencia: 0.50 a 2.00 g/24hs';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

   if(!isset($_POST['checkCreatinuriamg/dl'])) { 
    }else {
    $pdf->Ln(5);
    $nombre = 'CREATININURIA                        : '.$_POST['resultCreatinuriamg/dl'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Método: Cinético'."\n".'        Valor de referencia: 0.50 a 1.40 mg/dl';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    }

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }


if(!isset($_POST['checkDepuracion'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'CLEARENCE DE CREATININA              : '.$_POST['resultDepuracion'].' ml/min'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: mayor de 60 ml/min';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
if(!isset($_POST['checkRAC'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'RAC - Razon Albumina/Creatinina      : '.$_POST['resultRAC'].' mg/g'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: < 30 mg/g';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(empty($_POST['obsorina'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'OBSERVACIONES:'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $nombre = ''.$_POST['obsorina'];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }


// if(!isset($_POST['checkCreatininaU'])) {
// }else {
//     $pdf->Ln(5);
//     $nombre = 'CREATININA URINARIA                  : '.$_POST['resultCreatininaU'].' g/24hs %'."\n";
//     $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
//     $pdf->SetFont('courier', '', 8);
//     $nombre = '        Método: Cinético'."\n".'        Valor de referencia: 0.80 a 2.0 g/24hs %';
//     $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
//     $pdf->SetFont('courier', '', 12);
// }

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  if(!isset($_POST['checkOrina'])) { 
   }
   else {
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 14);
        $nombre = 'EXAMEN COMPLETO DE ORINA';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);       
    }
  
 if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

if(!isset($_POST['checkEFQO'])) { 
}else {
        $pdf->Ln(5);
        $nombre = 'EXAMEN FISICO QUIMICO ORGANOLEPTICO';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $nombre = 'Color          : '.$_POST['resultColor']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $nombre = 'Aspecto        : '.$_POST['resultAspecto']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $nombre = 'p.H.           : '.$_POST['resultPH']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $nombre = 'Densidad a 25 C: '.$_POST['resultDensidad']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

if(!isset($_POST['checkEFQ'])) {
}else {
    $pdf->Ln(5);
    $nombre = 'EXAMEN FISICO QUIMICO';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    
    $num = 'No contiene';
    if(!empty($_POST['resultProteinasO']))
        $num = $_POST['resultProteinasO'];
    
    $num2 = 'No contiene';
    if(!empty($_POST['resultGlucosuria']))
        $num2 = $_POST['resultGlucosuria'];

    $nombre = 'Proteinas      : '.$num.'     Glucosuria     : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No contiene';
        if(!empty($_POST['resultAcetona']))
            $num = $_POST['resultAcetona'];
        
        $num2 = 'No contiene';
        if(!empty($_POST['resultPig']))
            $num2 = $_POST['resultPig'];
    
    $nombre = 'Acetonas       : '.$num.'     Pig.biliares   : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No contiene';
        if(!empty($_POST['resultUrobilina']))
            $num = $_POST['resultUrobilina'];
        
        $num2 = 'No contiene';
        if(!empty($_POST['resultHemoglobinaO']))
            $num2 = $_POST['resultHemoglobinaO'];
    

    $nombre = 'Urobilina      : '.$num.'     Hemoglobina    : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->Ln(4);
}
    
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkESU'])) {
    }else {
    $pdf->Ln(5);
    $nombre = 'EXAMEN MICROSCOPICO DEL SEDIMENTO URINARIO';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No se observan';
        if(!empty($_POST['resultCel']))
            $num = $_POST['resultCel'];
        
        $num2 = 'No se observan';
        if(!empty($_POST['resultLeucocitosO']))
            $num2 = $_POST['resultLeucocitosO'];
    
        $nombre = 'Cel.Epiteliales: '.$num."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

        if($pdf->getY()+5>250){
            $pdf->addPage();
            $pdf->Ln(7);
          }

        $nombre = 'Leucocitos     : '.$num2."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 


    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No se observan';
        if(!empty($_POST['resultPiocitos']))
            $num = $_POST['resultPiocitos'];
        
        $num2 = 'No se observan';
        if(!empty($_POST['resultHematiesO']))
            $num2 = $_POST['resultHematiesO'];
    
    $nombre = 'Hematies       : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    $nombre = 'Piocitos       : '.$num."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No se observan';
        if(!empty($_POST['resultBacterias']))
            $num = $_POST['resultBacterias'];
        
        $num2 = 'No se observan';
        if(!empty($_POST['resultFilam']))
            $num2 = $_POST['resultFilam'];
    $nombre = 'Germenes       : '.$num."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    $nombre = 'Fil. de mucina : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
   
    


    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $num = 'No se observan';
        if(!empty($_POST['resultCil']))
            $num = $_POST['resultCil'];
        
        $num2 = 'No se observan';
        if(!empty($_POST['resultCilG']))
            $num2 = $_POST['resultCilG'];
            
    $nombre = 'Cilindros      : '.$num."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    $nombre = 'Cristales      : '.$num2."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkEB'])) { 
    }else {
        $pdf->Ln(5);
        $pdf->SetFont('courier', 'B', 14);
        $nombre = 'EXAMEN BACTERIOLOGICO'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
        $pdf->Ln(5);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkME'])) { 
    }else {
        $nombre = 'MATERIAL ESTUDIADO            : '.$_POST['resultME']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkLeucocitosME'])) { 
    }else {
        $nombre = 'Leucocitos                    : '.$_POST['resultLeucocitosME']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkHematiesME'])) { 
    }else {
        $nombre = 'Hematies                      : '.$_POST['resultHematiesME']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkCelulas'])) { 
    }else {
        $nombre = 'Celulas                       : '.$_POST['resultCelulas']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
     
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkFAmorfos'])) { 
    }else {
        $nombre = 'Fosfatos amorfos              : '.$_POST['resultFAmorfos']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    }
             
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkPiocitos'])) { 
    }else {
        $nombre = 'Piocitos                      : '.$_POST['resultPiocitos']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
     
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkOCalcio'])) { 
    }else {
        $nombre = 'Oxalatos de calcio            : '.$_POST['resultOCalcio']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkFlora'])) { 
    }else {
        $nombre = 'FLORA                         : '.$_POST['resultFlora']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkCultivos'])) { 
    }else {
        $nombre = 'CULTIVOS EN MEDIOS SELECTIVOS : '.$_POST['resultCultivos']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }   
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

    if(!isset($_POST['checkRecuento'])) { 
    }else {
        $nombre = 'RECUENTO DE COLONIAS          : '.$_POST['resultRecuento']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }     
      
            
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
    }
//-------------------------------------------------------------------------------
if(!isset($_POST['checkDAEBH'])) {
   }
   else {
       $pdf->Ln(5);
       $pdf->SetFont('helvetica', 'B', 14);
       $nombre = 'DETECCION DE ANTIGENOS DE ESTREPTOCOCO BETA HEMOLITICO';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
       $nombre = 'Grupo A (S.PYOGENES)';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
       $pdf->SetFont('courier', '', 12);
   }
 if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkTID'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'Test Inmunocromatográfico directo    : '.$_POST['resultTID']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Inmunocromagrafia'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkGCH'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'G.C.H. SUB-UNIDAD BETA               : '.$_POST['resultGCH']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Inmunocromagráfico'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkGCC'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'GONADOTROFINA CORIONICA CUANTITATIVA : '.$_POST['resultGCC'].' mUl/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia directa'."\n".'         Valor de referencia: - Hombres sanos -'."\n".'                              menor de 2.0 mUl/ml'."\n".'                              - Mujeres (no embarazadas) -'."\n".'                              menor de 6.0 mUl/ml'."\n".'                              - Mujeres embarazadas -'."\n".'                              0.2 - 1 semana: 5-50 mUl/ml'."\n".'                              1 - 2 semanas: 50-500 mUl/ml'."\n".'                              2 - 3 semanas: 100-5000 mUl/ml'."\n".'                              3 - 4 semanas: 500-10000 mUl/ml'."\n".'                              4 - 5 semanas: 1000-50000 mUl/ml'."\n".'                              5 - 6 semanas: 10000-100000 mUl/ml'."\n".'                              6 - 8 semanas: 15000-200000 mUl/ml'."\n".'                              8 - 12 semanas: 10000-100000 mUl/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
    
      if(!isset($_POST['check25H'])) { // Comprobamos si el nombre esta vacio
        // Aqui saltaria el error ya que el campo nombre esta vacio
    }else {
        $pdf->Ln(5);
        $pdf->SetFont('courier', '', 12);
        $nombre = '25-OH-VITAMINA D TOTAL (D2 + D3)            : '.$_POST['result25H'].' ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Nivel optimo: mayor de 30 ng/ml'."\n".'                              Insuficiente: entre 20-30 ng/ml'."\n".'                              Deficiente: menor de 20 ng/ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      
      if(!isset($_POST['checkATG'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'ANTIC. ANTI-TIROGLOBULINA SENSIBLE (ATG)     : '.$_POST['resultATG'].' U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: hasta 60 U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkATPO'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'ANTIC. ANTI TIROPEROXIDASA TIROIDEA (ATPO)   : '.$_POST['resultATPO'].' U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: hasta 60 U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkTiroxinaL'])) { 
    }else {
        $pdf->Ln(5);                        
        $nombre = 'TIROXINA LIBRE - T4 LIBRE                   : '.$_POST['resultTiroxinaL'].' ng/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Adultos: 0.89 a 1.76 ng/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkTiroxina'])) { 
    }else {
        $pdf->Ln(5);                        
        $nombre = 'TIROXINA LIBRE - T4                         : '.$_POST['resultTiroxina'].' ug/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Adultos: 4.5 - 10.9 ug/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkT3'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'TRIIODOTIRONINA - T3                 : '.$_POST['resultT3'].' ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Adultos: 0.60-1.81 ng/ml'."\n"; //1-23 meses: 1.17-2.39 ng/ml'."\n".'                              2-12 años: 1.05-2.07 ng/ml'."\n".'                              13-21 años: 0.86-1.92 ng/ml'."\n".'                              
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
      
    if(!isset($_POST['checkTSH'])) { 
    }else {
        $pdf->Ln(5);
        $nombre = 'TSH - TIROTROFINA                    : '.$_POST['resultTSH'].' uUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Adultos: 0.35 - 5.05 uUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }


      if(!isset($_POST['checkFSH'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'F.S.H. PLASMATICA                    : '.$_POST['resultFSH'].' mUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombre adulto: 1.4 a 18.1 mUI/ml'."\n".'                              Mujer fase folicular: 2.5 a 10.2 mUI/ml'."\n".'                              Mujer mitad del ciclo: 3.4 a 33.4 mUI/ml'."\n".'                              Mujer fase lútea: 1.5 a 9.1 mUI/ml'."\n".'                              Mujer postmenopausia: 23.0 a 116.3 mUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkLH'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'L.H. PLASMATICA                      : '.$_POST['resultLH'].' mUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: - Hombres -'."\n".'                              Niños: Menor de 6.0 mUI/ml'."\n".'                              20 a 70 años: 1.5-9.3 mUI/ml'."\n".'                              Mayores de 70 años: 3.1-34.6 mUI/ml'."\n".'                              - Mujeres -'."\n".'                              Menstruacion normal'."\n".'                              Fase folicular: 1.9-12.5 mUI/ml'."\n".'                              Pico medio ciclo: 8.7 - 76.3 mUI/ml'."\n".'                              Fase Lutea: 0.5-16.9 mUI/ml'."\n".'                              Gestantes: hasta 1.5 mUI/ml'."\n".'                              Postmenopausia: 15.9-54.0 mUI/ml'."\n".'                              Uso de Anticonceptivos: 0.7-5.6 mUI/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkEstradiol'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'ESTRADIOL PLASMATICO                 : '.$_POST['resultEstradiol'].' pg/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombres adulto: hasta 39.8 pg/ml'."\n".'                              Mujeres adulta:'."\n".'                              Fase folicular: 19.5 a 144.2 pg/ml'."\n".'                              Mitad del ciclo: 63.9 a 356.7 pg/ml'."\n".'                              Fase Lutea: 55 a 214.2 pg/ml'."\n".'                              Postmenopausia: menor de 32 pg/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkProgesterona'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'PROGESTERONA PLASMATICO              : '.$_POST['resultProgesterona'].' ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombres adulto: 0.28 a 1.22 ng/ml'."\n".'                              Fase folicular: 0.2 a 1.5 ng/ml'."\n".'                              Fase Luteinica: 3.34 a 25.56 ng/ml'."\n".'                              Postmenopausia: hasta 0.73 ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkProlactina'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'PROLACTINA PLASMATICO                : '.$_POST['resultProlactina'].' ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);

        if($pdf->getY()+5>250){
            $pdf->addPage();
            $pdf->Ln(7);
          }

          
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombres: 2.1-17.7 ng/ml'."\n".'                              - Mujeres -'."\n".'                              No gestantes: 2.8-29.2 ng/ml'."\n".'                              Gestantes: 9.7-208.5 ng/ml'."\n".'                              Postmenopausia: 1.8-20.3 ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkAAT'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'ANTIC. ANTI TIROPEROXIDASA           : '.$_POST['resultAAT'].' U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: hasta 60 U/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }


      if(!isset($_POST['checkSD'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'SULFATO DE DEHIDROEPIANDROSTERONA    : '.$_POST['resultSD'].' ug/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombres: 34.5-568.9 ug/dl'."\n".'                              Mujeres: 25.9-460.2 ug/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['checkD4A'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'DELTA 4 ANDROSTENODIONA              : '.$_POST['resultD4A'].' ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Radioinmunoensayo'."\n".'         Valor de referencia: Hombres: 0.5-4.8 ng/ml'."\n".'                              Mujeres: 0.5-4.7 ng/ml'."\n".'                              Fase folicular: 0.9-3.0 ng/ml'."\n".'                              Pico ovulatorio: 1.9-4.7 ng/ml'."\n".'                              Fase Lutea: 1.1-4.2 ng/ml'."\n".'                              Postmenopausia: 0.3-3.7 ng/ml'."\n".'                              Niños: 0.1-0.9 ng/ml'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

      if(!isset($_POST['check5N'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = '5 NUCLEOTIDASA                       : '.$_POST['result5N'].' U/l'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Espectrofotometrico'."\n".'         Valor de referencia: 4-30 años: menor de 4.4 U/l'."\n".'                              Mayor de 30 años: menor de 8.8 U/l'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
   
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

if(!isset($_POST['checkTiroglobulina'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'TIROGLOBULINA                        : '.$_POST['resultTiroglobulina'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 1.6-55.0 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkPSA'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'ANTIG. PROSTATICO ESPECIFICO (PSA)   : '.$_POST['resultPSA'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 0 a 49 años: hasta 2.60 ng/ml'."\n".'                              50 a 59 años: hasta 3.90 ng/ml'."\n".'                              60 a 69 años: hasta 5.40 ng/ml'."\n".'                              Mayor de 70 años: hasta 6.2 ng/ml'."\n".'                              Zona indefinida hasta 10.0 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkPSAL'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'PSA - Libre                          : '.$_POST['resultPSAL'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Para PSA(t): hasta 4.0 ng/ml'."\n".'                              Relacion: PSA(l)/PSA(t): mayor de 0.18 ng/ml'."\n".'                              Para PSA(t): Mayor de 4.0 ng/ml'."\n".'                              Relacion: PSA(l)/PSA(t): Mayor de 0.25 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkTestosterona'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'TESTOSTERONA TOTAL                   : '.$_POST['resultTestosterona'].' ng/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 2 - 10 años: <7.0 - 25.9 ng/dl'."\n".'                              11 años: <7.0 - 341.5 ng/dl'."\n".'                              12 años: <7.0 - 562.6 ng/dl'."\n".'                              13 años: 9.34 - 562.9 ng/dl'."\n".'                              14 años: 23.3 - 742.6 ng/dl'."\n".'                              15 años: 144.2 - 841.4 ng/dl'."\n".'                              16 - 21 años: 118.2 - 948.6 ng/dl'."\n".'                              Hombres adultos <50 años: 164.9 - 753.4 ng/dl'."\n".'                              Hombres >= 50 años: 86.5 - 788.2 ng/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkTestosteronaL'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'TESTOSTERONA libre de suero          : '.$_POST['resultTestosteronaL'].' pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Calculo de Vermeulen y Col.'."\n".'         Valor de referencia: Hasta 50 años: 62-184 pg/ml'."\n".'                              Mayores de 50 años: 49-113 pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkTestosteronaB'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'TESTOSTERONA Biodisponible           : '.$_POST['resultTestosteronaB'].' nmol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Calculo de Vermeulen y Col.'."\n".'         Valor de referencia: Femenino: 0.60-0.70 nmol/l'."\n".'                              Masculino: hasta 50 años: 5.00-15.00 nmol/l'."\n".'                                         Mayor de 50 años: 4.00-9.00 nmol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkValproico'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'ACIDO VALPROICO (VALPROATO)          : '.$_POST['resultValproico'].' ug/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Rango terapeutico'."\n".'         Valor de referencia: 50 a 100 ug/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkFenobarbital'])) {
}else {
    $pdf->Ln(5);   
    $nombre = 'Dosaje de FENOBARBITAL               : '.$_POST['resultFenobarbital'].' ug/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: KIMS. Interacción cinética de micropartículas en s'."\n".'         Valor de referencia: Rango Terapéutico'."\n".'                              10 a 30 ug/ml'."\n".'                                         Nivel tóxico: Mayor de 40 ug/m'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}
 
if(!isset($_POST['checkIgE'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'INMUNOGLOBULINA E TOTAL (IgE)        : '.$_POST['resultIgE'].' UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Adultos: 0-158 UI/ml'."\n".'                              Niños: hasta 1 año: 1.4-52.3 UI/ml'."\n".'                                     1 a 5 años: 0.4-351.6 UI/ml'."\n".'                                     5 a 10 años: 0.5-393.0 UI/ml'."\n".'                                     10 a 15 años: 1.9-170.0 UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}     

if(!isset($_POST['checkIA'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'INMUNOGLOBULINA A                    : '.$_POST['resultIA'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunoturbidimetria'."\n".'         Valor de referencia: Hombres: 40-350 mg/dl'."\n".'                              Mujeres: 40-350 mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkIG'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'INMUNOGLOBULINA G                    : '.$_POST['resultIG'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunoturbidimetria potenciado con PEG'."\n".'         Valor de referencia: Hombres: 650-1600 mg/dl'."\n".'                              Mujeres: 650-1600 mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}  

if(!isset($_POST['checkIM'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'INMUNOGLOBULINA M                    : '.$_POST['resultIM'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunoturbidimetria potenciado con PEG'."\n".'         Valor de referencia: Hombres: 50-300 mg/dl'."\n".'                              Mujeres: 50-300 mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkCS'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'COLINESTERASA SERICA                 : '.$_POST['resultCS'].' U/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Espectrofotométrico'."\n".'         Valor de referencia: Niños, Hombres y Mujeres mayores de 40 años: 5320-12921 U/l'."\n".'                              Mujeres menores de 40 años (no embarazadas o sin tomar anticonceptivos): 4260-11250 U/l'."\n".'                              Mujeres menores de 40 años (no embarazadas o tomando anticonceptivos): 3650-9120 U/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkCPB'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'CORTISOL PLASMATICO basal.           : '.$_POST['resultCPB'].' ug/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: MatutinoÑ 4.3 a 22.4 ug/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkT3L'])) {
}else {
    $pdf->Ln(5);   
    $nombre = 'T3 LIBRE                             : '.$_POST['resultT3L'].' pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 1-23 meses: 3.3-5.2 pg/ml'."\n".'                              2-12 años: 3.3-4.8 pg/ml'."\n".'                              13-21 años: 3.0-4.7 pg/ml'."\n".'                              Adultos: 2.3-4.2 pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkHBA'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'HEMOGLOBINA GLICOSILADA HBA 1C       : '.$_POST['resultHBA'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunológico turbidimétrico'."\n".'         Valor de referencia: No diabéticos: 4.0-6.0 %'."\n".'                              Diab. controlados: 6.0-8.0 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkTransferrina'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'TRANSFERRINA                         : '.$_POST['resultTransferrina'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunológico turbidimétrico'."\n".'         Valor de referencia: 250 - 380 mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkFerritina'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'FERRITINA                            : '.$_POST['resultFerritina'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Hombre adulto: 22 a 322 ng/ml'."\n".'                              Mujer adulta: 10 a 291 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkFerremia'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'FERREMIA - HIERRO SERICO             : '.$_POST['resultFerremia'].' ug/100 ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Trinder Heilmeyer'."\n".'         Valor de referencia: Mujeres: 60 a 140 ug/100 ml'."\n".'                              Hombres: 80 a 150 ug/100 ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkIgG'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'ANTIC. ANTI CARDIOLIPINA IgG         : '.$_POST['resultIgG'].' U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: ELISA'."\n".'         Valor de referencia: Negativo: menor de 10.0 GPL-U/ml'."\n".'                              Positivo: mayor o igual de 10.0 GPL-U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkIgM'])) { 
}else {
    $pdf->Ln(5);   
    $nombre = 'ANTIC. ANTI CARDIOLIPINA IgM         : '.$_POST['resultIgM'].' U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: ELISA'."\n".'         Valor de referencia: Negativo: menor de 7.0 MPL-U/ml'."\n".'                              Positivo: mayor o igual de 7.0 MPL-U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkGrupo'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 14);
    $nombre = 'GRUPO SANGUINEO'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Aglutinacion'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Grupo                                : '.$_POST['resultGrupo']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkFactorRH'])) {
}else {
    $nombre = 'Factor RH                            : '.$_POST['resultFactorRH']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

//-------------------------------------------------------------------------------------------------

if(!isset($_POST['checkBacteriologico'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'EXAMEN BACTERIOLOGICO'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $pdf->Ln(5); 
}
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkMatEstudiado'])) { 
    }else {  
        $nombre = 'MATERIAL ESTUDIADO            : '.$_POST['resultMatEstudiado']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkFloraB'])) { 
    }else {
        $nombre = 'FLORA                         : '.$_POST['resultFloraB']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkCultivosMS'])) { 
    }else {  
        $nombre = 'CULTIVOS EN MEDIOS SELECTIVOS : '.$_POST['resultCultivosMS']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
    }

    if(!isset($_POST['checkRecuentoColonias'])) { 
    }else {  
        $nombre = 'RECUENTO DE COLONIAS          : '.$_POST['resultRecuentoColonias']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}

if(!isset($_POST['checkAntibiograma'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'ANTIBIOGRAMA';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    
    if(!isset($_POST['checkBacteriaEstudio'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'BACTERIA EN ESTUDIO           : '.$_POST['resultBacteriaEstudio']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    if(!isset($_POST['checkSensibilidad'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'Se observa sensibilidad a     : '.$_POST['resultSensibilidad']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    if(!isset($_POST['checkMSensibilidad'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'Se observa mediana sensibilidad a : '.$_POST['resultMSensibilidad']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    }
    if(!isset($_POST['checkResistencia'])) { 
    }else {
        $pdf->Ln(5);   
        $nombre = 'Se observa resistencia a      : '.$_POST['resultResistencia']."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    }
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
}
//-------------------------------------------------------------------------------

if(!isset($_POST['checkAcidoFolico'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'ACIDO FOLICO                         : '.$_POST['resultAcidoFolico'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Metodo: Quimioluminiscencia'."\n".'        Valor de referencia: normal: > 5.38 ng/ml'."\n".'                              Deficientes: Menor de 3.37 ng/ml'."\n".'                              Indeterminado: 3.38 - 5.38 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkLDH'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'LACTICO DEHIDROGENASA - LDH -        : '.$_POST['resultLDH'].' U/L'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Metodo: SFBC'."\n".'        Valor de referencia: de 230 a 460 U/L'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkB2M'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'BETA 2 MICROGLOBULINA                : '.$_POST['resultB2M'].' ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Metodo: Quimioluminiscencia'."\n".'        Valor de referencia: normal: > 5.38 ng/ml'."\n".'                             Deficientes: Menor de 3.37 ng/ml'."\n".'                             Indeterminado: 3.38 - 5.38 ng/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkPE'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 12);
    $nombre = 'PROTEINOGROMA ELECTROFORETICO'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Metodo: Método Electroforesis capilar (suero)'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

if(!isset($_POST['checkProteinasPE'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'PROTEINAS TOTALES : '.$_POST['resultProteinasPE'].' g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

if(!isset($_POST['checkAlbuminaPE'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'ALBUMINA          : '.$_POST['resultAlbuminaPE'].' g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 3.57 - 5.48 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                  '.$_POST['resultAlbuminaPE1'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 55.8 - 66.1 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkA1G'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Alfa-1 GLOBULINA  : '.$_POST['resultA1G1'].' g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 0.19 - 0.41 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                    '.$_POST['resultA1G2'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 2.9 - 4.9 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkA2G'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Alfa-2 GLOBULINA  : '.$_POST['resultA2G1'].' g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 0.45 - 0.98 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                    '.$_POST['resultA2G2'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 7.1 - 11.8 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkB1G'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Beta-1 GLOBULINA  : '.$_POST['resultB1G1']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 0.30 - 0.59 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                    '.$_POST['resultB1G2'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 4.7 - 7.2 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  if(!isset($_POST['checkB2G'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Beta-2 GLOBULINA  : '.$_POST['resultB2G1']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 0.20 - 0.55 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                    '.$_POST['resultB2G2'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 3.2 - 6.5 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  if(!isset($_POST['checkGG'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Gamma GLOBULINA   : '.$_POST['resultGG1']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 0.71 - 1.56 g%'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
    $nombre = '                    '.$_POST['resultGG2'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Valor de referencia: 11.1 - 18.8 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  

//-------------------------------------------------------------------------------------------
if(!isset($_POST['checkMycoplasma'])) { 
   }
   else {
       $pdf->Ln(5);
       $pdf->SetFont('helvetica', 'B', 14);
       $nombre = 'CULTIVO PARA MYCOPLASMA HOMINIS';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
       $pdf->SetFont('courier', '', 12);

       $pdf->Ln(5);
       $nombre = 'Tipo de muestra                  : '.$_POST["resultMuestra"];
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   

       $pdf->Ln(5);
       $nombre = 'Cultivo e identificacion para mycoplasma hominis';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
       $nombre = 'Resultado                        : '.$_POST["resultCIMH"];
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   

       $pdf->Ln(5);
       $nombre = 'Recuento de unidades cambiadoras de color';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
       $nombre = 'Resultado                        : '.$_POST["resultRUMH"].' UCC/ml';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);  

       $pdf->Ln(5);
       $nombre = 'Sensibilidad';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
       $nombre = 'Resultado                        : '.$_POST["resultSMH"];
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);  
   }
 if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }


      if(!isset($_POST['checkUreaplasma'])) { 
       }
       else {
           $pdf->Ln(5);
           $pdf->SetFont('helvetica', 'B', 14);
           $nombre = 'CULTIVO PARA UREAPLASMA UREALITICUM';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
           $pdf->SetFont('courier', '', 12);
    
           $pdf->Ln(5);
           $nombre = 'Cultivo e identificacion para ureaplasma urealiticum';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
           $nombre = 'Resultado                        : '.$_POST["resultCIUU"];
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
    
           $pdf->Ln(5);
           $nombre = 'Recuento de unidades cambiadoras de color';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
           $nombre = 'Resultado                        : '.$_POST["resultRUUU"].' UCC/ml';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);  
    
           $pdf->Ln(5);
           $nombre = 'Sensibilidad';
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
           $nombre = 'Resultado                        : '.$_POST["resultSUU"];
           $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);  
       }
     if($pdf->getY()+5>250){
            $pdf->addPage();
            $pdf->Ln(7);
          }

//------------------------------------------------------------------------------------------

if(!isset($_POST['checkEspermograma'])) { 
   }
   else {
       $pdf->Ln(5);
       $pdf->SetFont('helvetica', 'B', 14);
       $nombre = 'ESPERMOGRAMA';
       $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
       $pdf->SetFont('courier', '', 12);

       if(!isset($_POST['checkCaracFisicas'])){

       }
       else{
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $nombre = 'Caracteristicas Fisicas';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
        $pdf->SetFont('courier', '', 12);
 
        $pdf->Ln(5);
        $nombre = 'Volumen                          :'.$_POST["resultVolumenE"].' ml';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
        $nombre = 'p.H.                             : '.$_POST["resultPHE"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $nombre = 'Viscosidad                       : '.$_POST["resultViscosidad"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 

        $pdf->Ln(5);
        $nombre = 'Tiempo de licuacion              :'.$_POST["resultTpoLicuacion"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        
        $pdf->Ln(5);
        $nombre = 'Numero de Espermatozoides';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $nombre = 'Expresado en                     :'.$_POST["resultExpresados"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $nombre = 'Por ml                           :'.$_POST["resultMl"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $nombre = 'Totales                          :'.$_POST["resultTotalesE"];
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);

        $pdf->SetFont('courier', '', 8);
        $pdf->Ln(5);
        $nombre = 'Metodo: Camara de Makler';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
       }

       if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkMovilidad'])){
    }
    else{
     $pdf->Ln(5);
     $pdf->SetFont('helvetica', 'B', 12);
     $nombre = 'Estudio de la Movilidad';
     $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
     $pdf->SetFont('courier', '', 12);

     $pdf->Ln(5);
    $nombre = 'Formas Normales                  :'.$_POST["resultNormales"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
    $nombre = 'Formas Muertas (test de Eosina)  :'.$_POST["resultMuertas"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Formas Moviles                   :'.$_POST["resultMoviles"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Grado I (mov. in situ)           :'.$_POST["resultGI"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Grado II (trans.lenta)           :'.$_POST["resultGII"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Grado III (trans.rapida)         :'.$_POST["resultGIII"].' %';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkEEA'])){
    }
    else{
     $pdf->Ln(5);
     $pdf->SetFont('helvetica', 'B', 12);
     $nombre = 'Estudio de los Elementos Agregados';
     $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
     $pdf->SetFont('courier', '', 12);

     if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

     $pdf->Ln(5);
    $nombre = 'Celulas                          :'.$_POST["resultCEEA"];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
    $nombre = 'Espermatogonias                  :'.$_POST["resultEEEA"];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Hematies                         :'.$_POST["resultHEEA"];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);        
    }
   }
 if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    if(!isset($_POST['checkEDQ'])){
    }
    else{
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 14);
        $nombre = 'ESPERMATOGRAMA: DETERMINACIONES BIOQUIMICAS';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
        $pdf->SetFont('courier', '', 12);

        $pdf->Ln(5);
        $nombre = 'Acido Citrico                    :'.$_POST["resultEAC"].' umol/eyac';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Cinetico U.V.'."\n".'         Valor de referencia: Mayor de 60 umol/eyaculado'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);

        if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $pdf->Ln(5);   
        $nombre = 'Fructosa                         :'.$_POST["resultEF"].' umol/eyac';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Karvonen y Malm modificado'."\n".'         Valor de referencia: Mayor de 13 umol/eyaculado'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);

        if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
        }

        $pdf->Ln(5);   
        $nombre = 'Alfa Glucosidasa Neutral (Semen) :'.$_POST["resultSemen"].' umol/eyac';
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);   
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Cooper y col.'."\n".'         Valor de referencia: Mayor de 20 mU/eyaculado'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);      
    }

    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }
//------------------------------------------------------------------------------------------

if(!isset($_POST['checkAMA'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'ANTICUERPO ANTI-MITOCONDRIAL (AMA)   : '.$_POST['resultAMA']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunofluorecencia indirecta'."\n".'         Valor de referencia: Negativo'."\n".'                              Dilucion de corte: 1/40'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHVA'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'HVA-Ac IgG (Anticuerpo Anti-Hepatitis A IgG)'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $nombre = 'Resultado                            :'.$_POST['resultHVA'].' mUI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Menor de 20: no reactivo mUI/ml'."\n".'                              Mayor o igual de 20: reactivo mUI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHCV'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Hepatitis C (HCV) (Anticuerpo Anti)  :'.$_POST['resultHCV']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Negativo: menor o igual a 0.79'."\n".'                              Indefinido: de 0.80 a 0.99'."\n".'                              Positivo: mayor o igual a 1.0'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkVirusEB'])) { 
}else {
    $pdf->Ln(5);
    $nombre = 'Virus EPSTEIN BARR - Anti VCA (IgG)  :'.$_POST['resultVirusEB'].' U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: Negativo: menor de 20 U/ml'."\n".'                              Positivo: mayor o igual a 20 U/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHBSI'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $nombre = 'Hepatitis B Antigeno de Superficie (HBS Ag)'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $nombre = 'Resultado                            :'.$_POST['resultHBSI']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunocromatografico'."\n".'         Valor de referencia: Negativo'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHBSQ'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $nombre = 'Hepatitis B Antigeno de Superficie (HBS Ag)'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $nombre = 'Resultado                            :'.$_POST['resultHBSQ']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: <10'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkMUSK'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $nombre = 'ANTIC. ANTI MUSK                     :'.$_POST['resultMUSK'].' nmol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Radioinmunoensayo (RIE)'."\n".'         Valor de referencia: Hombres y Mujeres: menor de 0.05 nmol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }


  if(!isset($_POST['checkGGlucemia'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'PRUEBA DE TOLERANCIA ORAL A LA GLUCOSA'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);

    if(!isset($_POST['checkGl'])) { // Comprobamos si el nombre esta vacio
        // Aqui saltaria el error ya que el campo nombre esta vacio
    }else {
        $pdf->Ln(5);
        $nombre = 'GLUCEMIA BASAL                       :'.$_POST['resultGl'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
        $pdf->SetFont('courier', '', 8);
        $nombre = '         Método: Cinético UV'."\n".'         Valor de referencia: 70-110 mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
        $pdf->SetFont('courier', '', 12);
    }
    if($pdf->getY()+5>250){
        $pdf->addPage();
        $pdf->Ln(7);
      }

    $nombre = 'GLUCEMIA 120 min                     :'.$_POST['resultGGlucemia'].' mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Cinético UV'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkCTG'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 12);
    $nombre = 'CURVA DE TOLERANCIA A LA GLUCOSA'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);

    $pdf->SetFont('courier', '', 12);
    if(!isset($_POST['checkGlucosa60'])) { // Comprobamos si el nombre esta vacio
        // Aqui saltaria el error ya que el campo nombre esta vacio
    }else {
        $nombre = 'GLUCOSA 60 min                       :'.$_POST['resultGlucosa60'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    }

    if(!isset($_POST['checkGlucosa120'])) { // Comprobamos si el nombre esta vacio
        // Aqui saltaria el error ya que el campo nombre esta vacio
    }else {
        $nombre = 'GLUCOSA 120 min                      :'.$_POST['resultGlucosa120'].' mg/dl'."\n";
        $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    }
    
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Cinético UV'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

if(!isset($_POST['checkFructosamina'])) { 
}
else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'FRUCTOSAMINA                         : '.$_POST['resultFructosamina'].' umol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 8);
    $nombre = '        Método: Reducción con NBT'."\n".'        Valor de referencia: hasta 285 umol/l'."\n".'        En pacientes diabéticos sin tratamiento se observan valores de 228 a 563 umol/l';
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
//---------------------------------------------------------------------------------------------
if(!isset($_POST['checkCoagulograma'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'COAGULOGRAMA BÁSICO'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkTpoCoagulacion'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'TIEMPO DE COAGULACION                :'.$_POST['resultTpoCoagulacion'].' min:seg'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Valor de referencia: de 7 a 12 min:seg'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkTpoSangria'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'TIEMPO DE SANGRIA                    :'.$_POST['resultTpoSangria'].' min:seg'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Punción del lóbulo de la oreja'."\n".'         Valor de referencia: Punc.del lob.de oreja hasta 2:30 min:seg'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkTpoProtrombina'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'TIEMPO DE PROTROMBINA                :'.$_POST['resultTpoProtrombina'].' segundos'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Coagulómetro'."\n".'         Valor de referencia: de 12 a 15 segundos'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkConcentracionProtrombina'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'CONCENTRACION DE PROTROMBINA         :'.$_POST['resultConcentracionProtrombina'].' %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Valor de referencia: de 70 a 100 %'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkRatio'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'RATIO                                :'.$_POST['resultTpoSangria'].' '."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkINR'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'I.N.R.                               :'.$_POST['resultINR'].' '."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Valor ISI: 1.02  Indice de Sensibilidad Internacional'."\n".'          contra el standard secundario de la OMS.'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkKPTT'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'TIEMPO PARCIAL DE KAOLIN (KPTT)      :'.$_POST['resultKPTT'].' segundos'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Coagulómetro'."\n".'         Valor de referencia: de 28 a 42 segundos'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  if(!isset($_POST['checkRecuentoPlaquetas'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Recuento de plaquetas                :'.$_POST['resultRecuentoPlaquetas'].' mm3'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: ANALIZADOR KX-21N'."\n".'         Valor de referencia: 150.000 - 350.000 por mm3'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkProteinaC'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'PROTEINA C REACTIVA DE AMPLIO RANGO         :'.$_POST['resultProteinaC']." mg/dl\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunoturbidimetria potenciado con latex'."\n".'         Valor de referencia: hasta 0.50 mg/dl'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkSifilis'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'SIFILIS CUALITATIVA (AC.ANTI TREP. PALLIDUM):'.$_POST['resultSifilis']." mg/dl\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimio luminiscencia'."\n".'         Valor de referencia: Menor de 0.90: No Reactivo'."\n".'                              Entre 0.90 y 1.09: Indeterminado'."\n".'                              Mayor de 1.09: Reactivo'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkPCR'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'PCR Cuantitativa                     :'.$_POST['resultPCR'].' mg/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Latex-poliestireno'."\n".'         Valor de referencia: hasta 6 mg/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkAntiestrep0'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'ANTIESTREPTOLISINA "0"               :'.$_POST['resultAntiestrep0'].' U.Tood'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmuno Turbidimetrico'."\n".'         Valor de referencia: Adultos: hasta 200 U.Tood'."\n".'                              Niños: hasta 250 U.Tood'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkLatex'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'LATEX ARTRITIS REUMATOIDEA CUANTITATIVO :'.$_POST['resultLatex'].' UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Test de Latex'."\n".'         Valor de referencia: Negativo'."\n".'                             Patologico: mayor de 20 UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkPaulBunnel'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'REACCION DE PAUL BUNNEL -MONOTEST-   :'.$_POST['resultPaulBunnel'].' '."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Hemaglutinacion'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  
  if(!isset($_POST['checkVDRL'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'V.D.R.L TEST                         :  '.$_POST['resultVDRL']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Floculacion'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
  
//------------------------------------------------------------------------------------------

  if(!isset($_POST['checkBAAR'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'BACILOSCOPIA DIRECTA (BAAR)          : $ '.$_POST['resultBAAR']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Coloracion de Ziehl Nielsen'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

 
  //--------------------------------------------------------------------------------------------
  if(!isset($_POST['checkPTH'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'PARATHORMONA-PTH Molecula intacta    : '.$_POST['resultPTH'].' pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 14 a 72 pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}

if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkB12'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'VITAMINA B12                         : '.$_POST['resultB12'].' pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: de 210 a 910 pg/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

//----------------------------------------------------------------------------------------------

if(!isset($_POST['checkHIV'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'ANTICUERPOS ANTI VIRUS DE LA INMUNODEFICIENCIA HUMANA H.I.V. (I+II)'."\n".'Resultado                            : '.$_POST['resultHIV']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Inmunocromatografico'."\n".'         Valor de referencia: NO REACTIVO'."\n".'         NOTA: Muestra reactivas o en zona gris deben confirmarse con P24, WB y/o RNA-HIV'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
//--------------------------------------------------------------------------
if(!isset($_POST['checkInsulina'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Insulina (Basal)                     : '.$_POST['resultInsulina'].' UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Quimioluminiscencia'."\n".'         Valor de referencia: 3.0 - 25.0 UI/ml'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHoma'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Indice de resistencia a la insulina (HOMA-IR) : '.$_POST['resultHoma']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Valor de referencia: inferior a 2.15'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkHomocisteina'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', '', 12);
    $nombre = 'Homocisteina                         : '.$_POST['resultHomocisteina'].' umol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 8);
    $nombre = '         Método: Espectrofotometria enzimatica U.V.'."\n".'         Valor de referencia: <15 umol/l'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0); 
    $pdf->SetFont('courier', '', 12);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
//--------------------------------------------------------------------------------------------
if(!isset($_POST['checkSOMF'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 12);
    $nombre = 'SOMF - Sangre Oculta en Materia Fecal : '."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $nombre = '                                        '.$_POST['resultSOMF']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkDMF'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 12);
    $nombre = 'DMF - Directo Materia Fecal             '."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $nombre = '                                        '.$_POST['resultDMF']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }

  if(!isset($_POST['checkPS'])) { // Comprobamos si el nombre esta vacio
    // Aqui saltaria el error ya que el campo nombre esta vacio
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 12);
    $nombre = 'PARASITOLOGICO SERIADO'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $nombre = '     - Test de Graham           : '.$_POST['resultTestGraham']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $nombre = '     - Materia Fecal            : '.$_POST['resultMateriaFecal']."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}
if($pdf->getY()+5>250){
    $pdf->addPage();
    $pdf->Ln(7);
  }
//--------------------------------------------------------------------------------------------
/*

// set font
$pdf->SetFont('courier', '', 10);

// add a page
$pdf->AddPage();

$pdf->Ln(5);
$pdf->Write(0, $nombreapellido, '', 0, '', true, 0, false, false, 0);
$pdf->Write(0, $documento, '', 0, '', true, 0, false, false, 0);
$pdf->Cell(0, 0, $protocolo, 'B', false, 'L', 0, '', 0, false, 'T', 'M');  

*/


// ---------------------------------------------------------
$pdf->Ln(20);
if(empty($_POST['campotexto'])) { 
}else {
    $pdf->Ln(5);
    $pdf->SetFont('courier', 'B', 14);
    $nombre = 'OBSERVACIONES:'."\n";
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
    $pdf->SetFont('courier', '', 12);
    $nombre = ''.$_POST['campotexto'];
    $pdf->Write(0, $nombre, '', 0, '', true, 0, false, false, 0);
}


//Close and output PDF document
$conn->close();
$pdf->Output('protocolo.pdf', 'I');

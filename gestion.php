<?php
session_start();
require_once('tcpdf_include.php');
include_once("../Laboratorio/conexionDB.php");

$estilo = '<style>
    p,div{ 
      font-size: 11,5 pt;
      text-align: justify;
      text-justify: inter-word;
      line-height: 140%;
    }
    ul,li,ol{ 
      font-size: 11pt;
      text-align: justify;
      text-justify: inter-word;
      line-height: 110%;
      margin: 0;
      padding: 0;
    }
    h1.encabezado{
      font-size: 16pt; 
      text-align:center;
      color:#6E192B;
    }
    h1.titulo{
      color:#6E192B; 
      background-Color:#F0F0BE; 
      border-top: 1px solid black;
      font-size: 14pt;
      text-align: center;
    }
    h1.subtitulo{
      color:#6E192B;
      font-size: 14pt;
    }
    h1.tituloM{
      color:#6E192B;
      background-Color:#F0F0BE;
      font-size: 11pt;
    }
    h1.tituloB{
      color:#6E192B; 
      background-Color:#F0F0BE; 
      border-bottom: 1px solid black;
      font-size: 11pt;
    }
    span.titulo{
      color:Black; 
      font-weight: normal;
    }
    table,th,td{
      border: 1px solid black;
      font-size: 11pt;
      line-height: 150%;
    }
    </style>';  


  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_SESSION['nombreapellido']; 
    
    $resultados = $_POST["resultHemograma"];
  
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, '',1,2,false);

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->setFooterData(Array(110,25,43),Array(110,25,43));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
      require_once(dirname(__FILE__).'/lang/spa.php');
      $pdf->setLanguageArray($l);
    }
    // ---------------------------------------------------------
    // set font
    $pdf->SetFont('helvetica', '', 10, '', true);

    // add a page
    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 8, '', true);

    $html = $estilo.'<h1 class="encabezado">PRESENTACIÓN DE LA ASIGNATURA</h1>';

    $html1 = $estilo.'<h1 class="titulo">'.$nombre.'</h1>
    <h1 class="tituloM">Carrera: <span class="titulo">'.$resultados.'</span></h1>>';

    $x = 28;

    

    $pdf->writeHTMLCell(0, 15, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(153, '', $x, '', $html1, 0, 1, 0, true, '', true);




    $pdf->Output('presentacion.pdf', 'I');

  }

?>
<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
session_start();

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

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
$pdf->SetFont('courier', '', 12);

// add a page
$pdf->AddPage();

$texto='LAC'."\n".'Laboratorio de Análisis Clínicos'."\n".'9 de Julio 1073 - Campana '."\n"."\n".'Traiga este comprobante para retirar los análisis';

$pdf->Write(0, $texto, '', 0, '', true, 0, false, false, 0);
$pdf->Ln(3);

$paciente = 'Paciente  : ';
$medico =   'Médico    : ';
$mutual =   'Mutual    : ';
$retirar =  'Retirar   : ';
$total =    'Total     : $ ';

if(!empty($_POST['paciente'])){
    $paciente = 'Paciente  : '.$_POST['paciente'];
}

if(!empty($_POST['medico'])){
    $medico =   'Médico    : '.$_POST['medico'];
}

if(!empty($_POST['mutual'])){
    $mutual =   'Mutual    : '.$_POST['mutual'];
}

if(!empty($_POST['fecha'])){
    $fechaRetiro = date('d/m/Y',strtotime($_POST['fecha']));
    $retirar =  'Retirar   : '.$fechaRetiro;
}

if(!empty($_POST['total']))
    $total = 'Total     : $ '.$_POST['total'];

$fe=date("d/m/Y");
$fecha =    'Fecha     : '.$fe;

$pdf->Write(0, $paciente, '', 0, '', true, 0, false, false, 0); 
$pdf->Write(0, $fecha, '', 0, '', true, 0, false, false, 0); 
$pdf->Write(0, $medico, '', 0, '', true, 0, false, false, 0); 
$pdf->Write(0, $mutual, '', 0, '', true, 0, false, false, 0); 
$pdf->Ln(3);
$pdf->Write(0, $retirar, '', 0, '', true, 0, false, false, 0); 
$pdf->Ln(3);
$pdf->Write(0, $total, '', 0, '', true, 0, false, false, 0); 

//Close and output PDF document
$pdf->Output('comprobante.pdf', 'I');

?>
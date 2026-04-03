<?php

require '../vendor/autoload.php';
include "../resources/db/PedidoDB.php";
include "../resources/db/ItemPedidoDB.php";

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $image_file = 'assets/img/logo150x130.jpg';
        $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Tizauvenirs S. A. de C. V.', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

//////////////////////////////////////////

$orderData = PedidoDB::getDatosPersonaOrdenPorIdOrden($_GET['idOrden']);
$datosPedido = ' 
    <div > 
        <h3>Información de la orden</h3>
        <p><b>Nombre cliente:</b>' . $orderData['nombre'] . ' ' . $orderData['a_paterno'] . '</p>
        <p><b>Dirección:</b> ' . $orderData['calle'] . ' #' . $orderData['numero'] . '</p>
        <p><b>Email:</b> ' . $orderData['correo_electronico'] . '</p>
        <p><b>Fecha compra:</b>' . $orderData['creada'] . ' </p>
        <p><b>Número de referencia:</b>' . $orderData['id'] . '</p>
        <p><b>Total:</b> $' . $orderData['total'] . '</p>
    </div>
       ';

$items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orderData['id']);

$tabla = '';
$tabla = $tabla.'
<table>
	<tr>
		<th width="45%">Producto</th>
		<th width="15%">Precio</th>
		<th width="20%">Cantidad</th>
		<th width="20%">Sub total</th>
	</tr>
    ';
foreach ($items as $item) {
    $tabla = $tabla . ' 
	<tr>
		<td>' . $item["nombre"] . '</td>
		<td>$' . $item['precio_venta'] . '</td>
		<td>' . $item['cantidad'] . '</td>
		<td>$' . $item['precio_venta'] * $item['cantidad'] . '</td>
	</tr>
    ';
}

$tabla = $tabla . '
</table>
';


///////////////////////////////////////////

// output the HTML content
$pdf->writeHTML($datosPedido, true, false, true, false, '');
$pdf->writeHTML($tabla, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('ticket.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

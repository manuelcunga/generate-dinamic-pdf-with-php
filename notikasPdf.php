<?php
session_start();

use Dompdf\Dompdf;
// use Dompdf\Css;

require_once "conexao.php";

if(isset($_POST["generete"])){
    // teste 01 select on  database
   
    $html = '<div >';
    $html = '<table id="data-table-basic" class="table table-striped" > ';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= ' <th>Source Esmes</th>';
	$html .= '<th>Ack</th>';
    $html .= '<th>Nack</th>';
    $html .= '<th>Total</th>';
    $html .= '<th>Porcentual</th>';


    $result = $conn->query("SELECT * FROM dados");

    foreach($result as $dados){
    $calc = intval($dados['ack']) + intval($dados['total'])/100;
        $html .= '<tr ><td>'.$dados['nome'] . "</td>";
		$html .= '<td>'.$dados['ack'] . "</td>";
        $html .= '<td>'.$dados['nack'] . "</td>";
        $html .= '<td>'.$dados['total'] . "</td>";
        $html .= '<td>'.$calc.'</td>';
        $html .= '</tr>';
		
    }
   
    $html .= '</tbody>';
    $html .= '</table';
    $html .= '</div>';
    $html .= '<link rel="stylesheet" href="css/bootstrap.min.css">';
    // require_once "data-table.php";
    require_once "dompdf/autoload.inc.php";
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h4 style="text-align: center;">Notika Relatório</h4>'.$html);
    $dompdf->setPaper("A4", "landscape");
    $dompdf->render();
    // var_dump($dompdf->output());
    $dompdf->stream("notika.pdf", array("Attachment"=> true));



}
  
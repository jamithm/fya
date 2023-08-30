<?php

require_once 'fpdf/fpdf.php';
require_once('Connections/conexion.php');

class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border

		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()
{
	$this->SetFont('Arial','',11);
	$this->Image('images/logo1.jpg',20,20,35);
	$this->Image('images/logo2.jpg',165,20,30);
	
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',11);
}

}

	//Consulta SQL
    //************
	$id = $_GET['id'];
	$sql = "select concat(e.nombres, ', ', e.apellidos) as estudiante, e.cedula, em.razon_social, date_format(e.fecha_inicio, 	'%d-%m-%Y') as fecha_inicio, date_format(e.fecha_culminacion, '%d-%m-%Y') as fecha_culminacion, g.denominacion as grado
from t_estudiante as e, t_empresas as em, t_grados as g
where e.id_grado = g.id and e.id_empresa = em.id and e.id = " .$_GET['id']. "";
    $result = mysql_query($sql, $conexion);
    $row = mysql_fetch_array($result);
	
	$sqlc = "select firmante from t_firmantes where cargo = 'Coordinador(a) de Pasantias'";
    $resultc = mysql_query($sqlc, $conexion);
    $rowc = mysql_fetch_array($resultc);
	
	$sqld = "select firmante from t_firmantes where cargo = 'Director(a)'";
    $resultd = mysql_query($sqld, $conexion);
    $rowd = mysql_fetch_array($resultd);
	
    //Crear el reporte
    //****************
    $pdf=new PDF('P','mm','Letter');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(30,20,30);
    $pdf->Ln(10);
	
    //Membrete del Reporte
    //********************
    $pdf->SetFont('Arial','',9);
	$membrete1 = utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA');
    $pdf->Cell(0,5,$membrete1,0,10, 'C');
	$membrete2 = utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN');
    $pdf->Cell(0,5,$membrete2,0,10, 'C');
	$membrete3 = utf8_decode('U.E CÁNDIDA MARÍA DE JESÚS - FE Y ALEGRÍA');
	$pdf->Cell(0,5,$membrete3,0,10, 'C');
    $pdf->Cell(0,5,'VILLA DEL ROSARIO - ESTADO ZULIA',0,10, 'C');
    $pdf->Ln(10);

	//Titulo del Reporte
    //******************
    $pdf->SetFont('Arial','B',11);
	$titulo = utf8_decode('CARTA DE POSTULACIÓN'); 
    $pdf->Cell(0,6,$titulo,0,10, 'C');
    $pdf->Ln(10);
	
	
	$pdf->SetFont('Arial','B',10);
	$texto = utf8_decode ("Señor(es)");
    $pdf->Cell(0,5,$texto,0,10, '');
    $pdf->Cell(0,5,$row['razon_social'],0,10, '');
	$pdf->Cell(0,5,'Su despacho.-',0,10, '');
	$pdf->Ln(10);
	
    $pdf->SetFont('Arial','',11);
	$texto1 = utf8_decode ("        Reciba un cordial y atento saludo en nombre de la Comunidad Educativa de la U.E.P FE Y ALEGRÍA - CÁNDIDA MARÍA DE JESÚS, en la ocasión de presentarle al estudiante: " . $row['estudiante'] . " portador de la C.I Nº V- ". $row['cedula'] ." cursante del " . $row['grado'] . " Año de Educación Media Técnica.");
    $pdf->MultiCell(0,5, $texto1);
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',11);
	$texto2 = utf8_decode('        A la vez queremos solicitarles a usted(es), nos exprese(n) a través del informe, el cual se les hará llegar en las visitas a los pasantes por los Coordinadores de Pasantías, los aspectos relativos al control y evaluación de su pre-pasantías.');
    $pdf->MultiCell(0,5,$texto2);
    $pdf->Ln(5);
	
	$pdf->SetFont('Arial','',11);
	$texto3 = utf8_decode('        Queremos dejar constancia de nuestro agradecimiento por su valiosa colaboración, y gestionar ante usted(es), nos deje(n) abierta la oportunidad de realizar actividades de esta índole en los próximos periodos académicos, Recordándole que el periodo de pasantías es un mínimo de doce (12) semanas.');
    $pdf->MultiCell(0,5,$texto3);
    $pdf->Ln(5);
	
	$pdf->SetFont('Arial','',11);
	$texto4 = utf8_decode('Fecha de Inicio: '. $row['fecha_inicio'] .'    Fecha de Culminación: ' . $row['fecha_culminacion'] .'');
    $pdf->MultiCell(0,5,$texto4);
    $pdf->Ln(5);
	
	$pdf->SetFont('Arial','',11);
	$texto5 = utf8_decode('En agradecimiento a su atención, se despide de usted(es),');
    $pdf->MultiCell(0,5,$texto5);
    $pdf->Ln(15);
	
	$pdf->SetFont('Arial','',11);
    $pdf->Cell(0,5,'Atentamente,',0,10,'C');
    $pdf->Ln(15);
	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,5,' ________________________                                            _____________________',0,10, '');
    $pdf->Cell(0,5,'            '. $rowc['firmante'] .'                                                               '. $rowd['firmante'] .'',0,10, '');
	$pdf->Cell(0,5,'  Coordinador(a) de Pasantias                                                        Director(a)',0,10, '');
	$pdf->Ln(25);
	
	$pdf->SetFont('Arial','B',10);
	$texto6 = utf8_decode('NOTA: Es imprescindible el sello de la institución para ser válido.');
    $pdf->Cell(0,6,$texto6,0,10, 'C');
    $pdf->Ln(3);
    $pdf->Output();

?>

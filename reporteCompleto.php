<?php
    require('./fpdf186/fpdf.php');
    class PDF extends FPDF{
        function Reporte(){
            $w=array(15,57,35,23,20,40);

            $hostDB = 'localhost';
            $nombreDB = 'ejemplo';
            $usuarioDB = 'root';
            $contrasenyaDB = 'Miperritoeszeuz1';

            $hostDB = "mysql:host=$hostDB;dbname=$nombreDB;";
            $miPDO = new PDO($hostDB, $usuarioDB, $contrasenyaDB);
            
            $miConsulta = $miPDO->prepare('SELECT * FROM libros;');
            $miConsulta->execute();

            $this->SetFont('Arial','',10);
            $this->Cell($w[0],6,'CODIGO','LRBT',0,'C');
            $this->Cell($w[1],6,'TITULO','LRBT',0,'C');
            $this->Cell($w[2],6,'AUTOR','LRBT',0,'C');
            $this->Cell($w[3],6,'DISPONIBLE','LRBT',0,'C');
            $this->Cell($w[4],6,'PAGINAS','LRBT',0,'C');
            $this->Cell($w[5],6,'FECHA PUBLICACION','LRBT',0,'C');
            $this->Ln(6);

            foreach($miConsulta as $clave => $Fila):
                $Codigo = $Fila[0];
                $Titulo = $Fila[1];
                $Autor = $Fila[2];
                $Disponible = $Fila[3];
                $Paginas = $Fila[4];
                $Fecha = $Fila[5];

                $this->SetFont('Arial','',10);
                $this->Cell($w[0],6,$Codigo,'LRB',0,'C');
                $this->Cell($w[1],6,$Titulo,'LRB',0,'C');
                $this->Cell($w[2],6,$Autor,'LRB',0,'C');
                $this->Cell($w[3],6,$Disponible,'LRB',0,'C');
                $this->Cell($w[4],6,$Paginas,'LRB',0,'C');
                $this->Cell($w[5],6,$Fecha,'LRB',0,'C');
                $this->Ln(6);
            endforeach;

            $this->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5],4,'','T',0,'C');                

        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Reporte();
    $pdf->Output();
?>
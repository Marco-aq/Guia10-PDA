<?php
    require('./fpdf186/fpdf.php');
    class PDF extends FPDF{
        function Reporte(){
            $w=array(20,80,60,30);

            $hostDB = 'localhost';
            $nombreDB = 'ejemplo';
            $usuarioDB = 'root';
            $contrasenyaDB = 'Miperritoeszeuz1';

            $hostDB = "mysql:host=$hostDB;dbname=$nombreDB;";
            $miPDO = new PDO($hostDB, $usuarioDB, $contrasenyaDB);
            
            $miConsulta = $miPDO->prepare('SELECT * FROM libros;');
            $miConsulta->execute();

            $this->SetFont('Arial','',10);
            $this->Cell($w[0],5,'CODIGO','LRBT',0,'C');
            $this->Cell($w[1],5,'TITULO','LRBT',0,'C');
            $this->Cell($w[2],5,'AUTOR','LRBT',0,'L');
            $this->Cell($w[3],5,'DISPONIBLE','LRBT',0,'L');
            $this->Ln(5);

            foreach($miConsulta as $clave => $Fila):
                $Codigo = $Fila[0];
                $Titulo = $Fila[1];
                $Autor = $Fila[2];
                $Disponible = $Fila[3];

                $this->SetFont('Arial','',10);
                $this->Cell($w[0],5,$Codigo,'LRB',0,'C');
                $this->Cell($w[1],5,$Titulo,'LRB',0,'C');
                $this->Cell($w[2],5,$Autor,'LRB',0,'C');
                $this->Cell($w[3],5,$Disponible,'LRB',0,'C');
                $this->Ln(5);
            endforeach;

            $this->Cell($w[0]+$w[1]+$w[2]+$w[3],4,'','T',0,'C');                

        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Reporte();
    $pdf->Output();
?>
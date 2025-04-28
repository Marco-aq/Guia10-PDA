<?php
ob_start(); 
require('./fpdf186/fpdf.php');

class PDF extends FPDF {
    // Encabezado de la página
    function Header() {
        $this->SetDrawColor(0, 80, 180);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(70);
        $this->Cell(60, 10, 'Reporte de Libros', 1, 0, 'C');
        $this->Ln(20);
    }
    
    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetTextColor(0, 0, 255);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetFont('Arial', 'U', 8);
        $this->Cell(-10, 10, 'listar.php', 0, 0, 'R');
    }
    
    // Método para generar el reporte
    function Reporte(){
        $w = array(15, 57, 35, 23, 20, 40);

        $hostDB = 'localhost';
        $nombreDB = 'ejemplo';
        $usuarioDB = 'root';
        $contrasenyaDB = 'Miperritoeszeuz1';

        $dsn = "mysql:host=$hostDB;dbname=$nombreDB;";
        $miPDO = new PDO($dsn, $usuarioDB, $contrasenyaDB);
        $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        $miConsulta = $miPDO->prepare('SELECT * FROM libros;');
        $miConsulta->execute();

        // Cabecera de la tabla
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        
        $header = array('CODIGO', 'TITULO', 'AUTOR', 'DISPONIBLE', 'PAGINAS', 'FECHA PUBLICACION');
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 6, $header[$i], 'LRBT', 0, 'C', true);
        }
        $this->Ln();

        // Datos de la tabla
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(224, 235, 255);
        $fill = false;
        
        while ($Fila = $miConsulta->fetch(PDO::FETCH_ASSOC)) {
            // Usa isset() para evitar warnings si las claves no existen
            $codigo = isset($Fila['codigo']) ? $Fila['codigo'] : 'N/A';
            $titulo = isset($Fila['titulo']) ? $Fila['titulo'] : 'N/A';
            $autor = isset($Fila['autor']) ? $Fila['autor'] : 'N/A';
            $disponible = isset($Fila['disponible']) ? $Fila['disponible'] : 'N/A';
            $paginas = isset($Fila['NroPaginas']) ? $Fila['NroPaginas'] : 'N/A';
            $fecha = isset($Fila['FechaCreacion']) ? $Fila['FechaCreacion'] : 'N/A';
            
            $this->Cell($w[0], 6, $codigo, 'LRB', 0, 'C', $fill);
            $this->Cell($w[1], 6, $titulo, 'LRB', 0, 'C', $fill);
            $this->Cell($w[2], 6, $autor, 'LRB', 0, 'C', $fill);
            $this->Cell($w[3], 6, $disponible, 'LRB', 0, 'C', $fill);
            $this->Cell($w[4], 6, $paginas, 'LRB', 0, 'C', $fill);
            $this->Cell($w[5], 6, $fecha, 'LRB', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        
        $this->Cell(array_sum($w), 0, '', 'T');

        // Ejemplo de MultiCell para un párrafo
        $this->Ln(10);
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(240, 240, 240);
        $txt = "Este reporte fue generado utilizando la libreria FPDF.\n\nSe han implementado multiples funcionalidades: "
             . "encabezado y pie de pagina personalizados, insercion de imagen, tabla con colores alternados, MultiCell "
             . "para parrafos de texto, y enlaces interactivos.";
        $this->MultiCell(0, 6, $txt, 0, 'J', true);
        
        // Enlace interactivo
        $this->Ln(10);
        $this->SetTextColor(0, 0, 255);
        $this->SetFont('Arial', 'U', 10);
        $this->Write(6, 'Visita nuestra pagina web', 'http://localhost:8000/listar.php');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Reporte();
$pdf->Output();
// ob_end_flush();
?>

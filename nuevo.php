<?php
// Comprobamos si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación básica de campos
    if (empty($_POST['titulo']) || empty($_POST['autor'])) {
        die('Error: Título y Autor son campos obligatorios.');
    }


    // Sanitización y recolección de datos
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $nroPaginas = isset($_POST['NroPaginas']) && is_numeric($_POST['NroPaginas'])
        ? (int)$_POST['NroPaginas']
        : null;
    $fechaCreacion = !empty($_POST['FechaCreacion'])
        ? $_POST['FechaCreacion']
        : date('Y-m-d');


    // Variables de conexión
    $hostDB = 'localhost';
    $nombreDB = 'ejemplo';
    $usuarioDB = 'root';
    $contrasenyaDB = 'Miperritoeszeuz1';


    try {
        $miPDO = new PDO(
            "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8",
            $usuarioDB,
            $contrasenyaDB,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );


        $miInsert = $miPDO->prepare('
            INSERT INTO libros (titulo, autor, disponible, NroPaginas, FechaCreacion)
            VALUES (:titulo, :autor, :disponible, :nroPaginas, :fechaCreacion)
        ');


        $miInsert->execute([
            ":titulo" => $titulo,
            ":autor" => $autor,
            ":disponible" => $disponible,
            ":nroPaginas" => $nroPaginas,
            ":fechaCreacion" => $fechaCreacion
        ]);


        header('Location: listar.php');


    } catch (PDOException $e) {
        die("Error de base de datos: " . $e->getMessage());
    }
}
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" type="text" name="titulo" required>
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" required>
        </p>
        <p>
            <div>¿Disponible?</div>
            <input id="si-disponible" type="radio" name="disponible" value="1" checked>
            <label for="si-disponible">Sí</label>
            <input id="no-disponible" type="radio" name="disponible" value="0">
            <label for="no-disponible">No</label>
        </p>
        <p>
            <label for="nroPaginas">Número de páginas</label>
            <input id="nroPaginas" type="number" name="NroPaginas" min="1" max="10000">
        </p>
        <p>
            <label for="fechaCreacion">Fecha Creación</label>
            <input id="fechaCreacion" type="date" name="FechaCreacion"
               max="<?= date('Y-m-d'); ?>"
               value="<?= date('Y-m-d'); ?>">
        </p>
        <p>
            <input type="submit" value="Guardar">
        </p>
    </form>
</body>
</html>

<?php
// Variables de conexión
$hostDB = 'localhost';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenyaDB = 'Miperritoeszeuz1';

// Variables del formulario
$codigo = $_GET['codigo'] ?? null;
$titulo = $_POST['titulo'] ?? null;
$autor = $_POST['autor'] ?? null;
$disponible = $_POST['disponible'] ?? 0;
$nroPaginas = isset($_POST['NroPaginas']) && is_numeric($_POST['NroPaginas'])
        ? (int)$_POST['NroPaginas']
        : null;  // Valor por defecto si no se ingresa
$fechaCreacion = !empty($_POST['FechaCreacion'])
        ? $_POST['FechaCreacion']
        : date('Y-m-d');

// Conectar a la base de datos
$miPDO = new PDO(
    "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8",
    $usuarioDB,
    $contrasenyaDB,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Procesar POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preparar y ejecutar UPDATE
    $miUpdate = $miPDO->prepare('
        UPDATE libros
        SET titulo = :titulo,
            autor = :autor,
            disponible = :disponible,
            NroPaginas = :nroPaginas,
            FechaCreacion = :fechaCreacion
        WHERE codigo = :codigo
    ');
    $miUpdate->execute([
        ':codigo' => $codigo,
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':disponible' => $disponible,
        ':nroPaginas' => $nroPaginas,
    ':fechaCreacion' => $fechaCreacion
    ]);
    header('Location: listar.php');
    exit();
} else {
    // Obtener datos del libro
    $miConsulta = $miPDO->prepare('SELECT * FROM libros WHERE codigo = :codigo');
    $miConsulta->execute([':codigo' => $codigo]);
    $libro = $miConsulta->fetch();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar - CRUD PHP</title>
</head>
<body>
    <form method="post">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>">
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" value="<?= htmlspecialchars($libro['autor']) ?>">
        </p>
        <p>
            <div>¿Disponible?</div>
            <input id="si-disponible" type="radio" name="disponible" value="1" <?= $libro['disponible'] ? 'checked' : '' ?>>
            <label for="si-disponible">Sí</label>
            <input id="no-disponible" type="radio" name="disponible" value="0" <?= !$libro['disponible'] ? 'checked' : '' ?>>
            <label for="no-disponible">No</label>
        </p>
        <p>
            <input type="hidden" name="codigo" value="<?= $codigo ?>">
            <input type="submit" value="Modificar">
        </p>
        <p>
            <label for="nroPaginas">Número de páginas</label>
            <input id="nroPaginas" type="number" name="NroPaginas"
                min="1" max="10000"
                value="<?= htmlspecialchars($libro['NroPaginas'] ?? '') ?>">
        </p>
        <p>
            <label for="fechaCreacion">Fecha Creación</label>
            <input id="fechaCreacion" type="date" name="FechaCreacion"
                max="<?= date('Y-m-d'); ?>"
                value="<?= htmlspecialchars($libro['FechaCreacion'] ?? date('Y-m-d')) ?>">
        </p>
    </form>
</body>
</html>
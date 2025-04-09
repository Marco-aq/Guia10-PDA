<?php
// Variables de conexión
$hostDB = 'localhost';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenyaDB = 'Miperritoeszeuz1';

// Validar código recibido
$codigo = $_GET['codigo'] ?? null;
if (!$codigo || !is_numeric($codigo)) {
    die("Error: Código no válido.");
}

try {
    // Conectar a la base de datos
    $miPDO = new PDO(
        "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8",
        $usuarioDB,
        $contrasenyaDB,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Preparar y ejecutar DELETE
    $miConsulta = $miPDO->prepare('DELETE FROM libros WHERE codigo = :codigo');
    $miConsulta->execute([
        ':codigo' => $codigo  // Clave con ":" para marcadores de posición
    ]);

    // Redireccionar tras éxito
    header('Location: listar.php');
    exit();

} catch (PDOException $e) {
    die("Error al eliminar: " . $e->getMessage());
}

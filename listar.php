<?php
// Variables
$hostDB = 'localhost';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenyaDB = 'Miperritoeszeuz1';
// Conecta con base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenyaDB);
// Prepara SELECT
$miConsulta = $miPDO->prepare('SELECT * FROM libros;');
// Ejecuta consulta
$miConsulta->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - CRUD PHP</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 2rem;
        background-color: #f0faf0;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 1px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 1.2rem 1rem;
        text-align: center;
        font-size: 0.95em;
    }
    th {
        background-color: #2c5f2d;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    tr:nth-child(even) {
        background-color: #e9f7ef;
    }
    tr:hover {
        background-color: #d4eedd;
    }
    .button {
        display: inline-block;
        border-radius: 20px;
        color: white;
        background-color: #3d8b40;
        padding: 0.6rem 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9em;
        margin: 0.2rem;
    }
    .button:hover {
        background-color: #2c5f2d;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .disponible {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-weight: 500;
    }
    .si {
        background-color: #e8f5e9;
        color: #2c5f2d;
    }
    .no {
        background-color: #ffebee;
        color: #c62828;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    h1 {
        color: #2c5f2d;
        margin: 0;
    }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Biblioteca Digital</h1>
        <a class="button" href="nuevo.php">➕ Nuevo Libro</a>
    </div>
   
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Disponible</th>
                <th>Páginas</th>
                <th>Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($miConsulta as $clave => $valor): ?>
            <tr>
                <td><?= $valor['codigo']; ?></td>
                <td><strong><?= $valor['titulo']; ?></strong></td>
                <td><?= $valor['autor']; ?></td>
                <td>
                    <span class="disponible <?= $valor['disponible'] ? 'si' : 'no' ?>">
                        <?= $valor['disponible'] ? 'Disponible' : 'No disponible' ?>
                    </span>
                </td>
                <td><?= $valor['NroPaginas'] ?? '-' ?></td>
                <td><?= isset($valor['FechaCreacion']) ? (new DateTime($valor['FechaCreacion']))->format('d/m/Y') : '-' ?></td>
                <td>
                    <a class="button" href="modificar.php?codigo=<?= $valor['codigo'] ?>">✏️ Editar</a>
                    <a class="button" href="borrar.php?codigo=<?= $valor['codigo'] ?>">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<!-- Primer comentario con comando -->
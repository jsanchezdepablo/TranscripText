<?php
// Conectando
$connection = new mysqli('localhost', 'root', '', 'proyecto_tfg');
$connection->set_charset("utf8mb4");

//Manejo de errores en la conexión
if (!$connection) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>

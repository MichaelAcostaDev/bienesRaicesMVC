<?php

// Obtener credenciales de variables de entorno (preferir $_ENV sobre getenv())
$dbHost = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
$dbUser = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
$dbPass = $_ENV['DB_PASSWORD'] ?? $_ENV['DB_PASS'] ?? getenv('DB_PASSWORD') ?? getenv('DB_PASS') ?? '';
$dbName = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'bienesraices';
$dbPort = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306;

$db = mysqli_connect(
    $dbHost,
    $dbUser,
    $dbPass,
    $dbName,
    $dbPort
);

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

$db->set_charset('utf8');

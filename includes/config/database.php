<?php

// Obtener credenciales de variables de entorno (preferir $_ENV sobre getenv())
$dbHost = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
$dbUser = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
$dbPass = $_ENV['DB_PASSWORD'] ?? $_ENV['DB_PASS'] ?? getenv('DB_PASSWORD') ?? getenv('DB_PASS') ?? '';
$dbName = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'bienesraices';
$dbPort = (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306);

try {
    $db = mysqli_connect(
        $dbHost,
        $dbUser,
        $dbPass,
        $dbName,
        $dbPort
    );
    
    if (!$db) {
        throw new Exception("Conexión retornó null");
    }
    
    $db->set_charset('utf8');
} catch (Exception $e) {
    http_response_code(500);
    echo "Error de conexión a MySQL.\n";
    echo "Mensaje: " . htmlspecialchars($e->getMessage()) . "\n";
    echo "Host: " . htmlspecialchars($dbHost) . "\n";
    echo "Usuario: " . htmlspecialchars($dbUser) . "\n";
    echo "Puerto: " . htmlspecialchars($dbPort) . "\n";
    echo "Base de datos: " . htmlspecialchars($dbName) . "\n";
    echo "Errno: " . mysqli_connect_errno() . "\n";
    echo "Error: " . mysqli_connect_error() . "\n";
    exit;
}

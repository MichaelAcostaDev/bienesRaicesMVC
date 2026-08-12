<?php

/**
 * Configuración de conexión MySQL para Wasmer Edge
 * 
 * Variables de entorno soportadas:
 * - DB_HOST (requerido)
 * - DB_PORT (opcional, default 3306)
 * - DB_USER (requerido)
 * - DB_PASSWORD (de Wasmer) o DB_PASS (fallback local)
 * - DB_NAME (requerido)
 */

// Obtener variables de entorno con prioridad a valores de producción
$db_host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$db_port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306;
$db_user = $_ENV['DB_USER'] ?? getenv('DB_USER');
$db_password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? $_ENV['DB_PASS'] ?? getenv('DB_PASS');
$db_name = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

// Validar que las variables requeridas existan
$errores_config = [];

if (empty($db_host)) {
    $errores_config[] = 'DB_HOST no está configurado';
}
if (empty($db_user)) {
    $errores_config[] = 'DB_USER no está configurado';
}
if (empty($db_password)) {
    $errores_config[] = 'DB_PASSWORD o DB_PASS no está configurado';
}
if (empty($db_name)) {
    $errores_config[] = 'DB_NAME no está configurado';
}

if (!empty($errores_config)) {
    error_log('Database Configuration Error: ' . implode(', ', $errores_config));
    die('Error de configuración: No se pudieron cargar las variables de base de datos. Verifique las variables de entorno.');
}

// Establecer reporte de errores en mysqli (solo para diagnóstico)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Conectar a MySQL con puerto configurado
    $db = new mysqli(
        $db_host,
        $db_user,
        $db_password,
        $db_name,
        (int)$db_port
    );

    // Configurar charset UTF-8
    $db->set_charset('utf8mb4');

} catch (mysqli_sql_exception $e) {
    // Capturar excepciones de conexión
    $error_message = 'Error al conectar a la base de datos';
    error_log('Database Connection Error: ' . $e->getMessage());
    
    // No mostrar detalles técnicos al usuario
    die($error_message . '. Por favor, contacte al administrador.');
}

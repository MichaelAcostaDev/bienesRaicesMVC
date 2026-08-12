<?php

use Model\ActiveRecord;

/**
 * Cargar variables de entorno
 * 
 * En producción (Wasmer):
 *   Las variables vienen del entorno del sistema
 *   
 * En desarrollo (local):
 *   Se cargan desde .env usando vlucas/phpdotenv
 * 
 * Prioridad: variables de entorno del sistema > .env
 */
require __DIR__ . '/../vendor/autoload.php';

// Cargar .env solo si existe en desarrollo
// En producción, Wasmer proporciona las variables directamente
$env_file = __DIR__ . '/../.env';
if (file_exists($env_file)) {
    try {
        $dotenv = Dotenv\Dotenv::createMutable(dirname($env_file));
        $dotenv->safeLoad();
    } catch (Exception $e) {
        // .env no existe o no es válido, continuar sin él
        // En producción, Wasmer proporciona las variables
    }
}

// Cargar configuración de base de datos
require 'config/database.php';

// Cargar funciones de utilidad
require 'funciones.php';

// Configurar la conexión en ActiveRecord
if (!$db) {
    die('Error de conexión con la base de datos. Por favor, verifique la configuración.');
}

ActiveRecord::setDB($db);
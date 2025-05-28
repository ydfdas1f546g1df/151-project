<?php

// Enable error reporting during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Try core first
    $coreFile = 'core/' . basename($classPath) . '.php';
    if (file_exists($coreFile)) {
        require_once $coreFile;
        return;
    }

    // Then try controllers
    $controllerFile = 'controllers/' . basename($classPath) . '.php';
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        return;
    }

    // Extend here if needed (e.g. models, modules)
    http_response_code(500);
    echo "Autoload error: $classPath not found in core/ or controllers/";
    exit;
});

// Check if server is initialized
if (!file_exists('config/config.php')){
    include 'setup.php';
    die('Server will be initialization.');
}


// Load config constants
require_once 'config/config.php';

// Initialize the app (handles routing, controller loading, etc.)
new core\App();
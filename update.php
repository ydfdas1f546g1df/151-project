<?php

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

    // 3. models  ← NEW
    $file = 'models/' . basename($classPath) . '.php';
    if (file_exists($file)) { require_once $file; return; }

    // Extend here if needed (e.g. models, modules)
    http_response_code(500);
    echo "Autoload error: $classPath not found in core/ or controllers/";
    exit;
});

require_once 'config/config.php';

$version_model = new \models\Version();
$latest_version = $version_model->getLatestVersion();
if ($latest_version !== null) {
// Get all SQL files
    $sql_dir = 'sql/';
    $db = new \core\Database();
    $sql_files = glob($sql_dir . '*.sql');
    natsort($sql_files);

    $currentVersion = is_null($latest_version) ? -1 : (int)$latest_version;
    foreach ($sql_files as $sql_file) {
        // Extract version number from filename (e.g., 01 from 01-users.sql)
        preg_match('/^(\d+)/', basename($sql_file), $matches);
        if (!isset($matches[1])) continue;

        $fileVersion = (int)$matches[1];

        if ($fileVersion > $currentVersion) {
            try {
                $db->executeFile($sql_file);
                echo "<div style='color:green;'>Executed " . basename($sql_file) . " successfully.</div>";
                $version_model->newVersion(str_pad($fileVersion, 2, "0", STR_PAD_LEFT)); // Pad to match filename format
            } catch (PDOException $e) {
                echo "<div style='color:red;'>Error in $sql_file: " . $e->getMessage() . "</div>";
                break;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complete</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Update Complete</h1>
        <p>Your application has been successfully updated to the latest version.</p>
        <a href="index.php" class="btn">Go to Dashboard</a>
    </div>
    </body>
</html>



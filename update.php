<?php
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
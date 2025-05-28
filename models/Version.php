<?php

namespace models;

use core\Database;
class Version
{
    public function __construct()
    {
        $db = new Database();
    }

    public function getLatestVersion()
    {
        $db = new Database();
        $query = "SELECT version FROM APPLICATION_VERSION ORDER BY id DESC LIMIT 1";
        $db->query($query);
        $db->execute();
        $result = $db->single();
        return $result ? $result['version'] : null;
    }

    public function newVersion($version)
    {
        $db = new Database();
        $query = "INSERT INTO APPLICATION_VERSION (version) VALUES (:version)";
        $db->query($query);
        $db->bind(':version', $version);
        return $db->execute();
    }
}
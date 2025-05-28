<?php

namespace models;

use core\Database;

class Permission
{
    public static function getPermissions()
    {
        $db = new Database();
        $query = "SELECT * FROM permission";
        $db->query($query);
        $db->execute();
        return $db->results();
    }
}
<?php

namespace core;

class Middleware
{

    public function check(array $permissions = [])
    {
        $authenticated = false;
        $userRoles = $_SESSION['user']['roles'] ?? [];
        $hasPermission = false;
        // Check if user is not authenticated
        if(in_array('not_authenticated', $permissions)) {
            return;
        }
        // Check if user is authenticated
        if(!isset($_SESSION['user'])) {
            // If user is not authenticated, redirect to login page
            header('Location: index.php?url=login');
            exit;
        }else{
            $authenticated = true;
        }
        // if user is global_admin, skip userpermission checks
        if(in_array('global_admin', $_SESSION['user']['roles'])) {
            return;
        }
        if ($authenticated && 'authenticated' === $permissions[0]) {
            // If user is authenticated, but no permissions are required, return
            return;
        }
        // Check if user has the required permissions
        foreach ($userRoles as $role) {
            if (in_array($role, $permissions)) {
                $hasPermission = true;
                break;
            }
        }


        if (!$hasPermission) {
            http_response_code(403);
            echo "403 - Forbidden: You do not have permission to access this page.";
            echo "<br>Required permissions: " . implode(', ', $permissions);
            echo "<br>Your permissions: " . implode(', ', $userRoles);
            echo "<br><br>";
            echo '<button onclick="history.back()">← Back</button>';
            exit;
        }
    }
}
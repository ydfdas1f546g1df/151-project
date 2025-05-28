<?php

namespace core;

class Middleware
{

    public function check(array $permissions = [])
    {
        // Check if user is not authenticated
        if(in_array('not_authenticated', $permissions)) {
            return;
        }
        // Check if user is authenticated
        if(!isset($_SESSION['user'])) {
            // If user is not authenticated, redirect to login page
            header('Location: index.php?url=login');
            exit;
        }
        // if user is global_admin, skip permission checks
        if(in_array('global_admin', $_SESSION['user']['roles'])) {
            return;
        }
        // Check if user has the required permissions
        if(!empty($permissions) && !in_array($_SESSION['user']['roles'], $permissions)) {
            // If user does not have the required permissions, display 403 error
            http_response_code(403);
            echo "403 - Forbidden: You do not have permission to access this page.";
            echo "<br>Required permissions: " . implode(', ', $permissions);
            exit;
        }
    }
}
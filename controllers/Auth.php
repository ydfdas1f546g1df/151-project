<?php

namespace controllers;

use core\Controller;

class Auth extends Controller
{
    public function login()
    {
        // Check if the user is already authenticated
        if (isset($_SESSION['user'])) {
            // If authenticated, redirect to home page
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $db = $this->getDatabase();

                // Fetch user from the database
                $query = "SELECT * FROM user WHERE username = :username";
                $db->query($query);
                $db->bind('username', $username);
                $db->execute();
                $user = $db->result();
                if ($user && password_verify($password, $user['password'])) {

                    $query = "
        SELECT p.role_name
        FROM permission          AS p
        INNER JOIN user_permission AS up
            ON p.id = up.permission_id
        WHERE up.user_id = :user_id
    ";
                    $db->query($query);
                    $db->bind(':user_id', $user['id']);
                    $db->execute();
                    $permissions = $db->results();           // array of rows
                    $roleNames = array_column($permissions, 'role_name'); // flat array

                    // If user exists and password is correct, set session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'roles' => $roleNames // Assuming roles are stored as comma-separated values
                    ];
                    // Redirect to home page after successful login
                    header('Location: index.php?url=home');
                    exit;
                } else {
                    // If login fails, set an error message
                    $this->data['error'] = 'Invalid username or password.';
                }
            }
        }

        // Display login form or handle login logic here
        $this->renderView('login', $this->data, 'Login', 'public/css/login.css');
    }

    public function logout()
    {
        // Unset the user session
        unset($_SESSION['user']);
        // destroy the session
        session_destroy();
        // Redirect to login page after logout
        header('Location: index.php?url=login');
        exit;
    }
}
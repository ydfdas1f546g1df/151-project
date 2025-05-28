<?php

namespace controllers;

use core\Controller;

class Usermgmt extends Controller
{
    protected \models\User $user_model;
    protected \models\Permission $permission_model;

    public function __construct()
    {
        $this->user_model = new \models\User();
        $this->permission_model = new \models\Permission();
    }

    public function index()
    {
        $this->renderView('usermgmt_index', [
            'users' => $this->user_model->get_all_with_permission(),
        ], 'KSH ERP - User Management', 'public/css/usermgmt_index.css');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $failed = false;
            if (!isset($_POST['username'])) {
                http_response_code(418);
                echo "Username is required.";
                $failed = true;
            }
            if (!isset($_POST['email'])) {
                http_response_code(418);
                echo "Email is required.";
                $failed = true;
            }
            if (!isset($_POST['password'])) {
                http_response_code(418);
                echo "Password is required.";
                $failed = true;
            }
            $username = trim($_POST['username']);
            // check if username is occupied
            $existingUsers = $this->user_model->get_user_by_username($username);
            if (!empty($existingUsers)) {
                http_response_code(409);
                echo "Username is already taken.";
                $failed = true;
            }
            $email = trim($_POST['email']);
            // validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo "Invalid email format.";
                $failed = true;
            }
            // check if email is occupied
            $existingEmail = $this->user_model->get_user_by_email($email);
            if (!empty($existingEmail)) {
                http_response_code(409);
                echo "Email is already registered.";
                $failed = true;
            }
            $password = trim($_POST['password']);
            // validate password length
            if (strlen($password) < 6) {
                http_response_code(400);
                echo "Password must be at least 6 characters long.";
                $failed = true;
            }
            if (!$failed) {
                // Add user to the database
                $result = $this->user_model->add_user($username, $email, $password);
                if ($result) {
                    http_response_code(201);
                    echo "User added successfully.";
                    header("Refresh: 2; url=index.php?url=usermgmt/index");
                } else {
                    http_response_code(500);
                    echo "Failed to add user.";
                }
            }
        }

        $this->renderView('usermgmt_add', [
            'username' => $username ?? '',
            'email' => $email ?? '',
            'password' => $password ?? '',
        ], 'KSH ERP - Add User', 'public/css/usermgmt_add.css');
    }

    public function edit($params = [])
    {
        // Get the user ID from the URL
        $userId = $params[0] ?? null;
        if (!$userId) {
            http_response_code(400);
            echo "User ID is required.";
            header("Location: index.php?url=usermgmt");
            return;
        }
        $userdata = $this->user_model->get_user_by_id($userId);

        if (!$userdata) {
            http_response_code(404);
            echo "User not found.";
            header("Location: index.php?url=usermgmt");
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate Input
            if (!isset($_POST['username'])) {
                http_response_code(418);
                echo "Username is required.";
                die();
            }
            if (!isset($_POST['email'])) {
                http_response_code(418);
                echo "Email is required.";
                die();
            }
            // Change password only if provided
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            // validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo "Invalid email format.";
                die();
            }
            $password = trim($_POST['password'] ?? '');

            $this->user_model->edit_user($userId, $username, $email);
            if (!empty($password)) {
                // Change password only if provided
                $this->user_model->change_password($userId, $password);
            }
            // Redirect to user management page after successful edit and 4 seconds delay
            http_response_code(200);
            echo "User updated successfully.";
            header("Refresh: 2; url=index.php?url=usermgmt/index");
            return;
        }

        $this->renderView('usermgmt_edit', [
            'username' => $userdata['username'],
            'email' => $userdata['email'],
            'userId' => $userId,

        ], 'KSH ERP - Edit User');
    }

    public function delete($params = [])
    {
        $userId = $params[0] ?? null;
        if (!$userId) {
            http_response_code(400);
            echo "User ID is required.";
            header("Refresh: 2;url=index.php?url=usermgmt/index");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user_model->delete_user($userId);
            http_response_code(200);
            echo "User deleted successfully.";
            header("Refresh: 2;url=index.php?url=usermgmt/index");
            return;
        }

        $this->renderView('usermgmt_delete', [
            'userId' => $userId,
            'username' => $this->user_model->get_user_by_id($userId)['username'] ?? '',
        ], 'KSH ERP - Delete User');

    }

    public function edit_permissions($params = []){
        $id = $params[0] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "User ID is required.";
            header("Refresh: 2;url=index.php?url=usermgmt/index");
            return;
        }
        // Check if the user exists
        $user = $this->user_model->get_user_with_permissions($id);
        if (!$user) {
            http_response_code(404);
            echo "User not found.";
            header("Refresh: 2;url=index.php?url=usermgmt/index");
            return;
        }

        $allPermissions = $this->permission_model->getPermissions();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input

            if (!isset($_POST['permissions']) || !is_array($_POST['permissions'])) {
                http_response_code(400);
                echo "Permissions are required.";
                return;
            }
            $permissions = $_POST['permissions'];
            // Validate permissions
            foreach ($permissions as $permission) {
                if (!in_array($permission, array_column($allPermissions, 'role_name'))) {
                    http_response_code(400);
                    echo "Invalid permission: $permission";
                    return;
                }
            }

            // Update user permissions
            $this->user_model->set_permissions($user['id'], $permissions);
            http_response_code(200);
            echo "Permissions updated successfully.";
            header("Refresh: 2;url=index.php?url=usermgmt/index");
            return;
        }

        $this->renderView('usermgmt_permissions', [
            'allPermissions' => $allPermissions,
            'user' => $user,
        ]);
    }
}
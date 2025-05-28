<?php

namespace models;

use core\Database;

class User
{
    public function get_all()
    {
        $db = new Database();
        $query = "SELECT * FROM user";
        $db->query($query);
        $db->execute();
        return $db->results();
    }

    public function get_all_with_permission(){
        $db = new Database();
        $query = "
            SELECT u.*, GROUP_CONCAT(p.role_name) AS roles
            FROM user AS u
            LEFT JOIN user_permission AS up ON u.id = up.user_id
            LEFT JOIN permission AS p ON up.permission_id = p.id
            GROUP BY u.id
        ";
        $db->query($query);
        $db->execute();
        return $db->results();
    }

    public function get_user_with_permissions($id){
        $db = new Database();
        $query = "
            SELECT u.*, GROUP_CONCAT(p.role_name) AS roles
            FROM user AS u
            LEFT JOIN user_permission AS up ON u.id = up.user_id
            LEFT JOIN permission AS p ON up.permission_id = p.id
            WHERE u.id = :id
            GROUP BY u.id
        ";
        $db->query($query);
        $db->bind(':id', $id);
        $db->execute();
        $result = $db->single();
        if (!empty($result['roles'])) {
            $result['roles'] = explode(',', $result['roles']);
        }else{
            $result['roles'] = [];
        }
        return $result;
    }

    public function add_user($username, $email, $password)
    {
        $db = new Database();
        $query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
        $db->query($query);
        $db->bind(':username', $username);
        $db->bind(':email', $email);
        $db->bind(':password', password_hash($password, PASSWORD_DEFAULT));
        return $db->execute();
    }

    public function get_user_by_id($id)
    {
        $db = new Database();
        $query = "SELECT * FROM user WHERE id = :id";
        $db->query($query);
        $db->bind(':id', $id);
        $db->execute();
        return $db->single();
    }

    public function get_user_by_email($email)
    {
        $db = new Database();
        $query = "SELECT * FROM user WHERE email = :email";
        $db->query($query);
        $db->bind(':email', $email);
        $db->execute();
        return $db->single();
    }

    public function delete_user_by_username($username){
        $db = new Database();
        $query = "DELETE FROM user WHERE username = :username";
        $db->query($query);
        $db->bind(':username', $username);
        return $db->execute();
    }

    public function delete_user($id){
        $db = new Database();
        $query = "DELETE FROM user WHERE id = :id";
        $db->query($query);
        $db->bind(':id', $id);
        return $db->execute();
    }

    public function edit_user($id, $username, $email){
        $db = new Database();
        $query = "UPDATE user SET email = :email, username = :username, updated_at = :timestamp WHERE id = :id";
        $db->query($query);
        $db->bind(':username', $username);
        $db->bind(':email', $email);
        $db->bind(':id', $id);
        $db->bind(':timestamp', date('Y-m-d H:i:s'));
        return $db->execute();
    }

    public function change_password($id, $new_password)
    {
        $db = new Database();
        $query = "UPDATE user SET password = :password, updated_at = :timestamp WHERE id = :id";
        $db->query($query);
        $db->bind(':id', $id);
        $db->bind(':password', password_hash($new_password, PASSWORD_DEFAULT));
        $db->bind(':timestamp', date('Y-m-d H:i:s'));
        return $db->execute();
    }

    public function set_permissions($id, $permissions)
    {
        $db = new Database();
        // First, delete existing permissions for the user
        $query = "DELETE FROM user_permission WHERE user_id = (SELECT id FROM user WHERE id = :id)";
        $db->query($query);
        $db->bind(':id', $id);
        $db->execute();

        // Then, insert new permissions
        foreach ($permissions as $permission) {
            $query = "INSERT INTO user_permission (user_id, permission_id) VALUES (:id, (SELECT id FROM permission WHERE role_name = :permission_name))";
            $db->query($query);
            $db->bind(':id', $id);
            $db->bind(':permission_name', $permission);
            $db->execute();
        }
    }

    public function get_user_by_username($username)
    {
        $db = new Database();
        $query = "SELECT * FROM user WHERE username = :username";
        $db->query($query);
        $db->bind(':username', $username);
        $db->execute();
        return $db->single();
    }
}
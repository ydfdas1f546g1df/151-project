<?php
// Check if all variables are set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_port = $_POST['db_port'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    $no_errors = true;

    if (empty($db_host)) {
        echo '<div style="color:red;">';
        echo "Database host is required.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($db_name)) {
        echo '<div style="color:red;">';
        echo "Database name is required.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($db_port)) {
        echo '<div style="color:red;">';
        echo "Database port is required.<br>";
        echo '</div>';
        $no_errors = false;
    }elseif (is_numeric($db_port)){
        if ($db_port < 1 || $db_port > 65535) {
            echo '<div style="color:red;">';
            echo "Database port must be between 1 and 65535.<br>";
            echo '</div>';
            $no_errors = false;
        }
    } else {
        echo '<div style="color:red;">';
        echo "Database port must be a number.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($db_user)) {
        echo '<div style="color:red;">';
        echo "Database user is required.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($db_pass)) {
        echo '<div style="color:red;">';
        echo "Database password is required.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($_POST['admin_name'])) {
        echo '<div style="color:red;">';
        echo "Administrator username is required.<br>";
        echo '</div>';
        $no_errors = false;
    }
    if (empty($_POST['admin_pw'])) {
        echo '<div style="color:red;">';
        echo "Administrator password is required.<br>";
        echo '</div>';
        $no_errors = false;
    } elseif (strlen($_POST['admin_pw']) < 6) {
        echo '<div style="color:red;">';
        echo "Administrator password must be at least 6 characters long.<br>";
        echo '</div>';
        $no_errors = false;
    }

    if (empty($_POST['admin_mail'])) {
        echo '<div style="color:red;">';
        echo "Administrator E-mail is required.<br>";
        echo '</div>';
        $no_errors = false;
    } elseif (!filter_var($_POST['admin_mail'], FILTER_VALIDATE_EMAIL)) {
        echo '<div style="color:red;">';
        echo "Invalid E-mail format.<br>";
        echo '</div>';
        $no_errors = false;
    }

    if ($no_errors) {
        // Check if the database connection can be established
        $dsn = "mysql:host=$db_host;port=$db_port;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div style="color:green;">';
            echo "Database connection successful!<br>";
            echo '</div>';

            // Save the configuration to a file
            $config_content = "<?php\n";
            $config_content .= "define('DB_HOST', '$db_host');\n";
            $config_content .= "define('DB_NAME', '$db_name');\n";
            $config_content .= "define('DB_USER', '$db_user');\n";
            $config_content .= "define('DB_PASS', '$db_pass');\n";
            $config_content .= "define('DB_PORT', '$db_port');\n";

            file_put_contents('config/config.php', $config_content);
            echo "Configuration saved successfully!";

            // Create the database if it does not exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Recreate the PDO connection with the new database
            $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4";
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            // execute the SQL script to create tables
            $sql_dir = 'sql/';
            $sql_files = glob($sql_dir . '*.sql');

            natsort($sql_files);

            foreach ($sql_files as $sql_file) {
                $sql = file_get_contents($sql_file);
                try {
                    $pdo->exec($sql);
                    echo '<div style="color:green;">Executed ' . basename($sql_file) . ' successfully.</div>';
                } catch (PDOException $e) {
                    echo '<div style="color:red;">Error in ' . basename($sql_file) . ': ' . $e->getMessage() . '</div>';
                    echo '<br><a href="setup.php">Go back to setup</a>';
                }
            }


            // Create the admin user
            $admin_name = $_POST['admin_name'];
            $admin_pw = password_hash($_POST['admin_pw'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
            $stmt->bindParam(':username', $admin_name);
            $stmt->bindParam(':password', $admin_pw);
            $stmt->bindParam(':email', $_POST['admin_mail']);
            if ($stmt->execute()) {
                echo '<div style="color:green;">Administrator user created successfully!</div>';
            } else {
                echo '<div style="color:red;">Failed to create administrator user.</div>';
            }
            $admin_id = $pdo->lastInsertId();
            $permission_id = 1; // Assuming 0 is the ID for the Administrator permission

            // Set Administrator permission
            $stmt = $pdo->prepare("INSERT INTO user_permission (user_id, permission_id) VALUES (:user_id, :permission_id)");
            $stmt->bindParam(':user_id', $admin_id);
            $stmt->bindParam(':permission_id', $permission_id);

            if ($stmt->execute()) {
                echo '<div style="color:green;">Administrator permissions set successfully!</div>';
            } else {
                echo '<div style="color:red;">Failed to set administrator permissions.</div>';
            }
            echo '</br></br><h2><a href="index.php">Go to the application</a></h2>';

        } catch (PDOException $e) {
            echo '<div style="color:red;">';
            echo "Database connection failed: " . $e->getMessage();
            echo '</div>';
        }
    }
}

?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: auto;
        align-content: center;
        text-align: left;
    }
    input {
        align-self: center;
        width: 100%;
    }

    button {
        align-self: center;

    }
</style>
<h1>
    Welcome to the Setup Script for KSH ERP!
</h1>

<form action="setup.php" method="post">
    <label for="db_host">Database Host:</label>
    <input type="text" id="db_host" name="db_host" value="<?php echo $_POST['db_host'] ?? ''; ?>" placeholder="localhost" required>
    </br></br>
    <label for="db_name">Database Name:</label>
    <input type="text" id="db_name" name="db_name" value="<?php echo $_POST['db_name'] ?? ''; ?>" placeholder="kue25" required>
    </br></br>
    <label for="db_user">Database Port:</label>
    <input type="number" id="db_port" name="db_port" value="<?php echo $_POST['db_port'] ?? ''; ?>" placeholder="3306" required>
    </br></br>
    <label for="db_user">Database User:</label>
    <input type="text" id="db_user" name="db_user" value="<?php echo $_POST['db_user'] ?? ''; ?>" placeholder="kue25"  required>
    </br></br>
    <label for="db_pass">Database Password:</label>
    <input type="password" id="db_pass" name="db_pass" value="<?php echo $_POST['db_pass'] ?? ''; ?>" placeholder="password" required>
    </br></br>
    <label for="admin_name">Administrator username:</label>
    <input type="text" id="admin_name" name="admin_name" value="<?php echo $_POST['admin_name'] ?? ''; ?>" placeholder="admin" required>
    </br></br>
    <label for="admin_mail">Administrator E-mail:</label>
    <input type="text" id="admin_mail" name="admin_mail" value="<?php echo $_POST['admin_mail'] ?? ''; ?>" placeholder="admin@ksh.local" required>
    </br></br>
    <label for="admin_pw">Administrator username:</label>
    <input type="password" id="admin_pw" name="admin_pw" value="<?php echo $_POST['admin_pw'] ?? ''; ?>" placeholder="password" required>
    </br></br>

    <button type="submit">Setup</button>
</form>

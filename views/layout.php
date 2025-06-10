<?php
// Set the module and view path variables if they are not already set
$viewPath = isset($viewPath) ? $viewPath : 'index';
$title = isset($title) ? $title : 'ERP KSH';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="public/css/global.css">
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($pageCss) ?>">
    <?php endif; ?>
</head>

<body>
    <header class="site-header">
        <h1><?= htmlspecialchars($title); ?></h1>
        <nav class="site-nav">
            <ul>
                <li><a href="index.php?url=home">Home</a></li>
                <li><a href="index.php?url=usermgmt/index">User Management</a></li>
                <li><a href="index.php?url=productmgmt/index">Product Management</a></li>
                <li><a href="index.php?url=logout">Logout</a></li>
                <?php if (!empty($_SESSION['user']['username'])): ?>
                    <li class="username">Username: <?= htmlspecialchars($_SESSION['user']['username']) ?></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <!-- This line includes the PHP file located at '../app/views/' followed by the value of the $viewPath variable and '.php' extension. -->
    <?php require_once 'views/' . $viewPath . '.php'; ?>
</body>

</html>
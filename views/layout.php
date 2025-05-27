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
</head>

<body>
    <!-- This line includes the PHP file located at '../app/views/' followed by the value of the $viewPath variable and '.php' extension. -->
    <?php require_once 'views/' . $viewPath . '.php'; ?>
</body>

</html>
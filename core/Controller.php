<?php

namespace core;

class Controller
{
    protected $data = [];
    protected function loadModel($model)
    {
        // Include the model file from the models directory
        require_once 'controllers/' . $model . '.php';
        // Instantiate and return the model object
        return new $model;
    }

    protected function renderView($viewPath, $data = [], $title = "ERP KSH", $pageCss = null)
    {
        // Extract the data array into individual variables
        extract($data);
        // Include the layout file from the views directory
        require_once 'views/layout.php';
    }

    protected function getDatabase()
    {
        // Include the database connection file
        require_once 'core/Database.php';
        // Return a new instance of the Database class
        return new Database();
    }


}
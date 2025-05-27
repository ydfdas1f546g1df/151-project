<?php

namespace core;

class controller
{
    protected function loadModel($model)
    {
        // Include the model file from the models directory
        require_once 'controllers/' . $model . '.php';
        // Instantiate and return the model object
        return new $model;
    }

    protected function renderView($viewPath, $data = [], $title = "ERP KSH")
    {
        // Extract the data array into individual variables
        extract($data);
        // Include the layout file from the views directory
        require_once 'views/layout.php';
    }
}
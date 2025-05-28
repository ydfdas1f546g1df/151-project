<?php

namespace controllers;

use core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->renderView('home', [], 'KSH ERP - Home');
    }
}
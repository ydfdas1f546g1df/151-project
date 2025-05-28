<?php

namespace controllers;

use core\Controller;

class Usermgmt extends Controller
{
    public function index()
    {
        $this->renderView('usermgmt_index', [], 'KSH ERP - User Management');
    }
}
<?php

namespace controllers;

class Info
{
    public function index()
    {
        phpinfo();

        print_r( $_SESSION);
    }
}
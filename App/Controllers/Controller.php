<?php

namespace App\Controllers;

abstract class Controller
{
    protected object $model;
    protected string $modelName;

    public function __construct()
    {
        $class = $this->modelName;
        $this->model = new $class();
    }
}

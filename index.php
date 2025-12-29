<?php

use App\Autoloader;
use App\Core\Application;

require __DIR__ . '/App/Autoloader.php';

Autoloader::register();
Application::process();
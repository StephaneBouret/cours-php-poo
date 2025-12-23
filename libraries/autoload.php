<?php

spl_autoload_register(function($className) {
    // className = Controllers\Article
    // require = libraries/controllers/Article.php
    $className = str_replace('\\', '/', $className);

    require_once("libraries/$className.php");
});
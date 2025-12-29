<?php

namespace App;

final class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload(string $class): void
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        $file = __DIR__ . '/' . $class . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}

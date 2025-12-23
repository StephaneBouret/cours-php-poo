<?php

class Renderer
{
    public static function render(string $path, array $variables = []): void
    {
        $root = dirname(__DIR__); // remonte de /libraries vers /cours-php-poo

        $templateFile = $root . '/templates/' . $path . '.html.php';
        $layoutFile   = $root . '/templates/layout.html.php';

        foreach ($variables as $key => $_) {
            if (!is_string($key) || !preg_match('/^[a-zA-Z_]\w*$/', $key)) {
                throw new InvalidArgumentException("Clé invalide pour une variable: " . print_r($key, true));
            }
        }

        if (!is_file($templateFile)) {
            throw new RuntimeException("Template introuvable: $templateFile");
        }

        $pageContent = (function (string $__file, array $__vars) {
            extract($__vars, EXTR_SKIP);
            ob_start();
            require $__file;
            return ob_get_clean();
        })($templateFile, $variables);

        // rendre dispo $pageTitle dans le layout
        extract($variables, EXTR_SKIP);

        require $layoutFile;
    }
}

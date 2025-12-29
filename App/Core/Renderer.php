<?php

namespace App\Core;

use InvalidArgumentException;

final class Renderer
{
    public static function render(string $path, array $variables = []): void
    {
        // Racine projet : on remonte de /App/Core vers la racine
        $root = dirname(__DIR__, 2);

        $templateFile = $root . '/templates/' . $path . '.html.php';
        $layoutFile   = $root . '/templates/layout.html.php';

        foreach ($variables as $key => $_) {
            if (!is_string($key) || !preg_match('/^[a-zA-Z_]\w*$/', $key)) {
                throw new InvalidArgumentException("Nom de variable invalide : " . print_r($key, true));
            }
        }

        $pageContent = (function (string $__file, array $__vars) {
            extract($__vars, EXTR_SKIP);
            ob_start();
            require $__file;
            return ob_get_clean();
        })($templateFile, $variables);

        // rendre dispo les variables du template dans le layout (ex. $pageTitle)
        extract($variables, EXTR_SKIP);

        require $layoutFile;
    }
}

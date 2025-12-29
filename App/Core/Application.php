<?php

namespace App\Core;

use App\Controllers\ArticleController;
use App\Controllers\CommentController;

final class Application
{
    public static function process(): void
    {
        $controller = $_GET['controller'] ?? 'article';
        $task = $_GET['task'] ?? 'index';

        switch ($controller) {
            case 'article':
                $c = new ArticleController();

                switch ($task) {
                    case 'index':
                        $c->index();
                        break;
                    case 'show':
                        $c->show();
                        break;
                    case 'delete':
                        $c->delete();
                        break;
                    default:
                        self::error404("Task article inconnue");
                }
                break;

            case 'comment':
                $c = new CommentController();

                switch ($task) {
                    case 'insert':
                        $c->insert();
                        break;
                    case 'delete':
                        $c->delete();
                        break;
                    default:
                        self::error404("Task comment inconnue");
                }
                break;

            default:
                self::error404("Controller inconnu");
        }
    }

    private static function error404(string $message): void
    {
        http_response_code(404);
        echo "404 - $message";
        exit();
    }
}

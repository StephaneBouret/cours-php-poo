<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Core\Http;
use App\Core\Renderer;

final class ArticleController extends Controller
{
    protected string $modelName = Article::class;

    public function index(): void
    {
        $articles = $this->model->findAll("created_at DESC");
        $pageTitle = "Accueil";

        Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    public function show(): void
    {
        $articleId = null;
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $articleId = (int) $_GET['id'];
        }
        if (!$articleId) {
            die("Vous devez préciser un paramètre `id` dans l'URL !");
        }

        $article = $this->model->find($articleId);
        if (!$article) {
            die("L'article $articleId n'existe pas !");
        }

        $commentModel = new Comment();
        $commentaires = $commentModel->findAllByArticle($articleId);

        $pageTitle = $article['title'];

        Renderer::render('articles/show', [
            'pageTitle' => $pageTitle,
            'article' => $article,
            'commentaires' => $commentaires,
            'article_id' => $articleId
        ]);
    }

    public function delete(): void
    {
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $id = (int) $_GET['id'];

        $article = $this->model->find($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        $this->model->delete($id);

        Http::redirect("index.php");
    }
}

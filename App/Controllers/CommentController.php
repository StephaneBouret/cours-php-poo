<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Article;
use App\Core\Http;

final class CommentController extends Controller
{
    protected string $modelName = Comment::class;

    public function insert(): void
    {
        $author = !empty($_POST['author']) ? $_POST['author'] : null;
        $content = !empty($_POST['content']) ? htmlspecialchars($_POST['content']) : null;

        $articleId = null;
        if (!empty($_POST['article_id']) && ctype_digit($_POST['article_id'])) {
            $articleId = (int) $_POST['article_id'];
        }

        if (!$author || !$articleId || !$content) {
            die("Votre formulaire a été mal rempli !");
        }

        $articleModel = new Article();
        $article = $articleModel->find($articleId);

        if (!$article) {
            die("Ho ! L'article $articleId n'existe pas boloss !");
        }

        $this->model->insert($author, $content, $articleId);

        Http::redirect("index.php?controller=article&task=show&id=" . $articleId);
    }

    public function delete(): void
    {
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }

        $id = (int) $_GET['id'];

        $commentaire = $this->model->find($id);
        if (!$commentaire) {
            die("Aucun commentaire n'a l'identifiant $id !");
        }

        $articleId = (int) $commentaire['article_id'];
        $this->model->delete($id);

        Http::redirect("index.php?controller=article&task=show&id=" . $articleId);
    }
}

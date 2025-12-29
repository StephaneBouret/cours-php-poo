<?php

namespace App\Models;

use PDO;
use App\Core\Database;

abstract class Model
{
    protected PDO $pdo;
    protected string $table;

    public function __construct()
    {
        $this->pdo = Database::getPdo();
    }

    /**
     * Retourne la liste des articles classés par date de création
     *
     * @return array
     */
    public function findAll(?string $order = ""): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($order) {
            $sql .= " ORDER BY $order";
        }
        
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Retourne un article grâce à son identifiant
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id): array|false
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);

        return $query->fetch();
    }

    /**
     * Supprime un commentaire grâce à son identifiant
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}

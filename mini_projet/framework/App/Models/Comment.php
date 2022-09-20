<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class Comment extends AbstractModel
{
    /**
     * Récupère tous les commentaires
     * 
     * @return array
     */
    public function findAll(): array
    {
        return $this->db->getAll(
            'SELECT c.id, c.nickname, c.content, c.created_at, c.post_id, p.title
            FROM Comments c
            INNER JOIN posts p ON p.id = c.post_id
            ORDER BY c.created_at DESC'
        );
    }
    
    /**
     * Récupère tous les commentaires d'un article dont l'id est spécifié
     * 
     * @param int $postId L'id de l'article dont je veux tous les commentaires
     * @return array La liste des commentaires de l'article
     */
    public function findByPost(int $postId): array
    {
        return $this->db->getAll(
            'SELECT c.id, c.nickname, c.content, c.created_at, c.post_id
            FROM Comments c
            WHERE c.post_id = ?
            ORDER BY c.created_at DESC', [
                $postId    
            ]
        );
    }
    
    public function create(array $comment): void
    {
        $this->db->execute(
            
            'INSERT INTO Comments ( content, event_id, user_id) VALUES (?, ?, ?)', [
                $comment['content'],
                $comment['event_id'],
                $comment['user_id']
            ]
        );
    }

    public function findx(int $id): ? array
    {
        return $this->db->getAll(
            'SELECT c.id, c.content, c.created_at, c.user_id, c.event_id
            FROM Comments c
            INNER JOIN Users u ON c.user_id = u.id
            INNER JOIN Events e ON e.id = c.event_id
            limit 5'
        );
    }
}
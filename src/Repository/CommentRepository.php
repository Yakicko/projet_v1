<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 14:37
 */

namespace Repository;

use Entity\Recipe;
use Entity\Comment;
use Entity\User;

class CommentRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'comments';
    }

    public function findAll()
    {
        $dbComments = $this->db->fetchAll('SELECT * FROM comments c JOIN users u ON c.id_user = u.id_user');

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }

    /*public function findComment()
    {
        $dbComments = $this->db->fetchAll('SELECT * FROM comments');

        $comments = [];

        foreach($dbComments as $dbComment){
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }*/

    public function find($id_comment)
    {
        $dbComment = $this->db->fetchAssoc(
            'SELECT * FROM comments WHERE id_comment = :id_comment',
            [
                ':id_comment' => $id_comment
            ]
        );
        if(!empty($dbComment)){
            return $this->buildEntity($dbComment);
        }
    }

    public function findByIdRecipe($id_recipe)
    {
        $query = 'SELECT * FROM comments c JOIN users u ON c.id_user = u.id_user WHERE c.id_recipe = :id_recipe';

        $dbComments = $this->db->fetchAll($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function save(Comment $comment)
    {
        // Les données à enregistrer en BDD
        $data = [
            'id_comment' => $comment->getId_comment(),
            'id_user' => $comment->getId_user(),
            'id_recipe' => $comment->getId_recipe(),
            'content' => $comment->getContent()
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($comment->getId_comment()))
        {
            $comment->setId_comment($this->db->lastInsertId());
        }
    }

    public function delete(Comment $comment)
    {
        $this->db->delete(
            'comments',
                ['id_comment' => $comment->getId_comment()]
        );
    }

    private function buildEntity(array $data)
    {

        $comment = new Comment();

        $comment->setId_comment($data['id_comment'])
                ->setId_user($data['id_user'])
                ->setId_recipe($data['id_recipe'])
                ->setContent($data['content']);

        $user = new User();

        $user
            ->setId_user($data['id_user'])
            ->setUsername($data['username'])
        ;

        $comment->setUser($user);

        return $comment;
    }
}
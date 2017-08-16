<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 11/08/2017
 * Time: 14:37
 */

namespace Repository;

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
        //modif
        $query = 'SELECT * FROM comments c'
            . ' JOIN users u ON c.id_user = u.id_user'
            . ' JOIN recipes r ON c.id_recipe = r.id_recipe'
        ;

        $dbComments = $this->db->fetchAll($query);

        $comments = [];

        foreach ($dbComments as $dbComment)
        {
            $comment = $this->buildEntity($dbComment);

            $comments[] = $comment;
        }

        return $comments;
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

        if (isset($data['username'])) {
            $comment->setUserName($data['username']);
        }

        if (isset($data['title'])) {
            $comment->setRecipeName($data['title']);
        }

//        $user
//            ->setId_user($data['id_user'])
//            ->setUsername($data['username'])
//        ;

        $comment->setUser($user);

        return $comment;
    }
}
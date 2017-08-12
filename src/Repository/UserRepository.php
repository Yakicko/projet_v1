<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract
{
    protected function getTable()
    {
            return 'users';
    }


    public function find($id_user)
    {
        $query = 'SELECT * FROM users WHERE id_user = :id_user';

        $dbUser = $this->db->fetchAssoc($query,
            [
                ':id_user' => $id_user
            ]
        );

        if (!empty($dbUser))
        {
            return $this->buildEntity($dbUser);
        }
    }

    public function findById($id_user)
    {
        $query = 'SELECT c.*, u.* FROM comments c JOIN users u ON c.id_user = u.id_user WHERE c.id_user = :id_comment';

        $dbComment = $this->db->fetchAssoc($query,
            [
                ':id_comment' => $id_user
            ]
        );

        if (!empty($dbComment))
        {
            return $this->buildEntity($dbComment);

        }
    }

    public function findByUsername($username)
    {
            $dbUser = $this->db->fetchAssoc(
                    'SELECT * FROM users WHERE username = :username',
                    [
                            ':username' => $username
                    ]
            );

            if(!empty($dbUser)){
                    return $this->buildEntity($dbUser);
            }
    }

    public function findByEmail($email)
    {
            $dbUser = $this->db->fetchAssoc(
                    'SELECT * FROM users WHERE email = :email',
                    [
                            ':email' => $email
                    ]
            );

            if(!empty($dbUser)){
                    return $this->buildEntity($dbUser);
            }
    }

    public function isUnique($username)
    {
            $dbUser = $this->db->fetchAssoc(
                    'SELECT * FROM users WHERE username = :username',
                    [
                            ':username' => $username
                    ]
            );

            if(!empty($dbUser)){
                    return $this->buildEntity($dbUser);
            }
    }


    public function myRecipe($id_user)
    {
            $dbMyRecipe = $this->db->fetchAll(
                    'SELECT * FROM recipes WHERE id_user = :id_user',
                    [
                            ":id_user" => $id_user
                    ]
            );

            $nb_myRecipe = count($dbMyRecipe);
                    return $nb_myRecipe;
    }

    public function myComments($id_user)
    {
            $dbMyComments = $this->db->fetchAll(
                    'SELECT * FROM comments WHERE id_user = :id_user',
                    [
                            ":id_user" => $id_user
                    ]
            );

            $nb_myComments = count($dbMyComments);
                    return $nb_myComments;
    }

    public function myRatings($id_user)
    {
            $dbMyRatings = $this->db->fetchAll(
                    'SELECT * FROM rating WHERE id_user = :id_user',
                    [
                            ":id_user" => $id_user
                    ]
            );

            $nb_myRatings = count($dbMyRatings);
                    return $nb_myRatings;
    }

    public function save(User $user)
    {
            // les données à enregistrer en bdd
            $data = [
                                    'lastname' => $user->getLastname(),
                                    'firstname' => $user->getFirstname(),
                                    'email' => $user->getEmail(),
                                    'username' => $user->getUsername(),
                                    'civility' => $user->getCivility(),
                                    'id_region' => $user->getId_region(),
                                    'password' => $user->getPassword()
                            ];


            // appel à la méthode de RepositoryAbstract pour enregistrer
            $this->persist($data);

            // on set l'id quand on est en insert		
            $user->setId_user($this->db->lastInsertId());

    }

    /*
    @param array $data
    @return User
     */
    private function buildEntity(array $data)
    {
            $user = new User();

            $user
                    ->setId_user($data['id_user'])
                    ->setLastname($data['lastname'])
                    ->setFirstname($data['firstname'])
                    ->setEmail($data['email'])
                    ->setUsername($data['username'])
                    ->setCivility($data['civility'])
                    ->setUsername($data['username'])
                    ->setId_region($data['id_region'])
                    ->setStatus($data['status'])
                    ->setPassword($data['password'])
            ;
            return $user;
    }
}

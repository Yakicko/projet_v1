<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'users';
	}

	 /**
     * 
     * @return array Un tableau d'objets Entity\Category
     */
    public function findAll()
    {
        $dbusers = $this->db->fetchAll('SELECT * FROM users');  
        
        $users = [];
        
        foreach ($dbusers as $dbuser){
            $user = $this->buildEntity($dbuser);
            
            $users[] = $user;
        }
        
        return $users;
    }

    /**
     * 
     * @param int $id
     * @return Category|null
     */
    public function find($id_user)
    {
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE id_user = :id_user',
            [
                ':id_user' => $id_user
            ]
        );
        if (!empty($dbUser)){
            return $this->buildEntity($dbUser);
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

	public function findByEmail($email, $excludedId = null)
	{
		$query = 'SELECT * FROM users WHERE email = :email';
		$params = [ ':email' => $email ];

		if (!is_null($excludedId)) {
			$query .= ' AND id_user != :id';
			$params[ ':id' ] = $excludedId;
		}

		$dbUser = $this->db->fetchAssoc(
			$query,
			$params
		);

		if(!empty($dbUser)){
			return $this->buildEntity($dbUser);
		}
	}

	public function isUnique($username, $excluded = null)
	{
		$queries = 'SELECT * FROM users WHERE username = :username';
		$param = [':username' => $username];

		if(!is_null($excluded)){
			$queries .= ' AND id_user != :id';
			$param[ ':id' ] = $excluded;
		}

		$dbUser = $this->db->fetchAssoc(
			$queries,
			$param
		);

		if(!empty($dbUser)){
			return $this->buildEntity($dbUser);
		}
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
					'password' => $user->getPassword(),
					'status' => $user->getStatus()
				];

	
		$where = !empty($user->getId_user())
			? ['id_user' => $user->getId_user()]
			: null
		;

		// appel à la méthode de RepositoryAbstract pour enregistrer
		$this->persist($data, $where);

		// on set l'id quand on est en insert		
		$user->setId_user($this->db->lastInsertId());
		
	}

	public function delete (User $user)
    {
        $this->db->delete(
            'users',
                ['id_user' => $user->getId_user()]
        );
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

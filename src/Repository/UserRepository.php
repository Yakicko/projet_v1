<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'users';
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

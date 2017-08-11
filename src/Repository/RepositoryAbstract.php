<?php

namespace Repository;

use Silex\Application;

abstract class RepositoryAbstract
{
	protected $db;

	public function __construct(Application $app)
	{
		$this->db = $app['db'];
	}

	public function persist(array $data)
	{
		// insertion
		$this->db->insert($this->getTable(), $data);
		
	}

	/*
	oblige les classes filles à définir cette méthode
	qui renvoit le nom de la table à laquelle elles font référence
	 */
	abstract protected function getTable();
}


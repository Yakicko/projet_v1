<?php

namespace Repository;

use Silex\Application;

abstract class RepositoryAbstract
{
	protected $db;

    protected $app;

	public function __construct(Application $app)
	{
		$this->db = $app['db'];
        $this->app = $app;
	}

    public function persist(array $data, array $where = null)
    {
        if (is_null($where)) {
            $this->db->insert($this->getTable(), $data);
        } else {
            $this->db->update($this->getTable(), $data, $where);
        }
    }

	/*
	oblige les classes filles à définir cette méthode
	qui renvoit le nom de la table à laquelle elles font référence
	 */
	abstract protected function getTable();
}


<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 02/08/2017
 * Time: 14:45
 */

namespace Repository;


use Silex\Application;

/**
 * Class RepositoryAbstract
 * @package Repository
 */
abstract class RepositoryAbstract
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * RepositoryAbstract constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->db = $app['db'];
    }

    public function persist(array $data, array $where = null)
    {
        if(is_null($where))
        {
            $this->db->insert($this->getTable(), $data);
        }
        else
        {
            $this->db->update($this->getTable(), $data, $where);
        }
    }


    /**
     * Oblige les classes filles à définir cette méthode qui renvoit le nom de la table à laquelle elles font référence
     */
    abstract protected function getTable();
}
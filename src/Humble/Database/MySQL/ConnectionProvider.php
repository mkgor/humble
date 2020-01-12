<?php

namespace Humble\Database\MySQL;

use Humble\Database\ProviderInterface;
use Humble\DatabaseManager;

/**
 * Class Engine
 *
 * @package Humble
 */
class ConnectionProvider implements ProviderInterface
{
    /**
     * @var \PDO
     */
    private $dbo;

    /**
     * @return \PDO
     */
    public function getDbo()
    {
        return $this->dbo;
    }

    /**
     * @param \PDO $dbo
     */
    public function setDbo($dbo)
    {
        $this->dbo = $dbo;
    }

    /**
     * Engine constructor.
     */
    public function __construct()
    {
        $connectionConfiguration = DatabaseManager::getConfiguration('connection');

        $dsn = sprintf('mysql:dbname=%s;host=%s', $connectionConfiguration['db'], $connectionConfiguration['host']);

        $this->setDbo(new \PDO($dsn, $connectionConfiguration['user'], $connectionConfiguration['password'], [
            \PDO::ATTR_PERSISTENT,
        ]));
    }

    /**
     * @param string $queryString
     * @param array  $params
     *
     * @return mixed
     */
    public function query($queryString, array $params = [])
    {
        $statement = $this->getDbo()->prepare($queryString);
        $statement->execute($params);

        return $statement->fetchObject();
    }
}
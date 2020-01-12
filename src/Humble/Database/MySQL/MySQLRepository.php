<?php

namespace Humble\Database\MySQL;

use Humble\Database\ProviderInterface;
use Humble\Database\RepositoryInterface;
use Humble\DatabaseManager;
use Humble\Query\QueryInterface;
use MongoDB\Driver\Query;

/**
 * Class FallbackRepository
 *
 * @package Humble\Repository
 */
class MySQLRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    private $entity;

    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * CommonRepository constructor.
     *
     * @param string $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;

        /** @var ProviderInterface provider */
        $this->provider = DatabaseManager::getConfiguration('module')['provider'];
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed  $value
     * @param string $primaryKey
     *
     * @param array  $columns
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($value, $primaryKey = 'id', $columns = ['*'])
    {
        /** Generating unique placeholder for PDO */
        $placeholder = DatabaseManager::generatePlaceholder();

        $query = sprintf("SELECT %s FROM %s WHERE `%s` = %s", implode(',', $columns), $this->getEntity(),
                                                                                                    $primaryKey, $placeholder);
        return $this->provider->query($query, [
            $placeholder => $value,
        ]);
    }

    /**
     * @param array $columns
     * @param array $criteria
     *
     * @return mixed
     */
    public function getBy($columns, ...$criteria)
    {
        $query = sprintf("SELECT %s FROM %s ", is_array($columns) ? implode(',', $columns) : $columns, $this->getEntity());

        $params = [];

        /** @var QueryInterface $item */
        foreach ($criteria as $item) {
            /** Getting an array which contains compiled query part and array of params */
            $compiled = $item->getCompiled();

            /** Adding query part to query string */
            $query .= $compiled['query_part'];

            /** Inserting params from criteria to general params array */
            $params = array_merge($params, $compiled['params']);
        }

        return $this->provider->query($query, $params);
    }

    /**
     * @param array $condition
     * @param array $values
     *
     * @return mixed
     */
    public function update(array $condition, array $values)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param array $values
     *
     * @return mixed
     */
    public function insert(array $values)
    {
        // TODO: Implement insert() method.
    }

    /**
     * @param array $condition
     *
     * @return mixed
     */
    public function delete(array $condition)
    {
        // TODO: Implement delete() method.
    }
}
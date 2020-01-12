<?php

namespace Humble\Database\MySQL;

use Humble\Database\ProviderInterface;
use Humble\Database\RepositoryInterface;
use Humble\Database\RepositoryTrait;
use Humble\DatabaseManager;

/**
 * Class FallbackRepository
 *
 * @package Humble\Repository
 */
class MySQLRepository implements RepositoryInterface
{
    use RepositoryTrait;

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
     * @param array|string  $criteria
     *
     * @param string $columns
     *
     * @return mixed
     */
    public function getBy($criteria, $columns = '*')
    {
        $query = sprintf("SELECT %s FROM %s", is_array($columns) ? implode(',', $columns) : $columns, $this->getEntity());

        $params = [];

        $this->buildCriteria($query, $params, $criteria);

        return $this->provider->query($query, $params);
    }

    /**
     * @param array $criteria
     * @param array $values
     *
     * @return mixed
     * @throws \Exception
     */
    public function update(array $criteria, array $values)
    {
        $params = [];

        $query = sprintf('UPDATE %s SET', $this->getEntity());

        $setArray = [];

        foreach ($values as $key => $value) {
            if(is_int($key)) {
                $setArray[] = $value;
            } else {
                $placeholder = DatabaseManager::generatePlaceholder();

                $setArray[] = sprintf(' %s = %s', $key, $placeholder);

                $params[$placeholder] = $value;
            }
        }

        $query .= implode(',', $setArray);

        $this->buildCriteria($query, $params, $criteria);

        return $this->provider->query($query, $params);
    }

    /**
     * @param array $values
     *
     * @return mixed
     * @throws \Exception
     */
    public function insert(array $values)
    {
        $insertValues = [];
        $params = [];

        foreach($values as $key => $value) {
            $placeholder = DatabaseManager::generatePlaceholder();

            $insertValues[] = $placeholder;

            $params[$placeholder] = $value;
        }

        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->getEntity(), implode(',', (array_map(function($item) {
            return sprintf('`%s`', $item);
        }, array_keys($values)))), implode(',', array_keys($params)));

        return $this->provider->query($query, $params);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function delete(array $criteria)
    {
        $params = [];
        $query = sprintf('DELETE FROM %s', $this->getEntity());

        $this->buildCriteria($query, $params, $criteria);

        return $this->provider->query($query, $params);
    }
}
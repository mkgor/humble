<?php


namespace Humble\Database;

/**
 * Interface RepositoryInterface
 * @package Repository
 */
interface RepositoryInterface
{
    /**
     * @param $primaryKey
     * @return mixed
     */
    public function get($primaryKey);

    /**
     * @param array|string $columns
     * @param array $criteria
     *
     * @return mixed
     */
    public function getBy($criteria, $columns);

    /**
     * @param array $condition
     * @param array $values
     *
     * @return mixed
     */
    public function update(array $criteria, array $values);

    /**
     * @param array $values
     *
     * @return mixed
     */
    public function insert(array $values);

    /**
     * @param array $conditions
     *
     * @return mixed
     */
    public function delete(array $conditions);
}
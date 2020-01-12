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
     * @param       $columns
     * @param array $criteria
     *
     * @return mixed
     */
    public function getBy($columns, ...$criteria);

    /**
     * @param array $condition
     * @param array $values
     *
     * @return mixed
     */
    public function update(array $condition, array $values);

    /**
     * @param array $values
     *
     * @return mixed
     */
    public function insert(array $values);

    /**
     * @param array $condition
     *
     * @return mixed
     */
    public function delete(array $condition);
}
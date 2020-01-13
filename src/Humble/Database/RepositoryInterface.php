<?php


namespace Humble\Database;

/**
 * Interface RepositoryInterface
 * @package Repository
 */
interface RepositoryInterface
{
    /**
     * @param $value
     * @param string $primaryKey
     * @param string $columns
     * @return mixed
     */
    public function get($value, $primaryKey = 'id', $columns = '*');

    /**
     * @param array|string $columns
     * @param array $criteria
     *
     * @return mixed
     */
    public function getBy($criteria, $columns = '*');

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

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function query($query, $params);

    /**
     * @return array
     */
    public static function getTableAliasCollection();

    /**
     * @param $table
     * @param $alias
     * @return mixed
     */
    public static function setTableAlias($table, $alias);
}
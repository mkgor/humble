<?php


namespace Humble\Repository;

use Humble\Criteria\CriteriaInterface;

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
    public function find($primaryKey);

    /**
     * @param array $criteria
     * @return mixed
     */
    public function findBy(...$criteria);
}
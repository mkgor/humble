<?php

namespace Humble\Repository;

use Humble\Criteria\CriteriaInterface;
use Humble\Repository\RepositoryInterface;

/**
 * Class FallbackRepository
 * @package Humble\Repository
 */
class FallbackRepository implements RepositoryInterface
{
    /**
     * @param $primaryKey
     * @return mixed
     */
    public function find($primaryKey)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param array $criteria
     * @return mixed
     */
    public function findBy(...$criteria)
    {
        // TODO: Implement findBy() method.
    }
}
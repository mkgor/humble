<?php


namespace Humble\Database;

use Humble\Query\QueryInterface;

/**
 * Trait RepositoryTrait
 *
 * @package Humble\Database
 */
trait RepositoryTrait
{
    /**
     * @param string $query
     * @param array  $params
     * @param mixed  ...$criteria
     */
    public function buildCriteria(&$query, &$params, $criteria)
    {
        /** @var QueryInterface $item */
        foreach ($criteria as $item) {
            /** Getting an array which contains compiled query part and array of params */
            $compiled = $item->getCompiled();

            /** Adding query part to query string */
            $query .= $compiled['query_part'];

            if(isset($compiled['params'])) {
                /** Inserting params from criteria to general params array */
                $params = array_merge($params, $compiled['params']);
            }
        }
    }
}
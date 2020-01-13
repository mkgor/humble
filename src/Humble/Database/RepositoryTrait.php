<?php


namespace Humble\Database;

use Humble\Exception\HumbleException;
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
     * @param array $params
     * @param array $criteria
     */
    public function buildCriteria(&$query, &$params, $criteria)
    {
        /** @var QueryInterface $item */
        foreach ($criteria as $item) {
            /** Getting an array which contains compiled query part and array of params */
            $compiled = $item->getCompiled();

            /** Adding query part to query string */
            $query .= $compiled->getQueryPart();

            /** Inserting params from criteria to general params array */
            $params = array_merge($params, $compiled->getParameters());
        }
    }

    /**
     * @param $values
     * @return array
     */
    public function buildValuesArray($values)
    {
        $_values = [];

        if(is_object($values)) {
            foreach($values as $key => $value) {
                $_values[$key] = $value;
            }
        } else {
            $_values = $values;
        }

        return $_values;
    }
}
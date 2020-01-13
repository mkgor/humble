<?php

namespace Humble\Query;

use Humble\Database\RepositoryInterface;
use Humble\DatabaseManager;
use Humble\Exception\HumbleException;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

/**
 * Class Where
 *
 * @package Humble\Query
 */
class Where implements QueryInterface
{
    /**
     * @var array
     */
    private $predicates;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $compiled;

    /**
     * @var string
     */
    private $operator = 'AND';

    /**
     * Where constructor.
     *
     * @param array $conditions
     *
     * @throws \Exception
     */
    public function __construct(...$conditions)
    {
        foreach ($conditions as $condition) {
            /** If condition is array, handling it and preparing parameters, if it is string - putting it as is */
            if (is_array($condition)) {

                /** Handling custom condition case */
                if (count($condition) == 3) {
                    $placeholder = DatabaseManager::generatePlaceholder();
                    $this->params[$placeholder] = $condition[2];

                    $this->predicates[] = sprintf('%s %s %s', $condition[0], $condition[1], $placeholder);

                    continue;
                }

                /** Handling common WHERE case (key = value) */
                if (count($condition) == 1) {
                    foreach ($condition as $key => $value) {
                        $placeholder = DatabaseManager::generatePlaceholder();
                        $this->params[$placeholder] = $value;

                        $this->predicates[] = sprintf('%s = %s', $key, $placeholder);
                    }

                    continue;
                }

                /** If condition structure is unknown */
                throw new HumbleException(sprintf('Invalid condition provided to WHERE (type: %s)', gettype($condition)));
            } elseif ($condition instanceof Where) {
                $condition = $condition->getCompiled();

                $this->predicates[] = [
                    'query_part' => trim($condition['query_part'])
                ];
                $this->params = array_merge($this->params, $condition['params']);
            } else {
                $this->predicates[] = $condition;
            }
        }

        $query = ' WHERE';

        $firstFlag = true;

        foreach ($this->predicates as $predicate) {
            $query .= ((!$firstFlag) ? (is_array($predicate)) ? null : sprintf(' %s', $this->getOperator()) : null);

            if ($firstFlag) {
                $firstFlag = false;
            }

            $query .= (is_array($predicate)) ? sprintf(' %s',$predicate['query_part']) : sprintf(' %s',$predicate);
        }

        /** @var RepositoryInterface $repository */
        $repository = DatabaseManager::getConfiguration('repository');
        $aliasCollection = $repository->getTableAliasCollection();

        if (!empty($aliasCollection)) {
            foreach ($aliasCollection as $original => $alias) {
                $query = str_replace(sprintf('%s.', $original), sprintf('%s.', $alias), $query);
            }
        }

        $this->setCompiled($query);
    }

    /**
     * @return array
     */
    public function getCompiled()
    {
        return [
            'query_part' => $this->compiled,
            'params' => $this->params,
        ];
    }

    /**
     * @param mixed $compiled
     */
    public function setCompiled($compiled)
    {
        $this->compiled = $compiled;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }
}
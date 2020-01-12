<?php

namespace Humble\Query;

use Humble\DatabaseManager;
use Humble\Exception\HumbleException;

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
                throw new HumbleException('Invalid condition provided to WHERE');
            } else {
                $this->predicates[] = $condition;
            }
        }

        $this->setCompiled(sprintf('WHERE %s', implode(' AND ', $this->predicates)));
    }

    /**
     * @return array
     */
    public function getCompiled()
    {
        return [
            'query_part' => $this->compiled,
            'params'     => $this->params,
        ];
    }

    /**
     * @param mixed $compiled
     */
    public function setCompiled($compiled)
    {
        $this->compiled = $compiled;
    }

}
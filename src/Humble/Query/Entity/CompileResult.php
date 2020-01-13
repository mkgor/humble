<?php

namespace Humble\Query\Entity;

/**
 * Class CompileResult
 * @package Query\Entity
 */
class CompileResult
{
    /**
     * @var string
     */
    private $queryPart;

    /**
     * @var array
     */
    private $parameters;

    /**
     * CompileResult constructor.
     * @param string $queryPart
     * @param array $parameters
     */
    public function __construct($queryPart, array $parameters = [])
    {
        $this->queryPart = $queryPart;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getQueryPart()
    {
        return $this->queryPart;
    }

    /**
     * @param string $queryPart
     */
    public function setQueryPart($queryPart)
    {
        $this->queryPart = $queryPart;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}
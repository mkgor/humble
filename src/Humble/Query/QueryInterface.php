<?php


namespace Humble\Query;

use Humble\Query\Entity\CompileResult;

/**
 * Interface QueryInterface
 *
 * @package Humble\Query
 */
interface QueryInterface
{
    /**
     * @return CompileResult
     */
    public function getCompiled();
}
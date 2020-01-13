<?php

namespace Humble\Query;

use Humble\Query\Entity\CompileResult;

/**
 * Class OrWhere
 * @package Query
 */
class OrWhere extends Where
{
    public function __construct(...$conditions)
    {
        $this->setOperator(null);

        parent::__construct(...$conditions);
    }

    /**
     * @return CompileResult
     */
    public function getCompiled()
    {
        /** @var CompileResult $compiled */
        $compiled = parent::getCompiled();
        $compiled->setQueryPart(sprintf(' OR (%s)', trim(str_replace('WHERE', '', $compiled->getQueryPart()))));

        return $compiled;
    }
}
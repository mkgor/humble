<?php

namespace Humble\Query;

use Humble\Query\Entity\CompileResult;

/**
 * Class AndWhere
 * @package Query
 */
class AndWhere extends Where
{
    public function __construct(...$conditions)
    {
        $this->setOperator('AND');

        parent::__construct(...$conditions);
    }

    /**
     * @return CompileResult
     */
    public function getCompiled()
    {
        /** @var CompileResult $compiled */
        $compiled = parent::getCompiled();
        $compiled->setQueryPart(sprintf(' AND (%s)', trim(str_replace('WHERE','',$compiled->getQueryPart()))));

        return $compiled;
    }
}
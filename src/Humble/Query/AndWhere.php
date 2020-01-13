<?php

namespace Humble\Query;

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
     * @return array
     */
    public function getCompiled()
    {
        /** @var array $compiled */
        $compiled = parent::getCompiled();
        $compiled['query_part'] = str_replace('WHERE','',$compiled['query_part']);

        return [
            'query_part' => sprintf(' AND (%s)', trim($compiled['query_part'])),
            'params' => $compiled['params']
        ];
    }
}
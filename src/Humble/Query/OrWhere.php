<?php

namespace Humble\Query;

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
     * @return array
     */
    public function getCompiled()
    {
        /** @var array $compiled */
        $compiled = parent::getCompiled();
        $compiled['query_part'] = str_replace('WHERE','',$compiled['query_part']);

        return [
            'query_part' => sprintf(' OR (%s)', trim($compiled['query_part'])),
            'params' => $compiled['params']
        ];
    }
}
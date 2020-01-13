<?php


namespace Humble\Query;

use Humble\Database\RepositoryInterface;
use Humble\DatabaseManager;
use Humble\Exception\HumbleException;
use Humble\Query\Entity\CompileResult;

/**
 * Class Join
 * @package Humble\Query
 */
class Join implements QueryInterface
{
    const HUMBLE_JOIN = 10;
    const HUMBLE_LEFT_JOIN = 20;
    const HUMBLE_RIGHT_JOIN = 30;
    const HUMBLE_CROSS_JOIN = 40;
    const HUMBLE_NATURAL_JOIN = 50;
    const HUMBLE_INNER_JOIN = 60;

    const HUMBLE_OUTER_JOIN_FLAG = 11;

    /**
     * @var string
     */
    private $compiled;

    /**
     * Join constructor.
     *
     * @param string $table
     * @param array $on
     * @param int $type
     * @param array $flags
     *
     * @throws HumbleException
     * @throws \Exception
     */
    public function __construct($table, array $on, $type = self::HUMBLE_JOIN, array $flags = [])
    {
        $query = ' JOIN';

        $tableAlias = sprintf('`%s_%d`', $table, random_int(0, 10000));

        /** @var RepositoryInterface $repository */
        $repository = DatabaseManager::getConfiguration('repository');
        $repository->setTableAlias($table, $tableAlias);

        if (in_array(self::HUMBLE_OUTER_JOIN_FLAG, $flags)) {
            $this->insertBefore(' OUTER', $query);
        }

        switch ($type) {
            case self::HUMBLE_JOIN:
                break;
            case self::HUMBLE_LEFT_JOIN:
                $this->insertBefore(' LEFT', $query);
                break;
            case self::HUMBLE_RIGHT_JOIN:
                $this->insertBefore(' RIGHT', $query);
                break;
            case self::HUMBLE_CROSS_JOIN:
                $this->insertBefore(' CROSS', $query);
                break;
            case self::HUMBLE_NATURAL_JOIN:
                $this->insertBefore(' NATURAL', $query);
                break;
            case self::HUMBLE_INNER_JOIN:
                $this->insertBefore(' INNER', $query);
                break;
            default:
                throw new HumbleException('Unknown join type');
        }

        $onString = '';
        $firstFlag = true;

        foreach ($on as $left => $right) {
            $right = str_replace($table, $tableAlias, $right);

            if (!is_int($left)) {
                $left = str_replace($table, $tableAlias, $left);

                $onString .= ((!$firstFlag) ? ' AND ' : null) . sprintf('%s = %s', $left, $right);
            } else {
                $onString .= ' ' . $right;
            }

            $firstFlag = false;
        }

        $query .= sprintf(' %s %s ON %s', $table, $tableAlias, $onString);

        $this->setCompiled($query);
    }

    /**
     * @param $word
     * @param $haystack
     */
    private function insertBefore($word, &$haystack)
    {
        $haystack = $word . $haystack;
    }

    /**
     * @return mixed
     */
    public function getCompiled()
    {
        return new CompileResult($this->compiled);
    }

    /**
     * @param mixed $compiled
     */
    public function setCompiled($compiled)
    {
        $this->compiled = $compiled;
    }
}
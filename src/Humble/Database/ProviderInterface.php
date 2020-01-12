<?php


namespace Humble\Database;

/**
 * Interface ProviderInterface
 *
 * @package Humble\Database
 */
interface ProviderInterface
{
    /**
     * @return mixed
     */
    public function getDbo();

    /**
     * @param $dbo
     *
     * @return mixed
     */
    public function setDbo($dbo);

    /**
     * @param string $query
     * @param array  $parameters
     *
     * @return mixed
     */
    public function query($query, array $parameters);
}
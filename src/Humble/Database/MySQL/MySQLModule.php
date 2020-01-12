<?php


namespace Humble\Database\MySQL;

use Humble\Database\ModuleInterface;

/**
 * Class MySQLModule
 *
 * @package Humble\Database\MySQL
 */
class MySQLModule implements ModuleInterface
{
    /**
     * @return array
     */
    public function setUp() :array
    {
        return [
            'provider' => new ConnectionProvider(),
            'repository' => MySQLRepository::class
        ];
    }
}
<?php

namespace Humble;

use Humble\Database\ModuleInterface;
use Humble\Database\RepositoryInterface;
use Humble\Exception\HumbleException;

/**
 * Class DatabaseManager
 * @package Humble
 */
class DatabaseManager
{
    /**
     * @var array
     */
    private static $configuration = [];

    /**
     * DatabaseManager constructor.
     *
     * @param array $configuration
     *
     * @throws HumbleException
     */
    public function __construct($configuration = [])
    {
        self::$configuration = $configuration;

        /** @var ModuleInterface $module */
        $module = new $configuration['module'];

        if(!($module instanceof ModuleInterface)) {
            throw new HumbleException('Specified module does not implement ModuleInterface');
        }

        /** Getting all configuration from module and inserts it into global configuration instead of module classname */
        self::$configuration['module'] = $module->setUp();
    }

    /**
     * @param bool $item
     *
     * @return array
     */
    public static function getConfiguration($item = false)
    {
        return !$item ? self::$configuration : (isset(self::$configuration[$item])) ? self::$configuration[$item] : null;
    }

    /**
     * Getting repository of specified entity and setting up table for DatabaseManager
     *
     * @param $name
     * @return mixed|string
     * @throws HumbleException
     */
    public function __get($name)
    {
        /** Setting the repository which is specified in module */
        $repositoryName = self::getConfiguration('module')['repository'];

        /** @var RepositoryInterface $repositoryObject */
        $repositoryObject = new $repositoryName($name);

        if ($repositoryObject instanceof RepositoryInterface) {
            return $repositoryObject;
        } else {
            throw new HumbleException(sprintf('%s exists, but it does not implement RepositoryInterface', $repositoryName));
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function generatePlaceholder()
    {
        return ':param_' . random_int(0,10000);
    }
}
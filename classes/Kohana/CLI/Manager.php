<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class for manage CLI controllers.
 *
 * @package    Kohana/CLI
 * @category   Helper
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Manager {

	// Parent class for CLI controllers
	const PARENT_CLASS = 'Controller_CLI';

	/**
	 * @var string default controller name
	 */
	public static $default = 'list';

	/**
	 * Convert controller class to name.
	 * 
	 *     echo CLI_Manager::class2name('Controller_CLI_DB_Migrate');
	 *     // Result: 'db/migrate'
	 * 
	 * @param  object|string $class class name or controller object
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function class2name($class)
	{
		if (is_object($class))
		{
			$class = get_class($class);
		}

		if ( ! is_subclass_of($class, CLI_Manager::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method :method: class `:class` not extended `:parent`.', 
				array(':method' => __METHOD__, ':class' => $class, ':parent' => CLI_Manager::PARENT_CLASS)
			);
		}

		$class = substr($class, strlen(CLI_Manager::PARENT_CLASS) + 1);
		$class = strtolower($class);
		return str_replace('_', DIRECTORY_SEPARATOR, $class);
	}

	/**
	 * Convert controller class to path.
	 * 
	 *     echo CLI_Manager::class2path('Controller_CLI_DB_Migrate');
	 *     // Result: 'cli/db/migrate'
	 * 
	 * @param  object|string $class  class name or controller object
	 * @return string
	 */
	public static function class2path($class)
	{
		$class = CLI_Manager::class2name($class);
		return 'cli'.DIRECTORY_SEPARATOR.$class;
	}

	/**
	 * Convert controller name to class.
	 * 
	 *     echo CLI_Manager::name2class('db/migrate');
	 *     // Result: 'Controller_CLI_Db_Migrate'
	 * 
	 * @param  string $name controller name
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function name2class($name)
	{
		if (empty($name) OR ! is_string($name))
		{
			throw new CLI_Exception(
				'Method :method: wrong controller name value.', 
				array(':method' => __METHOD__)
			);
		}

		$name = str_replace(array('\\', '/'), ' ', $name);
		$name = ucwords($name);
		return CLI_Manager::PARENT_CLASS.'_'.str_replace(' ', '_', $name);
	}

	/**
	 * Factory for CLI controllers.
	 * 
	 *     CLI_Manager::factory(CLI::option('name'), CLI::option())->execute();
	 * 
	 * @param  string|null $name    controller name
	 * @param  array       $options CLI options values
	 * @return object instance of [Controller_CLI]
	 * @throws CLI_Exception
	 */
	public static function factory($name = NULL, array $options = array())
	{
		if ($name === NULL)
		{
			$name = CLI_Manager::$default;
		}

		$class = CLI_Manager::name2class($name);

		if ( ! class_exists($class))
		{
			throw new CLI_Exception(
				'Method :method(): class `:class` not exists.', 
				array(':method' => __METHOD__, ':class' => $class)
			);
		}
		
		if ( ! is_subclass_of($class, CLI_Manager::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method :method: class `:class` not extended `:parent`.', 
				array(':method' => __METHOD__, ':class' => $class, ':parent' => CLI_Manager::PARENT_CLASS)
			);
		}

		$class = new $class($options);

		return $class;
	}

}

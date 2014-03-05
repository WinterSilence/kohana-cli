<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class, manage CLI tasks.
 *
 * @package    Kohana/CLI
 * @category   Helper
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Tasker {

	// Parent class of CLI tasks
	const PARENT_CLASS = 'CLI_Task';

	// Directory containing CLI tasks
	const DIR_ROOT = 'classes/CLI/Task/';

	/**
	 * @var string name of default task
	 */
	public static $default = 'help/list';

	/**
	 * Convert class to task name.
	 * 
	 *     echo CLI_Tasker::class2name('CLI_Task_DB_Migrate');
	 *     // Result: 'db/migrate'
	 * 
	 * @param  object|string $class class name or [CLI_Task] object
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function class2name($class)
	{
		if (is_object($class))
		{
			$class = get_class($class);
		}

		if ( ! is_subclass_of($class, CLI_Tasker::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method :method: class `:class` not extended `:parent`', 
				array(
					':method' => __METHOD__, 
					':class' => $class, 
					':parent' => CLI_Tasker::PARENT_CLASS
				)
			);
		}

		$class = substr($class, strlen(CLI_Tasker::PARENT_CLASS) + 1);
		$class = strtolower($class);
		return str_replace('_', DIRECTORY_SEPARATOR, $class);
	}

	/**
	 * Convert class to task path.
	 * 
	 *     echo CLI_Tasker::class2path('CLI_Task_DB_Migrate');
	 *     // Result: 'cli/db/migrate'
	 * 
	 * @param  object|string $class class name or or [CLI_Task] object
	 * @return string
	 */
	public static function class2path($class)
	{
		$path = CLI_Tasker::class2name($class);
		return 'cli'.DIRECTORY_SEPARATOR.$path;
	}

	/**
	 * Convert name to task class.
	 * 
	 *     echo CLI_Tasker::name2class('db/migrate');
	 *     // Result: 'CLI_Task_Db_Migrate'
	 * 
	 * @param  string $name task name
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function name2class($name)
	{
		if (empty($name) OR ! is_string($name))
		{
			throw new CLI_Exception(
				'Method :method: wrong task name value', 
				array(':method' => __METHOD__)
			);
		}

		$name = str_replace(array('\\', '/', ' '), ' ', $name);
		$name = ucwords($name);
		return CLI_Tasker::PARENT_CLASS.'_'.str_replace(' ', '_', $name);
	}

	/**
	 * Create CLI task.
	 * 
	 *     CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
	 * 
	 * @param  string $name    task name
	 * @param  array  $options values of options 
	 * @return instance of [CLI_Task]
	 * @throws CLI_Exception
	 */
	public static function factory($name = '', array $options = array())
	{
		if (empty($name))
		{
			// Use default name if task not set
			$name = CLI_Tasker::$default;
		}

		$class = CLI_Tasker::name2class($name);

		if ( ! class_exists($class))
		{
			throw new CLI_Exception(
				'Method :method: class `:class` not exists', 
				array(':method' => __METHOD__, ':class' => $class)
			);
		}
		
		if ( ! is_subclass_of($class, CLI_Tasker::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method :method: class `:class` not extended `:parent`', 
				array(
					':method' => __METHOD__, 
					':class' => $class, 
					':parent' => CLI_Tasker::PARENT_CLASS
				)
			);
		}

		$class = new $class($options);

		return $class;
	}

}

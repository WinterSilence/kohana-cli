<?php
/**
 * Helper class to manage CLI tasks.
 *
 * @package    Kohana/CLI
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) Kohana Team
 * @license    https://koseven.ga/LICENSE
 */
abstract class Kohana_CLI_Tasker {
	// Parent class of tasks
	const PARENT_CLASS = 'CLI_Task';

	// Directory containing tasks
	const DIR_ROOT = 'classes/CLI/Task/';

	/**
	 * @var string Name of default task
	 */
	public static $default = 'help/list';

	/**
	 * Convert class to task name.
	 * 
	 *     echo CLI_Tasker::class2name('CLI_Task_DB_Migrate');
	 *     // result: 'db/migrate'
	 * 
	 * @param  object|string $class Class name or [CLI_Task] object
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function class2name($class)
	{
		if (is_object($class))
		{
			$class = get_class($class);
		}

		if ( ! is_subclass_of($class, static::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method `:method`: class `:class` not extended `:parent`.', 
				[
					':method' => __METHOD__, 
					':class' => $class, 
					':parent' => static::PARENT_CLASS
				]
			);
		}

		$class = substr($class, strlen(static::PARENT_CLASS) + 1);
		$class = strtolower($class);
		return str_replace('_', DIRECTORY_SEPARATOR, $class);
	}

	/**
	 * Convert class to task path.
	 * 
	 *     echo CLI_Tasker::class2path('CLI_Task_DB_Migrate');
	 *     // result: 'cli/db/migrate'
	 * 
	 * @param  object|string $class Сlass name or [CLI_Task] object
	 * @return string
	 */
	public static function class2path($class)
	{
		$path = static::class2name($class);
		return 'cli'.DIRECTORY_SEPARATOR.$path;
	}

	/**
	 * Convert name to task class.
	 * 
	 *     echo CLI_Tasker::name2class('db/migrate');
	 *     // result: 'CLI_Task_Db_Migrate'
	 * 
	 * @param  string $name Task name
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function name2class($name)
	{
		if (empty($name) OR ! is_string($name))
		{
			throw new CLI_Exception(
				'Method `:method`: wrong task name.', 
				[':method' => __METHOD__]
			);
		}

		$name = str_replace(array('\\', '/', ' '), ' ', $name);
		$name = ucwords($name);
		return static::PARENT_CLASS.'_'.str_replace(' ', '_', $name);
	}

	/**
	 * Create CLI task.
	 * 
	 *     CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
	 * 
	 * @param  string $name    Task name
	 * @param  array  $options Task options 
	 * @return object Instance of [CLI_Task]
	 * @throws CLI_Exception
	 */
	public static function factory($name = '', array $options = [])
	{
		if ( ! $name)
		{
			// Use default name if task not set
			$name = static::$default;
		}

		$class = static::name2class($name);

		if ( ! class_exists($class))
		{
			throw new CLI_Exception(
				'Method `:method`: class `:class` not exists.', 
				[':method' => __METHOD__, ':class' => $class]
			);
		}
		elseif ( ! is_subclass_of($class, static::PARENT_CLASS))
		{
			throw new CLI_Exception(
				'Method `:method`: class `:class` not extended `:parent`.', 
				[
					':method' => __METHOD__, 
					':class'  => $class, 
					':parent' => static::PARENT_CLASS
				]
			);
		}
		
		return new $class($options);
	}
}

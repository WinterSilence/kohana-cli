<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class, extracted information about CLI task.
 *
 * @package   Kohana/CLI
 * @category  Helper
 * @author    Kohana Team
 * @copyright (c) 2009-2014 Kohana Team
 * @license   http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Info {

	/**
	 * Gets list of instances of [CLI_Task] class.
	 * 
	 *     $catalog = CLI_Task_Info::get_list();
	 * 
	 * @return array
	 * @uses   Kohana::cache
	 * @uses   Arr::flatten
	 */
	public static function get_list()
	{
		if ($catalog = Kohana::cache(__METHOD__))
		{
			return $catalog;
		}

		$catalog = Kohana::list_files(CLI_Tasker::DIR_ROOT);
		$catalog = Arr::flatten($catalog);
		$catalog = array_keys($catalog);

		if (Kohana::$caching)
		{
			Kohana::cache(__METHOD__, $catalog, 3600);
		}

		return $catalog;
	}

	/**
	 * Gets description for instance of [CLI_Task] class.
	 * 
	 *     $info = CLI_Task_Info::get_info($name);
	 * 
	 * @param  string|object $name task name or instance of [CLI_Task] class
	 * @return array
	 */
	public static function get_info($name)
	{
		if (is_object($name))
		{
			// Convert object to task name
			$name = CLI_Tasker::class2name($name);
		}

		// Create cache key\tag for find task information
		$cache_key = __METHOD__.'('.$name.')';

		// Try load information from cache
		if ($info = Kohana::cache($cache_key))
		{
			return $info;
		}

		// Convert task name to class name
		$class = CLI_Tasker::name2class($name);

		// Create task inspector
		$inspector = new ReflectionClass($class);

		// Get class description and convert to display in CLI
		$description = $inspector->getDocComment();
		// Normalize all new lines to `\n`
		$description = str_replace(array("\r\n", "\n"), "\n", $description);
		// Remove the phpdoc open\close tags and split
		$description = array_slice(explode("\n", $description), 1, -1);
		foreach ($description as $i => $line)
		{
			// Remove all leading whitespace
			$description[$i] = preg_replace('/^\s*\* ?/m', '', $line);
		}
		$description = implode(PHP_EOL, $description);

		// Get default options
		$options = (array) $inspector->getProperty('options')->getValue();

		// Combine information in array
		$info = compact('name', 'class', 'description', 'options');

		if (Kohana::$caching)
		{
			// Cache task information
			Kohana::cache($cache_key, $info, 3600);
		}

		return $info;
	}

}

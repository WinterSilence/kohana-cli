<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class, scaffolding CLI tasks.
 *
 * @package    Kohana/CLI
 * @category   Helper
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Scaffold {

	/**
	 * @var array task templates as array of short name => path to template file
	 */
	public $templates = array(
		'basic'    => 'cli/help/scaffold/basic', 
		'template' => 'cli/help/scaffold/template', 
	);

	/**
	 * Create ClI task class and save in file.
	 * 
	 * @param  string $name     task name
	 * @param  string $template class template, uses [CLI_Task_Scaffold::$templates]
	 * @return void
	 * @throws CLI_Exception
	 * @uses   Text::ucfirst
	 */
	public function create($name, $template)
	{
		// Generate task filename
		$filename = APPPATH.CLI_Tasker::DIR_ROOT.Text::ucfirst($name, '/').EXT;
		$filename = str_replace(array('_', '/'), DIRECTORY_SEPARATOR, $filename);

		// Create task directory if it's not exist
		$dirname = dirname($filename);
		if ( ! is_dir($dirname) AND ! mkdir($dirname, 0755, TRUE))
		{
			throw new CLI_Exception(
				'Method :method: can not create directory `:dirname`', 
				array(':method' => __METHOD__, ':dirname' => $dirname)
			);
		}

		// Create class content
		$content = View::factory(
			CLI_Task_Scaffold::$templates[$template], 
			array('class' => CLI_Tasker::name2class($name))
		);

		// Save task content in file
		if (file_put_contents($filename, $content) === FALSE)
		{
			throw new CLI_Exception(
				'Method :method: can not create file `:filename`', 
				array(':method' => __METHOD__, ':filename' => $filename)
			);
		}
	}

}

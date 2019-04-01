<?php
/**
 * Helper class, scaffolding CLI tasks.
 *
 * @package    Kohana/CLI
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) Kohana Team
 * @license    https://koseven.ga/LICENSE
 */
abstract class Kohana_CLI_Task_Scaffold {
	/**
	 * @var array Task templates as array of short name => path to template file
	 */
	public static $templates = [
		'basic'    => 'cli/help/scaffold/basic', 
		'template' => 'cli/help/scaffold/template', 
	];

	/**
	 * Create ClI task class and save in file.
	 * 
	 *     CLI_Task_Scaffold::create('db/migrate', 'template');
	 * 
	 * @param  string $name     Task name
	 * @param  string $template Class template, uses [CLI_Task_Scaffold::$templates]
	 * @return void
	 * @throws CLI_Exception
	 */
	public static function create($name, $template)
	{
		// Generate task filename
		$file = APPPATH.CLI_Tasker::DIR_ROOT.Text::ucfirst($name, '/').EXT;
		$file = str_replace(['_', '/'], DIRECTORY_SEPARATOR, $file);

		// Create task directory if it's not exist
		$dir = dirname($file);
		if ( ! is_dir($dir) AND ! mkdir($dir, 0755, TRUE))
		{
			throw new CLI_Exception(
				'Method :method: can`t create directory `:dir`.', 
				[':method' => __METHOD__, ':dir' => $dir]
			);
		}

		// Create class content
		$content = new View(
			CLI_Task_Scaffold::$templates[$template], 
			['kohana_cli_class' => CLI_Tasker::name2class($name)]
		);

		// Save task content in file
		if (file_put_contents($file, $content) === FALSE)
		{
			throw new CLI_Exception(
				'Method :method: can not create file `:file`.', 
				[':method' => __METHOD__, ':file' => $file]
			);
		}
	}
}

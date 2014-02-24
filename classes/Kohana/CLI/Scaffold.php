<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Scaffolding helper class.
 *
 * @package    Kohana
 * @category   Helper
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Scaffold {

	/**
	 * @var array controller templates as array of short name => path to template file
	 */
	public $templates = array(
		'basic'    => 'cli/scaffold/basic', 
		'template' => 'cli/scaffold/template', 
	);

	/**
	 * Create ClI controller and save in file.
	 * 
	 * @param  string $name     controller name
	 * @param  string $template class template, set as [CLI_Scaffold::$_templates] keys
	 * @return void
	 * @throws CLI_Exception
	 * @uses   Text::ucfirst
	 */
	public function create($name, $template)
	{
		// Generate controller filename
		$filename = APPPATH.CLI_Manager::DIR_ROOT.Text::ucfirst($name, '/').EXT;
		$filename = str_replace(array('_', '/'), DIRECTORY_SEPARATOR, $filename);

		// Create controller directory if it's not exist
		$dirname = dirname($filename);
		if ( ! is_dir($dirname) AND ! mkdir($dirname, 0755, TRUE))
		{
			throw new CLI_Exception(
				'Method :method: can not create directory `:dirname`', 
				array(':method' => __METHOD__, ':dirname' => $dirname)
			);
		}

		// Create controller content
		$content = View::factory(
			CLI_Scaffold::$templates[$template], 
			array('class' => CLI_Manager::name2class($name))
		);

		// Save controller content in file
		if (file_put_contents($filename, $content) === FALSE)
		{
			throw new CLI_Exception(
				'Method :method: can not create file `:filename`', 
				array(':method' => __METHOD__, ':filename' => $filename)
			);
		}
	}

}

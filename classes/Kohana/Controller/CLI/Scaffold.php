<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI controller class for scaffolding controllers.
 * 
 * @package    Kohana/CLI
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller_CLI_Scaffold extends Controller_CLI {

	/**
	 * @var array Presets for controller options as array of option name => default values
	 */
	public $options = array('class' => '', 'template' => '');

	/**
	 * Sets options if they not exists.
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function before()
	{
		if (empty($this->options['class']))
		{
			$this->options['class'] = CLI::read(__('Controller name'));
		}

		if ( ! in_array($this->options['template'], array_keys(CLI_Scaffold::$templates)))
		{
			$this->options['template'] = CLI::read(__('Class template'), CLI_Scaffold::$templates);
		}
	}

	/**
	 * Create controller content and save in file.
	 *
	 * @return void
	 */
	public function action()
	{
		CLI_Scaffold::create($this->options['class'], $this->options['template']);
		CLI::write(__('Controller `:name` created!', array(':name' => $this->options['class'])));
	}

}

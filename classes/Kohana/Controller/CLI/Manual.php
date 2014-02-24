<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI controller class for displays a description of the selected controller.
 * 
 * @package    Kohana/CLI
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller_CLI_Manual extends Controller_CLI_Template {

	/**
	 * @var array Presets for controller options as array of option name => default values
	 */
	public $options = array('class' => '');

	/**
	 * Sets option 'class' if it's not exist.
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
	}

	/**
	 * Show CLI controller info.
	 *
	 * @return void
	 */
	public function action()
	{
		$info = CLI_Manager::info($this->options['class']);
		$this->template->set($info);
	}

}

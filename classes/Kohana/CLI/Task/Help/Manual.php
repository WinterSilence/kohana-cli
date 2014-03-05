<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI task class, display description of CLI task class.
 * 
 * @package    Kohana/CLI
 * @category   Task
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Help_Manual extends CLI_Task_Template {

	/**
	 * @var array presets for task options as array of option name => default values
	 */
	protected $options = array('name' => '');

	/**
	 * Sets task name if it's not exist.
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function before()
	{
		if (empty($this->options['name']))
		{
			$this->options['name'] = CLI::read(__('Task name'));
		}
	}

	/**
	 * Create and set description of CLI task class.
	 *
	 * @return void
	 */
	protected function action()
	{
		$info = CLI_Task_Info::get_info($this->options['name']);
		$this->template->set($info);
	}

}

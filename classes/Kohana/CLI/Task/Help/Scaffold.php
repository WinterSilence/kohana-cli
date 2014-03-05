<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI task class, scaffolding tasks.
 * 
 * @package    Kohana/CLI
 * @category   Task
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Help_Scaffold extends CLI_Task {

	/**
	 * @var array presets for task options as array of option name => default values
	 */
	protected $options = array('name' => '', 'template' => '');

	/**
	 * Sets options if they not exists.
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

		if ( ! in_array($this->options['template'], array_keys(CLI_Task_Scaffold::$templates)))
		{
			$this->options['template'] = CLI::read(__('Class template'), CLI_Task_Scaffold::$templates);
		}
	}

	/**
	 * Create task content and save in file.
	 *
	 * @return void
	 */
	protected function action()
	{
		CLI_Task_Scaffold::create($this->options['name'], $this->options['template']);
		CLI::write(__('Task `:name` created!', array(':name' => $this->options['name'])));
	}

}

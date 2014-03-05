<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract CLI task class.
 *
 * @package    Kohana/CLI
 * @category   Task
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task {

	/**
	 * @var array presets for task options as array of option name => default values
	 */
	protected $options = array();

	/**
	 * Sets options values of task.
	 * 
	 * @param  array $options options values
	 * @return void
	 */
	public function __construct(array $options = array())
	{
		$this->options = array_merge($this->options, $options);
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function before() {}

	/**
	 * Task action.
	 *
	 * @return void
	 */
	protected function action() {}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function after() {}

	/**
	 * Executes the action and calls the [CLI_Task::before()] and [CLI_Task::after()] methods.
	 *
	 * @return void
	 */
	public function execute()
	{
		// Execute the before action method
		$this->before();
		// Execute the action itself
		$this->action();
		// Execute the after action method
		$this->after();
	}

}

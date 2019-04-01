<?php
/**
 * Basic CLI task.
 *
 * @package    Kohana/CLI
 * @category   Tasks
 * @author     Kohana Team
 * @copyright  (c) Kohana Team
 * @license    https://koseven.ga/LICENSE
 */
abstract class Kohana_CLI_Task {
	/**
	 * @var array Presets for task options as array of option name => default values
	 */
	protected $options = [];

	/**
	 * Sets options values of task.
	 * 
	 * @param  array $options Task options values
	 * @return void
	 */
	public function __construct(array $options = [])
	{
		// Delete task name, it's used only for create task.
		unset($options['task']);
		$this->options = array_merge($this->options, $options);
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	abstract protected function before();

	/**
	 * Task action.
	 *
	 * @return void
	 */
	abstract protected function action();

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	abstract protected function after();

	/**
	 * Executes the action and calls `before` and `after` methods.
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

<?='<?php';?>
/**
 * CLI task.
 *
 * @author    Kohana team
 * @copyright (c) <?=date('Y');?> Kohana team
 * @license   MIT
 */
class <?=$kohana_cli_class;?> extends CLI_Task
{
	/**
	 * @var array Task options as array of option name => default values
	 */
	protected $options = [];

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function before()
	{
	}

	/**
	 * Task action.
	 *
	 * @return void
	 */
	protected function action()
	{	
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function after()
	{
	}
}

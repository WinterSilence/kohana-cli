<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI task class, displays a list of instances of [CLI_Task] class.
 * 
 * @package    Kohana/CLI
 * @category   Task
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Help_List extends CLI_Task_Template {

	/**
	 * Set list of tasks.
	 *
	 * @return void
	 */
	protected function action()
	{
		$this->template->kohana_cli_tasks = CLI_Task_Info::get_list();
	}

}

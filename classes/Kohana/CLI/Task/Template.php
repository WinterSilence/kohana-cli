<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract CLI task class, uses automatic templating [View].
 *
 * @package   Kohana/CLI
 * @category  Task
 * @author    Kohana Team
 * @copyright (c) 2013-2014 Kohana Team
 * @license   http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Task_Template extends CLI_Task {
	/**
	 * @var string|object Path to template or [View] object
	 */
	protected $template;

	/**
	 * @var boolean Auto render template
	 **/
	protected $auto_render = TRUE;

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function before()
	{
		parent::before();

		if ($this->auto_render)
		{
			if (empty($this->template))
			{
				// Generate path to template from class name
				$this->template = CLI_Tasker::class2path($this);
			}
			// Load the template
			$this->template = View::factory($this->template);
		}
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function after()
	{
		if ($this->auto_render == TRUE AND $this->template instanceof View)
		{
			// Render and display template
			CLI::write($this->template->render());
		}

		parent::after();
	}
}

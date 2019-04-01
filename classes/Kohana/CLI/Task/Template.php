<?php
/**
 * Basic CLI task class, uses automatic templating [View].
 *
 * @package   Kohana/CLI
 * @category  Tasks
 * @author    Kohana Team
 * @copyright (c) Kohana Team
 * @license   https://koseven.ga/LICENSE
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
			if ( ! $this->template)
			{
				// Generate path to template from class name
				$this->template = CLI_Tasker::class2path($this);
			}
			// Load the template
			$this->template = new View($this->template);
		}
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function after()
	{
		parent::after();
		
		if ($this->auto_render == TRUE AND $this->template instanceof View)
		{
			// Render and display template
			CLI::write($this->template->render());
		}
	}
}

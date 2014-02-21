<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract CLI controller class, uses automatic templating [View].
 *
 * @package   Kohana/CLI
 * @category  Controller
 * @author    Kohana Team
 * @copyright (c) 2013-2014 Kohana Team
 * @license   http://kohanaframework.org/license
 */
abstract class Kohana_Controller_CLI_Template extends Controller_CLI {

	/**
	 * @var string|object Path to template or [View] object
	 */
	public $template;

	/**
	 * @var  boolean  Auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();

		if ($this->auto_render === TRUE)
		{
			if (empty($this->template))
			{
				// Generate path to template from class name
				$this->template = CLI_Manager::class2path($this);
			}
			// Load the template
			$this->template = View::factory($this->template);
		}
	}

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			CLI::write($this->template->render());
		}

		parent::after();
	}

}

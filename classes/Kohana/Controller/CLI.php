<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract CLI controller class.
 *
 * @package    Kohana/CLI
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller_CLI {

	/**
	 * @var array Presets for controller options as array of option name => default values
	 */
	public $options = array();

	/**
	 * Sets controller options.
	 * 
	 * @param  array $options CLI options
	 * @return void
	 */
	public function __construct(array $options = array())
	{
		$this->options = array_merge($this->options, $options);
	}

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function before() {}

	/**
	 * Controller action.
	 *
	 * @return void
	 */
	public function action() {}

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function after() {}

	/**
	 * Executes the action and calls the [Controller_CLI::before] and [Controller_CLI::after] methods.
	 *
	 * @return void
	 */
	public function execute()
	{
		// Execute the 'before action' method
		$this->before();
		// Execute the action itself
		$this->action();
		// Execute the 'after action' method
		$this->after();
	}

}

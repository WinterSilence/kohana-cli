<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI controller class for displays a list of CLI controllers.
 * 
 * @package    Kohana/CLI
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2013-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller_CLI_Catalog extends Controller_CLI_Template {

	/**
	 * Show list of CLI controllers.
	 *
	 * @return void
	 */
	public function action()
	{
		$this->template->catalog = CLI_Manager::catalog();
	}

}

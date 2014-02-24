<?php defined('SYSPATH') OR die('No direct script access.') ?>
<?php echo Kohana::FILE_SECURITY ?>
/**
 * CLI controller class.
 *
 * @package   Kohana/CLI
 * @category  Controller
 * @author    Kohana Team
 * @copyright (c) <?php echo date('Y') ?> Kohana Team
 * @license   http://kohanaframework.org/license
 */
class <?php echo $class ?> extends Controller_CLI {

	/**
	 * @var array controller options as array of option name => default values
	 */
	public $options = array();

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function before()
	{
		// ...
	}

	/**
	 * Controller action.
	 *
	 * @return void
	 */
	public function action()
	{
		// ...
	}

	/**
	 * Automatically executed after the controller action.
	 *
	 * @return void
	 */
	public function after()
	{
		// ...
	}

}

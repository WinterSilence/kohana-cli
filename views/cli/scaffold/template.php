<?php defined('SYSPATH') OR die('No direct script access.') ?>
<?php echo Kohana::FILE_SECURITY ?>
/**
 * CLI controller class, uses automatic templating [View].
 *
 * @package   Kohana/CLI
 * @category  Controller
 * @author    <?php echo $author ?>
 * @copyright (c) <?php echo date('Y').' '.$author ?>
 * @license   http://kohanaframework.org/license
 */
class <?php echo $class ?> extends Controller_CLI_Template {

	/**
	 * @var array controller options as array of option name => default values
	 */
	public $options = array();

	/**
	 * @var string|object path to template or [View] object
	 */
	public $template = '<?php echo CLI_Manager::class2path($class) ?>';

	/**
	 * @var boolean auto render template
	 **/
	public $auto_render = TRUE;

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

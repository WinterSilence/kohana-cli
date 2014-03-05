<?php defined('SYSPATH') OR die('No direct script access.') ?>
<?php echo Kohana::FILE_SECURITY ?>
/**
 * CLI task class, uses automatic templating [View].
 *
 * @package   Kohana/CLI
 * @category  Task
 * @author    Kohana Team
 * @copyright (c) <?php echo date('Y') ?> Kohana Team
 * @license   http://kohanaframework.org/license
 */
class <?php echo $class ?> extends CLI_Task_Template {

	/**
	 * @var string|object path to template or [View] object
	 */
	protected $template = '<?php echo CLI_Tasker::class2path($class) ?>';

	/**
	 * @var boolean auto render template
	 **/
	protected $auto_render = TRUE;

	/**
	 * @var array task options as array of option name => default values
	 */
	protected $options = array();

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function before()
	{
		// ...
	}

	/**
	 * Task action.
	 *
	 * @return void
	 */
	protected function action()
	{
		// ...
	}

	/**
	 * Automatically executed after the task action.
	 *
	 * @return void
	 */
	protected function after()
	{
		// ...
	}

}

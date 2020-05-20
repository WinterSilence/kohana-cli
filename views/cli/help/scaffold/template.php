<?='<?php';?>
/**
 * CLI task with auto templating.
 *
 * @author    Kohana team
 * @copyright (c) <?=date('Y');?> Kohana team
 * @license   MIT
 */
class <?=$kohana_cli_class;?> extends CLI_Task_Template
{
	/**
	 * @var string|object Path to template or `View` object
	 */
	protected $template = '<?=CLI_Tasker::class2path($kohana_cli_class);?>';

	/**
	 * @var bool Auto render template
	 **/
	protected $auto_render = true;

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

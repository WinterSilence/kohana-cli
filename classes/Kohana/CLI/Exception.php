<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CLI exception class.
 *
 * @package    Kohana/CLI
 * @category   Exception
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Exception extends Kohana_Exception {

	/**
	 * Inline exception handler.
	 * 
	 * - Display the error message, source of the exception
	 * - Stack trace of the error
	 * - Write error in [Log]
	 * 
	 * @param  Exception $e 
	 * @return void
	 */
	public static function handler(Exception $e)
	{
		try
		{
			$error = $e instanceof CLI_Exception ? $e->_cli_text() : parent::text($e);
			CLI::error($error);

			$exit_code = $e->getCode();
			if ($exit_code == 0)
			{
				// Never exit '0' after an exception
				$exit_code = 1;
			}

			exit($exit_code);
		}
		catch (Exception $e)
		{
			// Display the exception text
			CLI::error(parent::text($e));

			// Exit with an error status
			exit(1);
		}
	}

	/**
	 * Formating error message for display in CLI.
	 * 
	 * @return string
	 */
	protected function _cli_text()
	{
		return parent::text($this);
	}

}

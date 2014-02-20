<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Exception class for minion CLI.
 *
 * @package    Kohana/Minion
 * @category   Exception
 * @author     Kohana Team
 * @copyright  (c) 2009-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Exception extends Kohana_Exception {

	/**
	 * Inline exception handler. 
	 * 
	 * - Displays the error message, source of the exception
	 * - Stacks trace of the error
	 * - Writes error in [Log]
	 * 
	 * @param  Exception $e  
	 * @return void
	 */
	public static function handler(Exception $e)
	{
		try
		{
			if ($e instanceof Minion_Exception)
			{
				CLI::error($e->cli_text());
			}
			else
			{
				CLI::error(Kohana_Exception::text($e));
			}

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
			if (ob_get_level() > 0)
			{
				// Clean the output buffer if one exists
				ob_clean();
			}
			
			// Display the exception text
			CLI::error(Kohana_Exception::text($e));

			// Exit with an error status
			exit(1);
		}
	}

	/**
	 * Formating error message for display in CLI.
	 * 
	 * @return string
	 */
	public function cli_text()
	{
		return Kohana_Exception::text($this);
	}

}

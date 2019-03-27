<?php
/**
 * CLI exception class.
 *
 * @package    Kohana/CLI
 * @category   Exception
 * @author     Kohana Team
 * @copyright  (c) 2009-2018 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_CLI_Exception extends Kohana_Exception
{
	/**
	 * Inline exception handler:
	 * 
	 * - Display the error message, source of the exception
	 * - Stack trace of the error
	 * - Write error in [Log]
	 * 
	 * @param  Throwable $e 
	 * @return void
	 */
	public static function handler(Throwable $e)
	{
		try
		{
			$text = $e instanceof CLI_Exception ? $e->_cli_text() : static::text($e);
			CLI::write($text, STDERR);

			$exit_code = $e->getCode();
			if ($exit_code == 0)
			{
				// Never exit '0' after an exception
				$exit_code = 1;
			}
			exit($exit_code);
		}
		catch (Throwable $e)
		{
			if (ob_get_level()) 
			{
				// Clear the output buffer
				ob_clean();
			}
			// Display the exception text
			CLI::write(static::text($e), STDERR);
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
		return self::text($this);
	}
}

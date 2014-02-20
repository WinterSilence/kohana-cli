<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Minion CLI helper class, interact with the command line  
 * by accepting input options, parameters and output text.
 *
 * @package   Kohana/Minion
 * @category  Helper
 * @author    Kohana Team
 * @copyright (c) 2009-2014 Kohana Team
 * @license   http://kohanaframework.org/license
 */
abstract class Kohana_CLI {

	/**
	 * @var array Options passed to script
	 */
	protected static $_options;

	/**
	 * @var boolean Whether to use colored text, uses in [CLI::color()].
	 */
	protected static $_multicolor = FALSE;

	/**
	 * @var array Colour designations of the text
	 */
	protected static $_foreground_colors = array(
		'black'        => '0;30',
		'dark_gray'    => '1;30',
		'blue'         => '0;34',
		'light_blue'   => '1;34',
		'green'        => '0;32',
		'light_green'  => '1;32',
		'cyan'         => '0;36',
		'light_cyan'   => '1;36',
		'red'          => '0;31',
		'light_red'    => '1;31',
		'purple'       => '0;35',
		'light_purple' => '1;35',
		'brown'        => '0;33',
		'yellow'       => '1;33',
		'light_gray'   => '0;37',
		'white'        => '1;37',
	);

	/**
	 * @var array Colour designations of the background
	 */
	protected static $_background_colors = array(
		'black'      => '40',
		'red'        => '41',
		'green'      => '42',
		'yellow'     => '43',
		'blue'       => '44',
		'magenta'    => '45',
		'cyan'       => '46',
		'light_gray' => '47',
	);

	/**
	 * Gets the script name.
	 *
	 *     echo CLI::get_script();
	 * 
	 * @return  string
	 */
	public static function get_script()
	{
		return $_SERVER['argv'][0];
	}

	/**
	 * Sets options, 
	 * uses array of [arguments](http://php.net/manual/reserved.variables.argv.php) passed to script.
	 * 
	 * @return void
	 */
	protected static function _set_options()
	{
		CLI::$_options = array();

		foreach ($_SERVER['argv'] as $i => $option)
		{
			if ($i === 0 OR strpos($option, '--') !== 0)
			{
				// Skip the first argument (it's always the name that was used to run the script)
				// and arguments without list separator '--'.
				continue;
			}

			// Remove the list separator '--'
			$option = substr($option, 2);

			if (strpos($option, '=') !== FALSE)
			{
				list ($option, $value) = explode('=', $option, 2);
				CLI::$_options[$option] = trim($value, '\'"');
			}
			else
			{
				CLI::$_options[$option] = NULL;
			}
		}
	}

	/**
	 * Gets options.
	 * If the option does not exist, the default value will be returned instead.
	 * 
	 * @param  string|array $name    Option name or array of options
	 * @param  mixed        $default Default value
	 * @return mixed
	 * @uses   Arr::is_array
	 * @uses   Arr::extract
	 * @uses   Arr::get
	 */
	public static function get_options($name, $default = NULL)
	{
		if ( ! is_array(CLI::$_options))
		{
			// Define options
			CLI::_set_options();
		}

		if (Arr::is_array($name))
		{
			return Arr::extract(CLI::$_options, $name, $default);
		}

		return Arr::get(CLI::$_options, $name, $default);
	}

	/**
	 * Reads input from the user. This can have either 1 or 2 arguments.
	 * 
	 *     // Waits for any key press:
	 *     CLI::read();
	 *     // Takes any input:
	 *     $color = CLI::read('What is your favorite color?');
	 *     // Will only accept the options in the array:
	 *     $ready = CLI::read('Are you ready?', array('y','n'));
	 *
	 * @param  string $text    Text to show user before waiting for input
	 * @param  array  $options Array of options the user is shown
	 * @return string
	 */
	public static function read($text = '', array $options = array())
	{
		// If a question has been asked with the read
		$options_output = empty($options) ? : '' : ' [ '.implode(', ', $options).' ]';

		fwrite(STDOUT, $text.$options_output.': ');
		
		// Read the input from keyboard.
		$input = trim(fgets(STDIN));

		// If options are provided and the choice is not in the array, tell them to try again.
		if ( ! empty($options) AND ! in_array($input, $options))
		{
			CLI::write('Invalid option value. Please try again.');
			// Read option value again
			$input = CLI::read($text, $options);
		}
	
		// Read the input
		return $input;
	}

	/**
	 * Outputs a string to the CLI.
	 * If you send an array it will implode them with a line break.
	 * 
	 *     CLI::write($text);
	 * 
	 * @param  string|array $text Text to output, or array of strings
	 * @return void
	 */
	public static function write($text = '')
	{
		if (is_array($text))
		{
			$text = implode(PHP_EOL, $text);
		}

		fwrite(STDOUT, $text.PHP_EOL);
	}

	/**
	 * Outputs a error string to the CLI.
	 * If you send an array it will implode them with a line break.
	 * 
	 *     CLI::error($text);
	 * 
	 * @param  string|array $text Error to output or array of error strings
	 * @return void
	 */
	public static function error($text = '')
	{
		if (is_array($text))
		{
			$text = implode(PHP_EOL, $text);
		}

		fwrite(STDERR, $text.PHP_EOL);
	}

	/**
	 * Returns the given text with the correct color codes for foreground and (optional) background color.
	 * 
	 *     // Print light gray text:
	 *     CLI::write(CLI::color($text, 'light_gray'));
	 * 
	 * @param  string      $text       Text highlighted in color
	 * @param  string      $foreground Foreground color of the text
	 * @param  string|null $background Background color of the text
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function color($text, $foreground, $background = NULL)
	{
		if (Kohana::$is_windows AND CLI::$_multicolor === FALSE)
		{
			return $text;
		}

		if ( ! isset(CLI::$_foreground_colors[$foreground]))
		{
			throw new CLI_Exception(
				'Method :method: invalid foreground color: :color', 
				array(':method' => __METHOD__, ':color' => $foreground)
			);
		}
		$colored_text = "\033[".CLI::$_foreground_colors[$foreground]."m";

		if ($background !== NULL)
		{
			if ( ! isset(CLI::$_background_colors[$background]))
			{
				throw new CLI_Exception(
					'Method :method: invalid background color: :color',
					array(':method' => __METHOD__, ':color' => $background)
				);
			}
			$colored_text .= "\033[".CLI::$_background_colors[$background]."m";
		}

		$colored_text .= $text."\033[0m";

		return $colored_text;
	}

}

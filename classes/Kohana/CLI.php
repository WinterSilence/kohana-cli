<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class, interact with the command line by accepting input options:
 * 
 * - Gets command line arguments
 * - Input values ​​of variables
 * - Output text and errors
 *
 * @package   Kohana/CLI
 * @category  Helper
 * @author    Kohana Team
 * @copyright (c) 2009-2014 Kohana Team
 * @license   http://kohanaframework.org/license
 * @link      http://php.net/commandline
 */
abstract class Kohana_CLI {
	/**
	 * @var boolean Whether to use colored text
	 */
	public static $multicolor = FALSE;

	/**
	 * @var array Options passed to script
	 */
	protected static $_options;

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
	 *     echo CLI::script();
	 * 
	 * @return string
	 */
	public static function script()
	{
		return $_SERVER['argv'][0];
	}

	/**
	 * Sets options as [CLI arguments](http://php.net/argv) and gets value
	 * or array values of options. If getting option does not exist,
	 * the default value will be returned instead.
	 *
	 *     echo CLI::option('type', 'basic');
	 * 
	 * @param  string|array $name    Option name or array of options
	 * @param  mixed        $default Default value
	 * @return mixed
	 */
	public static function option($name, $default = NULL)
	{
		// Sets options
		if ( ! isset(static::$_options))
		{
			static::$_options = array();

			foreach ($_SERVER['argv'] as $i => $option)
			{
				if ($i == 0 OR strpos($option, '--') !== 0)
				{
					// Skip the first argument - it's always the script name
					// and arguments without list separator '--'.
					continue;
				}
				// Remove the list separator '--'
				$option = substr($option, 2);

				if (strpos($option, '=') !== FALSE)
				{
					list ($option, $value) = explode('=', $option, 2);
					static::$_options[$option] = trim($value, '\'"');
				}
				else
				{
					static::$_options[$option] = NULL;
				}
			}
		}

		if (is_array($name))
		{
			// Create array containing the default values
			$defaults = array_fill_keys($name, $default);
			// Create array containing the intersection of arrays options and defaults
			$options = array_intersect_key(static::$_options, $defaults);
			// Get options as merged array of selected options and defaults
			return array_merge($defaults, $options);
		}
		// Get option
		return isset(static::$_options[$name]) ? static::$_options[$name] : $default;
	}

	/**
	 * Outputs a string to the CLI.
	 * If you send an array it will implode them with a line break.
	 * 
	 *     // Display text
	 *     CLI::write($text);
	 *     // Display error
	 *     CLI::write($error, STDERR);
	 * 
	 * @param  string|array $text   String to output, or array of strings
	 * @param  resource     $handle Pointer of output stream (STDOUT, STDERR)
	 * @return void
	 */
	public static function write($text = '', $handle = STDOUT)
	{
		if (is_array($text))
		{
			$text = implode(PHP_EOL, $text);
		}
		if ($handle != STDOUT)
		{
			$handle = STDERR;
		}
		fwrite($handle, $text);
	}

	/**
	 * Reads input from the user. This can have either 1 or 2 arguments.
	 * 
	 *     // Waits for any key press:
	 *     CLI::read();
	 *     // Takes any input:
	 *     $color = CLI::read('What is your favorite color?');
	 *     // Will only accept the options in the array:
	 *     $ready = CLI::read('Are you ready?', array('y', 'n'));
	 *     // Will only accept the options in the assoc array of value => label:
	 *     $ready = CLI::read('Are you ready?', array('y' => 'yes','n' => 'no'));
	 *
	 * @param  string $text    Text to show user before waiting for input
	 * @param  array  $options Array of options the user is shown
	 * @return string
	 */
	public static function read($text = '', array $options = array())
	{
		if (empty($options))
		{
			$options_output = '';
		}
		else
		{
			// If a question has been asked with the read
			$is_assoc = ( ! isset($options[0]));

			if ($is_assoc)
			{
				$options_output = array();
				foreach ($options as $name => $value)
				{
					$options_output[$name] = $name.'('.$value.')';
				}
				$options_output = ' [ '.implode(', ', $options_output).' ]';
			}
			else
			{
				$options_output = ' [ '.implode(', ', $options.' ]';
			}
		}

		static::write($text.$options_output.': ');
		
		// Read the input from keyboard
		$input = trim(fgets(STDIN));

		// If options are provided and the choice is not exist, tell them to try again
		if ( ! empty($options) AND ! ($is_assoc ? isset($options[$input]) : in_array($input, $options)))
		{
			static::write(__('Invalid option value, try again'));
			// Read option value again
			$input = static::read($text, $options);
		}

		// Read the input
		return $input;
	}

	/**
	 * Returns the given text with the correct color codes for foreground and (OPTIONAL) background color.
	 * 
	 *     // Print light gray text:
	 *     CLI::write(CLI::color($text, 'light_gray'));
	 * 
	 * @param  string $text       Highlight text
	 * @param  string $foreground Foreground color of text, use key of [CLI::$_foreground_colors]
	 * @param  string $background Background color of text, use key of [CLI::$_background_colors]
	 * @return string
	 * @throws CLI_Exception
	 * @uses   Kohana::$is_windows
	 */
	public static function color($text, $foreground, $background = '')
	{
		if (Kohana::$is_windows AND static::$multicolor)
		{
			// If color text not support return text "as is"
			return $text;
		}

		if ( ! isset(static::$_foreground_colors[$foreground]))
		{
			throw new CLI_Exception(
				':method: invalid foreground color `:color`', 
				array(':method' => __METHOD__, ':color' => $foreground)
			);
		}
		$colored_text = "\033[".static::$_foreground_colors[$foreground]."m";

		if ($background)
		{
			if ( ! isset(static::$_background_colors[$background]))
			{
				throw new CLI_Exception(
					':method: invalid background color `:color`',
					array(':method' => __METHOD__, ':color' => $background)
				);
			}
			$colored_text .= "\033[".static::$_background_colors[$background]."m";
		}

		$colored_text .= $text."\033[0m";

		return $colored_text;
	}
}

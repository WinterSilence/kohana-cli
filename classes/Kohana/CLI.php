<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Helper class, interact with the command line by accepting input options.
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
 */
abstract class Kohana_CLI {

	/**
	 * @var array options passed to script
	 */
	protected static $_options;

	/**
	 * @var boolean Whether to use colored text
	 */
	public static $multicolor = FALSE;

	/**
	 * @var array colour designations of the text
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
	 * @var array colour designations of the background
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
	 * Sets options as [CLI arguments](http://php.net/argv) 
	 * and gets value or array values of options.
	 * If getting option does not exist, the default value will be returned instead.
	 *
	 *     echo CLI::option('type', 'basic');
	 * 
	 * @param  string|array $name    option name or array of options
	 * @param  mixed        $default default value
	 * @return mixed
	 * @uses   Arr::is_array
	 * @uses   Arr::extract
	 * @uses   Arr::get
	 */
	public static function option($name, $default = NULL)
	{
		// Sets options
		if ( ! isset(CLI::$_options))
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

		// Get options
		if (Arr::is_array($name))
		{
			return Arr::extract(CLI::$_options, $name, $default);
		}

		// Get option
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
	 *     $ready = CLI::read('Are you ready?', array('y', 'n'));
	 *     // Will only accept the options in the assoc array of value => label:
	 *     $ready = CLI::read('Are you ready?', array('y' => 'yes','n' => 'no'));
	 *
	 * @param  string $text    text to show user before waiting for input
	 * @param  array  $options array of options the user is shown
	 * @return string
	 * @uses   Arr::is_assoc
	 */
	public static function read($text = '', array $options = array())
	{
		if ( ! empty($options))
		{
			$options_output = '';
		}
		else
		{
			// If a question has been asked with the read
			$is_assoc = Arr::is_assoc($options);

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

		fwrite(STDOUT, $text.$options_output.': ');
		
		// Read the input from keyboard.
		$input = trim(fgets(STDIN));

		// If options are provided and the choice is not in the array, tell them to try again.
		if ( ! empty($options) AND ! ($is_assoc ? isset($options[$input]) : in_array($input, $options)))
		{
			CLI::write(__('Invalid option value. Please try again.'));
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
	 * @param  string|array $text    string to output, or array of strings
	 * @param  string       $handler stream handler, use [CLI constants for I/O streams](http://php.net/commandline.io-streams)
	 * @return void
	 */
	public static function write($text = '', $handler = STDOUT)
	{
		if (is_array($text))
		{
			$text = implode(PHP_EOL, $text);
		}

		fwrite($handler, $text);
	}

	/**
	 * Outputs a error to the CLI.
	 * 
	 *     CLI::error($text);
	 * 
	 * @param  string|array $text error string or array of errors
	 * @return void
	 */
	public static function error($text = '')
	{
		CLI::write($text, STDERR);
	}

	/**
	 * Returns the given text with the correct color codes for foreground and (optional) background color.
	 * 
	 * 
	 *     // Print light gray text:
	 *     CLI::write(CLI::color($text, 'light_gray'));
	 * 
	 * @param  string      $text       highlight text
	 * @param  string      $foreground foreground color of text, uses [CLI::$_foreground_colors]
	 * @param  string|null $background background color of text, uses [CLI::$_background_colors]
	 * @return string
	 * @throws CLI_Exception
	 * @uses   Kohana::$is_windows
	 */
	public static function color($text, $foreground, $background = NULL)
	{
		if (Kohana::$is_windows AND CLI::$multicolor === FALSE)
		{
			// If color text not support return text `as is`
			return $text;
		}

		if ( ! isset(CLI::$_foreground_colors[$foreground]))
		{
			throw new CLI_Exception(
				'Method :method: invalid foreground color `:color`.', 
				array(':method' => __METHOD__, ':color' => $foreground)
			);
		}
		$colored_text = "\033[".CLI::$_foreground_colors[$foreground]."m";

		if ($background !== NULL)
		{
			if ( ! isset(CLI::$_background_colors[$background]))
			{
				throw new CLI_Exception(
					'Method :method: invalid background color `:color`.',
					array(':method' => __METHOD__, ':color' => $background)
				);
			}
			$colored_text .= "\033[".CLI::$_background_colors[$background]."m";
		}

		$colored_text .= $text."\033[0m";

		return $colored_text;
	}
}

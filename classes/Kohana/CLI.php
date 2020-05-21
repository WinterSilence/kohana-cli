<?php
/**
 * Interact with the command line by accepting input options.
 *
 * @package   Kohana\CLI
 * 
 * @category  Helper
 * @author    WinterSilence
 * @copyright (c) 2016-2020 WinterSilence
 * @license   BSD-3-Clause
 */
abstract class Kohana_CLI
{
	/**
	 * @var string Path to executed script
	 */
	protected static $script;
	
	/**
	 * @var array Options passed to script
	 */
	protected static $options;

	/**
	 * @var array Colour designations of the text
	 */
	public static $foreground_colors = [
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
	];

	/**
	 * @var array Colour designations of the background
	 */
	public static $background_colors = [
		'black'      => 40,
		'red'        => 41,
		'green'      => 42,
		'yellow'     => 43,
		'blue'       => 44,
		'magenta'    => 45,
		'cyan'       => 46,
		'light_gray' => 47,
	];

	/**
	 * Returns the path to script.
	 * 
	 * @return string
	 */
	public static function script()
	{
		if (static::$script === null) {
			static::$script = filter_input(INPUT_SERVER, 'argv', FILTER_DEFAULT, FILTER_FORCE_ARRAY)[0];
		}
		return static::$script;
	}

	/**
	 * Sets options by CLI arguments.
	 * 
	 * @return void
	 */
	protected static function setOptions()
	{
		static::$options = [];
		$rgv = filter_input(INPUT_SERVER, 'argv', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
		foreach ($rgv as $i => $option) {
			// Skip the script name and arguments without list separator(`--`).
			if (! $i || strpos($option, '-') !== 0) {
				continue;
			}
			// Remove the list separator
			$option = substr($option, 2);
			if (strpos($option, '=') !== false) {
				[$option, $value] = explode('=', $option, 2);
				static::$options[$option] = trim($value, '\'"');
			} else {
				static::$options[$option] = true;
			}
		}
	}
	
	/**
	 * Returns option value(s).
	 *
	 * @param string|array $name Option name(s)
	 * @param mixed $default Default value
	 * @return mixed
	 */
	public static function option($name, $default = null)
	{
		if (static::$options === null) {
			static::setOptions();
		}
		if (is_array($name)) {
			// Set options as merged array of selected options and default values
			$defaults = array_fill_keys($name, $default);
			$options = array_intersect_key(static::$options, $defaults);
			return array_merge($defaults, $options);
		}
		return static::$options[$name] ?? $default;
	}

	/**
	 * Outputs a string to the CLI. If you send an array it will implode them with a line break.
	 * 
	 * @param string|array $text String to output, or array of strings
	 * @param string $handle Output stream: `STDOUT` or `STDERR`
	 * @return void
	 */
	public static function write($text, $handle = STDOUT): void
	{
		if (! in_array($handle, [STDOUT, STDERR], true)) {
			throw new CLI_Exception(
				':method: invalid handle, use `STDOUT` or `STDERR`',
				[':method' => __METHOD__]
			);
		}
		if (is_array($text)) {
			$text = implode(PHP_EOL, $text);
		}
		fwrite($handle, $text . PHP_EOL);
	}

	/**
	 * Reads input by the user.
	 * 
	 *     // Takes any input:
	 *     $color = CLI::read('What is your favorite color?');
	 *     // Will only accept the options in the array of value => label
	 *     $ready = CLI::read('Are you ready?', ['y' => 'yes','n' => 'no']);
	 *
	 * @param string $text Text to show user before waiting for input
	 * @param array $options An array of options the user is shown
	 * @return string
	 */
	public static function read(string $text, array $options = []): string
	{
		$options_output = '';
		if ($options) {
			// If a question has been asked with the read
			$is_assoc = empty($options[0]);
			if ($is_assoc) {
				$options_output = [];
				foreach ($options as $name => $value) {
					$options_output[$name] = $name . '(' . $value . ')';
				}
				$options_output = ' [ ' . implode(', ', $options_output) . ' ]';
			} else {
				$options_output = ' [ ' . implode(', ', $options) . ' ]';
			}
		}
		static::write($text . $options_output . ': ');
		// Read the input from keyboard
		$input = fgets(STDIN);
		// If options are provided and the choice is not exist, tell them to try again
		if ($options && ! ($is_assoc ? isset($options[$input]) : in_array($input, $options))) {
			static::write(__('Invalid option value, try again'));
			$input = static::read($text, $options);
		}
		return $input;
	}

	/**
	 * Returns the given text with the correct color codes for foreground and background color (optional).
	 * 
	 * @param string $text Text to highlight
	 * @param string $foreground Foreground color of text, use `self::$foreground_colors`
	 * @param string $background Background color of text, use `self::$background_colors`
	 * @return string
	 * @throws CLI_Exception
	 */
	public static function color(string $text, string $foreground, string $background = null)
	{
		if (! ini_get('cli_server.color')) {
			// If color text not supported, return text "as is"
			return $text;
		}
		if (! isset(static::$foreground_colors[$foreground])) {
			throw new CLI_Exception(
				':method: invalid foreground color `:color`', 
				[':method' => __METHOD__, ':color' => $foreground]
			);
		}
		if ($background) {
			if (! isset(static::$background_colors[$background])) {
				throw new CLI_Exception(
					':method: invalid background color `:color`',
					[':method' => __METHOD__, ':color' => $background]
				);
			}
			$text = "\033[" . static::$background_colors[$background] . 'm' . $text;
		}
		return "\033[" . static::$foreground_colors[$foreground] . 'm' . $text . "\033[0m";
	}
}

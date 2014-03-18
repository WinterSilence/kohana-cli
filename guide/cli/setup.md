# Setup

Replace code of "minion" module in `DOCROOT/index.php`:

~~~
if (PHP_SAPI == 'cli') 
{
	// Try and load minion
	class_exists('Minion_Task') OR die('Please enable the Minion module for CLI support.');
	set_exception_handler(array('Minion_Exception', 'handler'));

	Minion_Task::factory(Minion_CLI::options())->execute();
}
~~~

to code of "CLI" module:

~~~
if (PHP_SAPI == 'cli') 
{
	// Check whether the module is connected
	class_exists('CLI') OR die('Please enable the CLI module.');

	// Change exception handler
	set_exception_handler(array('CLI_Exception', 'handler'));

	// Ignore user aborts
	ignore_user_abort(TRUE);
	// Allow the script to run forever
	set_time_limit(0);
	// Enable to use ANSI color coding
	ini_set('cli_server.color', 'On');

	// Create and execute the initial task
	CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
}
~~~

To enable, open your `APPPATH/bootstrap.php` and modify the call to [Kohana::modules()] by including the 'cli' module like so:

~~~
Kohana::modules(
	array(
		...
		'cli' => MODPATH.'cli', // Command line task runner
		...
	)
);
~~~

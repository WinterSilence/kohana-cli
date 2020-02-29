Kohana CLI module
==========

CLI module for Kohana framework 3.3 or high.

Replaced basic `minion` module, for this change part of code in `DOCROOT/index.php`:
~~~
if (PHP_SAPI == 'cli')  {
	// Try and load minion
	class_exists('Minion_Task') || die('Please enable the Minion module for CLI support.');
	set_exception_handler(['Minion_Exception', 'handler']);

	Minion_Task::factory(Minion_CLI::options())->execute();
}
~~~
to
~~~
if (PHP_SAPI == 'cli') {
	// Check whether the module is connected
	class_exists('CLI') || die('Please enable the `CLI` module.');
	// Change exception handler
	set_exception_handler(['CLI_Exception', 'handler']);
	// Ignore user aborts
	ignore_user_abort(TRUE);
	// Enable to use ANSI color coding
	ini_set('cli_server.color', 'on');
	// Create and execute the main\initial task
	CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
}
~~~

For short call CLI tasks in Linux OS use `./cli` and `./cli_daemon`.

For more information about usage, see module's user guide.

### Distinctive features:

- Clean and documented code
- Fixed memory leaks and incorrect output
- Easy task for scaffolding

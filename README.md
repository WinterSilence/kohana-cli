Kohana/Koseven CLI module
==========

CLI module for Kohana framework 3.3 or high.

Replaced basic `minion` module, for this change part of code in `index.php`:

~~~
if (PHP_SAPI == 'cli') {
	...
}
~~~

to

~~~
if (PHP_SAPI == 'cli') {
	// Change exception handler
	set_exception_handler(['CLI_Exception', 'handler']);
	// Enable to use ANSI color coding
	ini_set('cli_server.color', 'On');
	// Create and execute the main\initial task
	CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
}
~~~

For short call CLI tasks in Linix OS use files `cli` and `cli_daemon`.

For more information about usage, see user guide.

### Distinctive features:

- Clean and documented code
- Fixed memory leaks and incorrect output text and the error
- Easy task scaffolding

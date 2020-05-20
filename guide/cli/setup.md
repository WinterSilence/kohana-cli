# Setup

Replace `minion` module in `index.php`:

~~~
if (PHP_SAPI == 'cli') {
	...
}
~~~

to `cli` module:

~~~
if (PHP_SAPI == 'cli') {
	// Change exception handler
	set_exception_handler(['CLI_Exception', 'handler']);
	// Enable to use ANSI color coding
	ini_set('cli_server.color', 'On');
	// Create and execute the initial task
	CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
}
~~~

To enable module, open your `bootstrap.php` and modify the call to `Kohana::modules()` by including the `cli` module like so:

~~~
Kohana::modules(
	[
		...
		'cli' => MODPATH . 'cli', // CLI task runner
	]
);
~~~

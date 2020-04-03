# Kohana CLI module

CLI module for Kohana framework 3.x.

## Install

Replace `minion` module in `DOCROOT/index.php`
~~~php
if (PHP_SAPI == 'cli')  {
  // replace this
}
~~~
to
~~~php
// Check whether the module is connected
class_exists('CLI') || die('Please enable the `CLI` module.');
// Change exception handler
set_exception_handler(['CLI_Exception', 'handler']);

// Set CLI options
ignore_user_abort(TRUE);
ini_set('cli_server.color', 'on');

// Create and execute the main/initial task
CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
~~~

Use `./cli` and `./cli_daemon` to call CLI tasks in Linux.

For more information about usage, see `guide`.

## Features

- Clean and documented code
- Fix memory leaks and incorrect output
- Scaffold task

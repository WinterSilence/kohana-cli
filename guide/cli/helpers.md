# Helpers

## Command line

[CLI] used to work with command line.

Show text
~~~
CLI::write($text);
~~~
Colored text
~~~
// Print light gray text:
CLI::write(CLI::color($text, 'light_gray'));
~~~
Reading variables
~~~
// Waits for any key press:
CLI::read();
// Takes any input:
$color = CLI::read('What is your favorite color?');
// Will only accept the options in the array:
$ready = CLI::read('Are you ready?', array('y', 'n'));
// Will only accept the options in the assoc array of value => label:
$ready = CLI::read('Are you ready?', array('y' => 'yes','n' => 'no'));
~~~
Getting options
~~~
// Get option 'type'
echo CLI::option('type', 'basic');
// Get options 'type', 'color', 'name'
$options = CLI::option(array('type', 'color', 'name'));
~~~

## Tasks

[CLI_Tasker] used to work with tasks.

Creating tasks
~~~
CLI_Tasker::factory(CLI::option('task'), CLI::option())->execute();
CLI_Tasker::factory('task/two', array('opt1' => 'val1'))->execute();
~~~
Converting name
~~~
echo CLI_Tasker::class2name('CLI_Task_DB_Migrate');
// Result: 'db/migrate'
echo CLI_Tasker::class2path('CLI_Task_DB_Migrate');
// Result: 'cli/db/migrate'
echo CLI_Tasker::name2class('db/migrate');
// Result: 'CLI_Task_Db_Migrate'
~~~
 
[CLI_Task_Info] used to generate help info: list of all tasks, tasks description.

[CLI_Task_Scaffold] used to create new tasks.

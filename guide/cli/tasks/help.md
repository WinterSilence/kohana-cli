# Help tasks

The module contains several auxiliary tasks.

## CLI_Task_Help_List

Displays a list of all tasks. 

For running task, enter in console:
<samp>
	php index.php --task=help/list
</samp>
or:
<samp>
	php index.php
</samp>
It's works because `help/list` used as default task in [CLI_Tasker::$default].

## CLI_Task_Help_Manual

Displays the description of the task class and used options.

For running task, enter in console:
<samp>
	php index.php --task=help/manual --name={name}
</samp>
Replace the `{name}` to current task name. 

## CLI_Task_Help_Scaffold

Used to quickly create "dummy" tasks.

For running task, enter in console:
<samp>
	php index.php --task=help/scaffold --name={name} --template={template}
</samp>
Replace the `{name}` to name of new task, `{template}` to current template of class.

[CLI_Task_Scaffold::$templates] - the list of available [templates](../kohana/mvc/views). 
By default, contains `basic` ([CLI_Task]) and `template` ([CLI_Task_Template]) templates.

[!!] You can use your own templates: create new views by analogy with the existing and add them to [CLI_Task_Scaffold::$templates].

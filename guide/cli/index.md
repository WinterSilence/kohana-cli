# CLI

Module "CLI" is a simple command line task runner. 
It replaces the basic CLI module [minion](http://kohanaframework.org/guide/minion/).

## Features

 - Clean and documented code: contains only the necessary methods.
 - Fixed memory leaks: helpers (`_help` and `task_list`) moved out of task class
 - Fixed incorrect text output: uses CLI SAPI constants for streams of input/output
 - Easy task scaffolding: quickly create `dummy` tasks

## Info

 - [Command-line interface](http://wikipedia.org/wiki/Command-line_interface)
 - [Using PHP from the command line](http://php.net/commandline)

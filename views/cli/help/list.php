<?php defined('SYSPATH') OR die('No direct script access.') ?>

<?php if ( ! Fragment::load('cli_list', 3600, TRUE)): ?>

<?php echo CLI::color(__('List of CLI tasks'), 'black', 'light_gray') ?>
-------------------------------------------------
<?php 
foreach ($kohana_cli_tasks as $i => $name):
{
    echo CLI::color($name, 'light_gray');
    
    $description = __($name);
    echo ($name == $description ? '' : ': '.$description).PHP_EOL;
}
?>

<?php echo CLI::color(__('Default task'), 'light_gray') ?>
-------------------------------------------------
    <?php echo CLI_Tasker::name2class(CLI_Tasker::$default) ?>

<?php echo CLI::color(__('Execute task'), 'light_gray') ?>
-------------------------------------------------
    php <?php echo CLI::script() ?> --task=<name> [--option1=<value1>] [--option2=<value2>]

<?php echo CLI::color(__('Show task manual'), 'light_gray') ?>
-------------------------------------------------
    php <?php echo CLI::script() ?> --task=manual --name=<task>

<?php if (Kohana::$caching) Fragment::save() ?>
<?php endif ?>

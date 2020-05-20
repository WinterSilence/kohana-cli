<?php if (! Fragment::load(__FILE__, Kohana::$caching ? 3600 : 60, TRUE)): ?>
<?php echo CLI::color(__('List of CLI tasks'), 'black', 'light_gray');?>
-------------------------------------------------
<?php
foreach ($kohana_cli_tasks as $i => $name):
{
    echo CLI::color($name, 'light_gray');
    $description = __($name);
    echo ($name == $description ? '' : ': '.$description).PHP_EOL;
}
?>

<?=CLI::color(__('Default task'), 'light_gray');?>
-------------------------------------------------
    <?=CLI_Tasker::name2class(CLI_Tasker::$default);?>

<?=CLI::color(__('Execute task'), 'light_gray');?>
-------------------------------------------------
    php <?=CLI::script();?> --task=<name> [--option1=<value1>] [--option2=<value2>]

<?=CLI::color(__('Show task manual'), 'light_gray');?>
-------------------------------------------------
    php <?=CLI::script();?> --task=manual --name=<task>

<?php Fragment::save(); ?>
<?php endif; ?>

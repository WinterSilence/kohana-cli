<?php defined('SYSPATH') OR die('No direct script access.') ?>

<?php if ( ! Fragment::load('cli_manual'.$kohana_cli_task['name'], 3600, TRUE)): ?>

<?php echo CLI::color($kohana_cli_task['name'].' ('.$kohana_cli_task['class'].')', 'black', 'light_gray') ?>
-------------------------------------------------

<?php echo CLI::color(__('Description'), 'light_gray') ?>
-------------------------------------------------
    <?php echo $kohana_cli_task['description'] ?>

<?php echo CLI::color(__('Options'), 'light_gray') ?>
-------------------------------------------------
<?php 
foreach ($kohana_cli_task['options'] as $option => $default)
{
    echo CLI::color($option, 'light_gray');

    $key = $name.' '.$option;
    $info = __($key);
    echo $key == $info ? '' : ' - '.$info;

    echo ': '.var_export($default, TRUE).PHP_EOL;
}
?>

<?php echo CLI::color(__('Show task manual'), 'light_gray') ?>
-------------------------------------------------
    php <?php echo CLI::script() ?> --task=manual --name=<?php echo $kohana_cli_task['name'] ?>

<?php if (Kohana::$caching) Fragment::save() ?>
<?php endif ?>

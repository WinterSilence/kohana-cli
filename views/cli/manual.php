<?php defined('SYSPATH') OR die('No direct script access.') ?>

<?php if ( ! Fragment::load('cli_manual'.$name, 3600, TRUE)): ?>

<?php echo CLI::color($name.' ('.$class.')', 'black', 'light_gray') ?>
-------------------------------------------------

<?php echo CLI::color(__('Description'), 'light_gray') ?>
-------------------------------------------------
<?php echo $description ?>

<?php echo CLI::color(__('Options'), 'light_gray') ?>
-------------------------------------------------
<?php 
foreach ($options as $option => $default)
{
    echo CLI::color($option, 'light_gray');

    $key = $name.' '.$option;
    $info = __($key);
    echo $key == $info ? '' : ' - '.$info;

    echo ': '.var_export($default, TRUE).PHP_EOL;
}
?>

<?php echo CLI::color(__('Show controller manual'), 'light_gray') ?>
-------------------------------------------------
php <?php echo CLI::script() ?> --name=manual --class=<?php echo $name ?>

<?php if (Kohana::$caching) Fragment::save() ?>
<?php endif ?>

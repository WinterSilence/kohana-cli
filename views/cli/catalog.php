<?php defined('SYSPATH') OR die('No direct script access.') ?>

<?php if ( ! Fragment::load('cli_catalog', 3600, TRUE)): ?>

<?php echo CLI::color(__('Catalog of CLI controllers'), 'black', 'light_gray') ?>
-------------------------------------------------
<?php 
foreach ($catalog as $i => $name):
{
    echo CLI::color($name, 'light_gray');
    
    $description = __($name);
    echo ($name == $description ? '' : ': '.$description).PHP_EOL;
}
?>

<?php echo CLI::color(__('Default controller'), 'light_gray') ?>
-------------------------------------------------
<?php echo CLI_Manager::name2class(CLI_Manager::$default) ?>

<?php echo CLI::color(__('Execute controller'), 'light_gray') ?>
-------------------------------------------------
php <?php echo CLI::script() ?> --name=<controller name> [--option1=<value1>] [--option2=<value2>]

<?php echo CLI::color(__('Show controller manual'), 'light_gray') ?>
-------------------------------------------------
php <?php echo CLI::script() ?> --name=manual --class=<controller name>

<?php if (Kohana::$caching) Fragment::save() ?>
<?php endif ?>

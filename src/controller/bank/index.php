<?php
require '../../model/City.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;


$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index')->render();

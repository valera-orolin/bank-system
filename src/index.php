<?php
require 'vendor/autoload.php';
use Jenssegers\Blade\Blade;

$blade = new Blade('view', 'cache');
echo $blade->make('index')->render();
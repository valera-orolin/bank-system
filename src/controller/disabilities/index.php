<?php
require '../../model/Disability.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$disabilities = Disability::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('disabilities.index', [
    'disabilities' => $disabilities,
])->render();

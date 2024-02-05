<?php
require '../../model/MaritalStatus.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$marital_statuses = MaritalStatus::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('marital_statuses.index', [
    'marital_statuses' => $marital_statuses,
])->render();
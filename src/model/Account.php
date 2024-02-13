<?php
require_once 'mysql/db_functions.php';

class Account {
    public static function clear() {
        $query = "SELECT * FROM city";
        return executeQuery($query);
    }
}
<?php
require_once 'mysql/db_functions.php';

class Country {
    public static function all() {
        $query = "SELECT * FROM country";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM country WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name) {
        $query = "INSERT INTO country (name) VALUES (?)";
        return executeQuery($query, [$name]);
    }

    public static function update($id, $name) {
        $query = "UPDATE country SET name = ? WHERE id = ?";
        return executeQuery($query, [$name, $id]);
    }
}
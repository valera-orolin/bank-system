<?php
require_once 'mysql/db_functions.php';

class City 
{
    public static function all() {
        $query = "SELECT * FROM city";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM city WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name) {
        $query = "INSERT INTO city (name) VALUES (?)";
        return executeQuery($query, [$name]);
    }

    public static function update($id, $name) {
        $query = "UPDATE city SET name = ? WHERE id = ?";
        return executeQuery($query, [$name, $id]);
    }
}
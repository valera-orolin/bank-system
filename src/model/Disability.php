<?php
require_once 'mysql/db_functions.php';

class Disability 
{
    public static function all() {
        $query = "SELECT * FROM disability";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM disability WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name) {
        $query = "INSERT INTO disability (name) VALUES (?)";
        return executeQuery($query, [$name]);
    }

    public static function update($id, $name) {
        $query = "UPDATE disability SET name = ? WHERE id = ?";
        return executeQuery($query, [$name, $id]);
    }
}

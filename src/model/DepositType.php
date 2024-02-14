<?php
require_once 'mysql/db_functions.php';

class DepositType {
    public static function all() {
        $query = "SELECT * FROM deposit_type";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM deposit_type WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name, $rate, $currency, $min_amount, $max_amount, $period, $revocation) {
        $query = "INSERT INTO deposit_type (name, rate, currency, min_amount, max_amount, period, revocation) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$name, $rate, $currency, $min_amount, $max_amount, $period, $revocation]);
    }

    public static function update($id, $name, $rate, $currency, $min_amount, $max_amount, $period, $revocation) {
        $query = "UPDATE deposit_type SET name = ?, rate = ?, currency = ?, min_amount = ?, max_amount = ?, period = ?, revocation = ? WHERE id = ?";
        return executeQuery($query, [$name, $rate, $currency, $min_amount, $max_amount, $period, $revocation, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`deposit_type`";
        return executeQuery($query);
    }

    public static function getDepositTypeName($id) {
        if ($id === null) {
            return null;
        }
        $query = "SELECT name FROM deposit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function getCurrency($id) {
        if ($id === null) {
            return null;
        }
        $query = "SELECT currency FROM deposit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['currency'];
    }

    public static function getRevocation($id) {
        if ($id === null) {
            return null;
        }
        $query = "SELECT revocation FROM deposit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['revocation'];
    }

    public static function getAmountRange($id) {
        if ($id === null) {
            return null;
        }
        $query = "SELECT min_amount, max_amount FROM deposit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0];
    }
}

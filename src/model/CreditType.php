<?php
require_once 'mysql/db_functions.php';

class CreditType 
{
    public static function all() {
        $query = "SELECT * FROM credit_type";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM credit_type WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type) {
        $query = "INSERT INTO credit_type (name, rate, currency, min_amount, max_amount, min_period, max_period, payment_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type]);
    }

    public static function storeWithId($id, $name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type) {
        $query = "INSERT INTO credit_type (id, name, rate, currency, min_amount, max_amount, min_period, max_period, payment_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$id, $name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type]);
    }
    

    public static function update($id, $name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type) {
        $query = "UPDATE credit_type SET name = ?, rate = ?, currency = ?, min_amount = ?, max_amount = ?, min_period = ?, max_period = ?, payment_type = ? WHERE id = ?";
        return executeQuery($query, [$name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`credit_type`";
        return executeQuery($query);
    }

    public static function getCreditTypeName($id) {
        $query = "SELECT name FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function getCurrency($id) {
        $query = "SELECT currency FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['currency'];
    }

    public static function getMinAmount($id) {
        $query = "SELECT min_amount FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['min_amount'];
    }

    public static function getMaxAmount($id) {
        $query = "SELECT max_amount FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['max_amount'];
    }

    public static function getMinPeriod($id) {
        $query = "SELECT min_period FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['min_period'];
    }

    public static function getMaxPeriod($id) {
        $query = "SELECT max_period FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['max_period'];
    }

    public static function getPaymentType($id) {
        $query = "SELECT payment_type FROM credit_type WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['payment_type'];
    }
}

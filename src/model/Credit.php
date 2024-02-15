<?php
require_once 'mysql/db_functions.php';

class Credit 
{
    public static function all() {
        $query = "SELECT * FROM credit";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM credit WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount) {
        $query = "INSERT INTO credit (credit_type, start_date, period, client, current_account, interest_account, amount) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount]);
    }

    public static function update($id, $credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount) {
        $query = "UPDATE credit SET credit_type = ?, start_date = ?, period = ?, client = ?, current_account = ?, interest_account = ?, amount = ? WHERE id = ?";
        return executeQuery($query, [$credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`credit`";
        return executeQuery($query);
    }

    public static function getRate($id) {
        $query = "SELECT rate FROM credit_type WHERE id = (SELECT credit_type FROM credit WHERE id = ?)";
        $result = executeQuery($query, [$id]);
        return $result[0]['rate'];
    }

    public static function getCurrency($id) {
        $query = "SELECT currency FROM credit_type WHERE id = (SELECT credit_type FROM credit WHERE id = ?)";
        $result = executeQuery($query, [$id]);
        return $result[0]['currency'];
    }

    public static function getAmount($id) {
        $query = "SELECT amount FROM credit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['amount'];
    }

    public static function getCreditType($id) {
        $query = "SELECT credit_type FROM credit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['credit_type'];
    }
    
    public static function getCurrentAccount($id) {
        $query = "SELECT current_account FROM credit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['current_account'];
    }
    
    public static function getInterestAccount($id) {
        $query = "SELECT interest_account FROM credit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['interest_account'];
    }    
}

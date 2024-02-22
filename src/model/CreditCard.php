<?php
require_once 'mysql/db_functions.php';
session_start();

class CreditCard 
{
    public static function all() {
        $query = "SELECT * FROM credit_card";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM credit_card WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($number, $pin, $account) {
        $query = "INSERT INTO credit_card (number, pin, account) VALUES (?, ?, ?)";
        return executeQuery($query, [$number, $pin, $account]);
    }

    public static function update($id, $number, $pin, $account) {
        $query = "UPDATE credit_card SET number = ?, pin = ?, account = ? WHERE id = ?";
        return executeQuery($query, [$number, $pin, $account, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`credit_card`";
        return executeQuery($query);
    }

    public static function getNumber($id) {
        $query = "SELECT number FROM credit_card WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['number'];
    }

    public static function getPin($id) {
        $query = "SELECT pin FROM credit_card WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['pin'];
    }

    public static function getAccount($id) {
        $query = "SELECT account FROM credit_card WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['account'];
    }

    public static function authenticate($number, $pin) {
        if (!isset($_SESSION['attemptCount'][$number])) {
            $_SESSION['attemptCount'][$number] = 0;
        }

        if ($_SESSION['attemptCount'][$number] >= 3) {
            throw new Exception('Login attempts exceeded');
        }

        $query = "SELECT * FROM credit_card WHERE number = ? AND pin = ?";
        $result = executeQuery($query, [$number, $pin]);
        if (!empty($result)) {
            $_SESSION['attemptCount'][$number] = 0;
            return $result[0]['id'];
        } else {
            $_SESSION['attemptCount'][$number]++;
            return null;
        }
    }
}

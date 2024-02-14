<?php
require_once 'mysql/db_functions.php';

class CurrentDate 
{
    public static function setCurrentDate($date) {
        $clearQuery = "DELETE FROM `bank`.`current_date`";
        executeQuery($clearQuery);
        $insertQuery = "INSERT INTO `current_date` (id, date) VALUES (1, ?)";
        return executeQuery($insertQuery, [$date]);
    }

    public static function getCurrentDate() {
        $query = "SELECT date FROM `current_date` LIMIT 1";
        $result = executeQuery($query);
        return isset($result[0]) ? $result[0]['date'] : null;
    }

    public static function incrementDate() {
        $query = "UPDATE `current_date` SET date = DATE_ADD(date, INTERVAL 1 DAY) WHERE id = 1";
        return executeQuery($query);
    }
}

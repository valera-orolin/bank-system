<?php
function executeQuery($query, $params = []) 
{
    global $connect;
    $connect = mysqli_connect(
        'db',
        'user',
        'password',
        'bank'
    );

    $stmt = mysqli_prepare($connect, $query);

    if ($params) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    $executionResult = mysqli_stmt_execute($stmt);

    if (str_starts_with(trim(strtolower($query)), 'insert') || str_starts_with(trim(strtolower($query)), 'update') || str_starts_with(trim(strtolower($query)), 'delete')) {
        return $executionResult;
    } else {
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

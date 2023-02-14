<?php
session_start();

require_once($_SERVER["DOCUMENT_ROOT"] . '/log4php/Logger.php');
Logger::configure($_SERVER["DOCUMENT_ROOT"] . '/log4php/config.xml');
$GLOBALS['logger'] = Logger::getLogger("myLogger");

///////////////////////////////////////////////////////////////////////////////////////////////////

include_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common_class.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/includes/db_config.php');

///////////////////////////////////////////////////////////////////////////////////////////////////

$returnJson = isset($_POST['returnJson']) ? $_POST['returnJson'] : 'false';

if ($returnJson === 'true') {
    $fn = isset($_POST['fn']) ? $_POST['fn'] : false;
    $params = isset($_POST['params']) ? $_POST['params'] : false;
    $list = call_user_func($fn, json_decode($params));
    echo createSuccessJsonWithData('REP', 'success', json_encode($list));
} else if($returnJson === 'false') {
    $fn = isset($_POST['fn']) ? $_POST['fn'] : false;
    $params = isset($_POST['params']) ? $_POST['params'] : false;
    $list = call_user_func($fn, json_decode($params));
}

///////////////////////////////////////////////////////////////////////////////////////////////////

function post($params) {
    $conn = openConn();

    $sql = "
        INSERT INTO test_comments (userId, regTime, comments)
        VALUES ('unknowUser', GETDATE(), :comment)
    ";

    $comment = isset($params) ? $params->comment : '';

    $GLOBALS['logger']->info($comment);

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":comment", $comment);
    $stmt->execute();
}

function get_comments() {
    $conn = openConn();

    $sql = "
        SELECT id, userId, comments
        FROM test_comments;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $GLOBALS['logger']->info($resultList);
    return $resultList;
}

?>
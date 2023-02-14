<?php

function createErrorJson($errorCode, $errorMessage) {
	return '{"bz_status":"error","bz_message":"'.$errorMessage.'", "bz_code":"'.$errorCode.'"}';
}
function createErrorJson2($errorCode, $errorMessage, $exception) {
	return '{"bz_status":"error"
		, "bz_message":"'.$errorMessage.'"
		, "bz_trace":"'.$exception->getTraceAsString().'"
		, "bz_code":"'.$errorCode.'"}';
}
function createErrorJsonFromObject($errorCode, $errorMessage) {
	$obj = new stdClass();
	$obj->bz_status = "error";
	$obj->bz_message = $errorMessage;
	$obj->bz_code = $errorCode;

	return json_encode($obj);
}

function createSuccessJson($code, $message) {
	return '{"bz_status":"success","bz_message":"'.$message.'", "bz_code":"'.$code.'"}';
}

function createSuccessJsonWithData($code, $message, $data) {
	return '{"bz_status":"success"
		, "bz_message":"'.$message.'"
		, "bz_code":"'.$code.'"
		, "bz_data":'.$data.'}';
}

function pdo_sql_debug($sql, $placeholders) {
    //var_dump($placeholders);
    foreach($placeholders as $k => $v){
        //echo $k." => ".$v;
        $sql = preg_replace('/'.$k.'\b/',"'".$v."'",$sql);
    }
    return $sql;
}

?>
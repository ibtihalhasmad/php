<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

include_once("connect.php");
$subid = addslashes($_POST['subject_id']);
$op = addslashes($_POST['operation']);

if ($op =="+"){
    $updatesub = "UPDATE `tbl_subcart` SET `subqty`= (subqty+1) WHERE subject_id = '$subid'";    
}

if ($op =="-"){
    $updatesub = "UPDATE `tbl_subcart` SET `subqty`= if(subqty>1,(subqty-1),subqty) WHERE subject_id = '$subid'";    
}

if ($conn->query($updatesub)){
    $response = array('status' => 'success', 'data' => null);    
}else{
    $response = array('status' => 'failed', 'data' => null);
}

sendJsonResponse($response);

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>
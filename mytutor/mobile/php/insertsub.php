<?php
if(!isset($_POST)){
    $response = array('status'=>'failed', 'date' => null);
    sendJsonResponse($response);
    die();
}
include_once("connect.php");
include_once("dbconnect.php");
$subject_id = $_POST['subject_id'];
$email       = $_POST['user_email'];
$subqty = "1";
$subtotal = "0";

$sqlcheckqty = "SELECT * FROM tbl_subjects where subject_id = '$subjectid'";
$resultqty = $conn->query($sqlcheckqty);
$num_of_qty = $resultqty->num_rows;
if ($num_of_qty>1){
    $response = array('status' => 'failed', 'data' => null);
	sendJsonResponse($response);
	return;

}

$sqlinsert = "SELECT * FROM tbl_subcart WHERE $user_email = '$email' AND $subject_id = '$subject_id' AND cart_status IS NULL";
$result = $conn->query($sqlinsert);
$number_of_result = $result->num_rows;

if($result->num_rows >0){
    $response = array('status'=>'failed', 'date' =>  null);
    sendJsonResponse($response);
    return;
}
else 
{
    $addcart = "INSERT INTO `tbl_subcart`(`email`, `subject_id `, `subqty`) VALUES ('$useremail','$subjectid','$cartqty')";
    if ($conn->query($addcart) === TRUE) {

	}else{
	    $response = array('status' => 'failed', 'data' => null);
		sendJsonResponse($response);
		return;
    }
}


$sqlGetQty= "SELECT * FROM tbl_subcart WHERE $user_email = '$email' AND cart_status IS NULL ";
$result = $conn->query($sqlGetQty);
$number_of_result = $result->num_rows;
$subtotal = 0;
while($row= $result->fetch_assoc()){
    $subtotal = $row['subqty'] + $subtotal;
}
$mysub= array();
$mysub['subcarttotal']= $subtotal; 
$response = array('status'=>'success', 'date' =>  null);
sendJsonResponse($response);

function sendJsonResponse($sendArray){
    header('Content-Type: application/json');
    echo json_encode($sendArray);
}

?>
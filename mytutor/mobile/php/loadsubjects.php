<?php
if(!isset($_POST)){
    $response = array('status'=>'failed', 'date' => null);
    sendJsonResponse($response);
    die();
}
include_once("connect.php");
$results_per_page = 5;
$pageno = (int)$_POST['pageno'];
$search = $_POST['search'];
$type = $_POST['type'];

$page_first_result = ($pageno - 1)* $results_per_page;

if ($type=="All"){
$sqlloadsub= "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%search%' ORDER BY subject_id DESC";
}else{
    $sqlloadsub= "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%search%' AND study_plan '$type' ORDER BY subject_id DESC";
}

$sqlloadsub= "SELECT * FROM tbl_subjects";
$result = $conn->query($sqlloadsub);
$number_of_result = $result->num_rows;
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlloadsub= $sqlloadsub . "LIMIT $page_first_result , $results_per_page";
$result = $conn->query($sqlloadsub);

if($result->num_rows >0){

    $subjects ["subjects"] = array();
    while($row= $result->fetch_assoc()){
    $sublist = array();
    $sublist  ['subject_id']= $row['subject_id'];
    $sublist  ['subject_name']= $row['subject_name'];
    $sublist  ['subject_description']= $row['subject_description'];
    $sublist  ['subject_price']= $row['subject_price'];
    $sublist  ['tutor_id']= $row['tutor_id'];
    $sublist  ['subject_sessions']= $row['subject_sessions'];
    $sublist  ['subject_rating']= $row['subject_rating'];

    array_push( $subjects["subjects"], $sublist );

}
$response = array('status' => 'success', 'pageno'=>"$pageno",'numofpage'=>"$number_of_page", 'data' => $subjects);
sendJsonResponse($response);
} else {
$response = array('status' => 'failed', 'pageno'=>"$pageno",'numofpage'=>"$number_of_page",'data' => null);
sendJsonResponse($response);
}


function sendJsonResponse($sendArray){
    header('Content-Type: application/json');
    echo json_encode($sendArray);
}



?>
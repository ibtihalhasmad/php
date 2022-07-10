<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
include_once("connect.php");
$email       = $_POST['user_email'];
$sqlloadcart = "SELECT tbl_subcart.subCart, tbl_subcart.subject_id, tbl_subcart.subqty, tbl_subjects.subject_name,tbl_subjects.subject_sessions, tbl_subjects.subject_price FROM tbl_subcart INNER JOIN tbl_subjects ON tbl_subcart.subject_id = tbl_subjects.subject_id WHERE tbl_subcart.user_email = '$email' AND tbl_subcart.cart_status IS NULL";
$result = $conn->query($sqlloadcart);
$number_of_result = $result->num_rows;
if ($result->num_rows > 0) {
    
    $total_payable = 0;
    $carts["cart"] = array();
    while ($rows = $result->fetch_assoc()) {
        $cartlist = array();
        $cartlist['cartid'] = $rows['subCart'];
        $cartlist['sbname'] = $rows['subject_name'];
        $sbprice = $rows['subject_price'];
        $cartlist['sbsession'] = $rows['subject_sessions'];
        $cartlist['price'] = number_format((float)$sbprice, 2, '.', '');
        $cartlist['cartqty'] = $rows['subqty'];
        $cartlist['sbid'] = $rows['subject_id'];
        $price = $rows['cart_qty'] * $sbprice;
        $total_payable = $total_payable + $price;
        $cartlist['pricetotal'] = number_format((float)$price, 2, '.', ''); 
        array_push($carts["cart"],$cartlist);
    }
    $response = array('status' => 'success', 'data' => $carts, 'total' => $total_payable);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>
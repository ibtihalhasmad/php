<?php
if (!isset($_POST)) {
    echo "failed";
    }
    include_once("dbconnect.php");
    if(isset($_POST['user_email']) || isset($_POST['user_password'])){
    $email       = $_POST['user_email'];
    $password    = sha1($_POST['user_password']);
    $sqllogin    = "SELECT * FROM tbl_user WHERE user_email = '$email' AND user_password = '$password'";
    $result      = $conn->query($sqllogin);
    $numrow      = $result->num_rows;
    if ($numrow > 0) {
        echo "success";
    }else{
        echo "failed";
}
}      
?>
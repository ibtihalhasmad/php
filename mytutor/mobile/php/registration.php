<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
    include_once("dbconnect.php");
    if(isset($_POST['user_email']) || isset($_POST['user_name']) || 
isset($_POST['user_phone']) || isset($_POST['user_homeaddress']) || 
isset($_POST['user_password']) || isset($_POST['user_gender']) ){
    $email         =  $_POST['user_email'];
    $password      =  sha1($_POST['user_password']);
    $name          = $_POST['user_name'];
    $phone         = $_POST['user_phone'];
    $homeaddress   = $_POST['user_homeaddress'];
    $base64Image   = $_POST['image'];
    $gender        = $_POST['user_gender'];

    $sqlinsert ="INSERT INTO `tbl_user`(`user_email`,`user_password`, `user_name`, `user_phone`, `user_homeaddress`, `user_gender`)
 VALUES ('$email','$password','$name','$phone','$homeaddress','$gender')";
    if ($conn->query($sqlinsert) === TRUE) {
        $response = array('status' =>'status','data' =>null);
        $filename = mysqli_insert_id($conn);
        $decoded_string = base64_decode($base64Image);
        $path = '../assets/users/' . $filename . '.jpg';
        $is_written = file_put_contents($path, $decoded_string);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }
    $result      = $conn->query($sqllogin);
    $numrow      = $result->num_rows;
    if ($numrow > 0) {
       
        while ($row = $result->fetch_assoc()) {
            $user['user_id'] = $row['user_id'];
            $user['user_email'] = $row['user_email'];
            $user['user_password'] = $row['user_password'];
            $user['user_name'] = $row['user_name'];
            $user['user_phone'] = $row['user_phone'];
            $user['user_homeaddress'] = $row['user_homeaddress'];
            $user['image'] = $row['user_image'];
            $user['user_gender'] = $row['user_gender'];

        }
        $response = array('state'=>'success', 'data'=>$user);
        sendJasonResponse($response);
    }
    function sendJasonResponse($sendArray){
        header('Content-Type: application/json');
        echo json_encode($sendArray);
    }
            
}
    
?>

<?php
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';
try {
    $conn = new PDO($server, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $ex){
    echo'NOT CONNECTED' .$ex->getMessage();
}


if(isset($_POST['btnsend'])){

    if ($_POST['msgbox'] !== ''){

    include'smsGateway.php';
    $smsGateway= new SmsGateway('cedrick048@yahoo.com','longview048');

    $message=$_POST['msgbox'].' -'.$_POST['insname'];
    $deviceid='83367';
    $options=[
        'send_at' => strtotime('+10 seconds'),
        'expire_at' => strtotime('30 minutes')
    ];

    $smsGateway->sendMessageToNumber($_POST['contact'],$message,$deviceid,$options);

    echo "<script>alert('message sent');</script>";
}else{
        echo "<script>alert('message has an empty body');</script>";
    }

}
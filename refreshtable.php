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


if(isset($_POST['refresh'])){
    $classcode = $_POST['classcode'];

    echo "<script> 
          alert('Records are refreshed');
          window.top.location = 'classplatform.php?classcode=$classcode';
          </script>";
}
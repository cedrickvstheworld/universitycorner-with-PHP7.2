<?php
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

try {
    $conn = new PDO($server, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (Exception $ex){
    echo 'NOT CONNECTED' .$ex->getMessage();
}


if(isset($_GET['postid'])){
    $postid=$_GET['postid'];
    $deletepost='DELETE FROM tblpost WHERE postid = :postid';
    $stmt=$conn->prepare($deletepost);
    $stmt->execute(array(
       ':postid'=>$postid
    ));
    if($stmt){
        echo '<script>
              window.location="educatorindex.php";
              alert("Post has been deleted and there is no way you can retrieve it!");
             </script>';
    }
}
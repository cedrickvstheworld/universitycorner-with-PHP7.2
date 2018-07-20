<?php
session_start();
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

if(isset($_SESSION['userac2'])&&$_SESSION['arcode']){
    header('location:verifycode.php');
}else{
    echo '';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title id="page-top">University Corner</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="loginpage.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Bootstrap core CSS -->

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/agency.min.css" rel="stylesheet">

</head>
<body>
<!--nav-->
<nav class="navbar navbar-inverse">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger text-primary" href="loginpage.php">University Corner<small id="secondarytext" class="text-muted"> keep learning</small></a>
        <div class="asd container">
        </div>
    </div>

</nav>

<!--nav-->

<form action="sendsmscode.php" method="post" >
    <div class="form-group well">
        <h2 id="txtar" class="modal-header">Send SMS Code</h2>
        <input type="text" class="form-control" id="usernameforsms" name="usernameforsms" placeholder="Username" required><br>
        <div class="text-right">
            <input type="button" onclick="returnlogin();" id="cancelac" class="btn btn-danger" value="Cancel">
            <input type="submit" name="sendsms" class="btn-info btn" value="Send">
        </div>
    </div>
</form>

<?php
if(isset($_POST['sendsms'])){
    $usernameforsms=$_POST['usernameforsms'];

    $query1 = 'SELECT * FROM tblinstructor WHERE username = :user';
    $query2 = 'SELECT * FROM tblstudent WHERE username = :user';
    $query3 = 'SELECT * FROM tblparent WHERE username = :user';

    $stmt = $conn->prepare($query1);
    $stmt->execute(
        array(
            ':user' => $usernameforsms,
        )
    );
    if ($stmt->rowCount() > 0) {
        $arcode=mt_rand(111111, 999999);
        $_SESSION['userac2']=$usernameforsms;
        $_SESSION['arcode']=$arcode;
        //sms notifies here
        $getnumber='SELECT *FROM tblinstructor WHERE username = :username';
        $query34=$conn->prepare($getnumber);
        $query34->execute(array(
            ':username'=> $usernameforsms,));
        if ($query34->rowCount()>0){
            $tblinstructor=$query34->fetch();
            $cnumber = $tblinstructor[13];

            include'smsGateway.php';
            $smsGateway= new SmsGateway('cedrick048@yahoo.com','longview048');

            $message='Hi! the code for your account recovery is '.$arcode;
            $deviceid='83367';
            $options=[
                'send_at' => strtotime('+10 seconds'),
                'expire_at' => strtotime('30 minutes')
            ];

            $smsGateway->sendMessageToNumber($cnumber,$message,$deviceid,$options);

        }
        //sms notifies here
        $_SESSION['number']=$cnumber;
        echo '<script>
              alert("A 6-digit verification code was sent to your phone number.");
              window.location="verifycode.php";
              </script>';
    }else{
        $stmt = $conn->prepare($query2);
        $stmt->execute(
            array(
                ':user' => $usernameforsms,
            ));
        if ($stmt->rowCount() > 0){
            $arcode=mt_rand(111111, 999999);
            $_SESSION['userac2']=$usernameforsms;
            $_SESSION['arcode']=$arcode;
            //sms notifies here
            $getnumber='SELECT *FROM tblstudent WHERE username = :username';
            $query34=$conn->prepare($getnumber);
            $query34->execute(array(
                ':username'=> $usernameforsms,));
            if ($query34->rowCount()>0){
                $tblstudent=$query34->fetch();
                $cnumber = $tblstudent[3];

                include'smsGateway.php';
                $smsGateway= new SmsGateway('cedrick048@yahoo.com','longview048');

                $message='Hi! the code for your account recovery is '.$arcode;
                $deviceid='83367';
                $options=[
                    'send_at' => strtotime('+10 seconds'),
                    'expire_at' => strtotime('30 minutes')
                ];

                $smsGateway->sendMessageToNumber($cnumber,$message,$deviceid,$options);

            }
            //sms notifies here
            $_SESSION['number']=$cnumber;
            echo '<script>
              alert("A 6-digit verification code was sent to your phone number.");
              window.location="verifycode.php";
              </script>';

        }else{
            $stmt = $conn->prepare($query3);
            $stmt->execute(
                array(
                    ':user' => $usernameforsms,
                ));
            if ($stmt->rowCount() > 0){
                $arcode=mt_rand(111111, 999999);
                $_SESSION['userac2']=$usernameforsms;
                $_SESSION['arcode']=$arcode;
                //sms notifies here
                $getnumber='SELECT *FROM tblinstructor WHERE username = :username';
                $query34=$conn->prepare($getnumber);
                $query34->execute(array(
                    ':username'=> $usernameforsms,));
                if ($query34->rowCount()>0){
                    $tblparent=$query34->fetch();
                    $cnumber = $tblparent[13];

                    include'smsGateway.php';
                    $smsGateway= new SmsGateway('cedrick048@yahoo.com','longview048');

                    $message='Hi! the code for your account recovery is '.$arcode;
                    $deviceid='83367';
                    $options=[
                        'send_at' => strtotime('+10 seconds'),
                        'expire_at' => strtotime('30 minutes')
                    ];

                    $smsGateway->sendMessageToNumber($cnumber,$message,$deviceid,$options);

                }
                //sms notifies here
                $_SESSION['number']=$cnumber;
                echo '<script>
              alert("A 6-digit verification code was sent to your phone number.");
              window.location="verifycode.php";
              </script>';

            } else {
                echo "<script>alert('User does not exist.');</script>";
            }
        }
    }
}
?>



<!-- Footer -->
<?php
date_default_timezone_set('asia/manila');
$date = new DateTime('now');
$copyrightyear = date('Y');
?>
<div class="panel-footer navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright text-success">Copyright &copy; University Corner <?php echo $copyrightyear; ?></span>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
                    <li class="list-inline-item">
                        <a class="text-success" href="privacystmt.php" target="_blank">Privacy Statement</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--footer-->

<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="cediescripts.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>

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
?>
<?php
if (isset($_SESSION['user'])){
    header('location:educatorindex.php');
}elseif (isset($_SESSION['user2'])){
    header('location:studentindex.php');
}elseif (isset($_SESSION['user3'])){
    header('location:parentindex.php');
}elseif (isset($_SESSION['userac'])){
    header('location:changepassoutside.php');
}else{
    echo '';
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

<form action="accountrecovery.php" method="post" >
    <div class="form-group well">
        <h2 id="txtar" class="modal-header">Account Recovery</h2>
        <h5 class="text-sky">Choose a recovery option.</h5>
        <div class="text-left" style="padding-left:80px;">
        <input type="radio" name="acoptions" onclick="unchecked();" value="asq" placeholder="">
            <span class="text-white"> Answer Security Question.</span><br>
        <input type="radio" name="acoptions" onclick="unchecked();" value="ssc" placeholder="">
            <span class="text-white"> Send SMS Code.</span><br>
        </div>
        <div class="text-right">
        <input type="button" onclick="returnlogin();" id="cancelac" class="btn btn-danger" value="Cancel">
        <input type="button" onclick="chooseopt();" disabled id="next1" class="btn btn-success" value="Next">
        </div>
    </div>

</form>



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
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>



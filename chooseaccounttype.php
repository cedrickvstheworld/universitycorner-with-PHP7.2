<?php
session_start();
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

//connection

try{
    $con=new PDO($server,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch (Exception $ex){
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
}else{
    echo '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title id="page-top">University Corner</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="chooseaccounttype.css">
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
        <a class="navbar-brand js-scroll-trigger text-primary" href="loginpage.php">University Corner<small id="secondarytext" class="text-muted">  keep learning</small></a>
        <div class="asd container">
        </div>
    </div>

</nav>

<!--nav-->

<!--choose account type-->
<form>

    <div class="modal-header container">
        <br>
        <h2 class="title text-center">Choose an Account Type</h2>
    </div><br>
<div class="accounttype container">
    <div class="well">
        <a class="btn-link" href="studentregistration.php"><h3 class="text-capitalize text-info text-center">Student</h3></a>
        <p></p>
    </div>
</div>
 <div class="accounttype container">
     <div class="well">
         <a class="btn-link" href="educatorregistration.php"><h3 class="text-capitalize text-info text-center">Educator</h3></a>
     </div>
</div>
<div class="accounttype container">
    <div class="well">
        <a class="btn-link" href="parentregistration.php"><h3 class="text-capitalize text-info text-center">Parent</h3></a>
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
                <span class="copyright text-success">Copyright &copy; University Corner <?php echo $copyrightyear?></span>
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
<script src="cediescripts2.js"></script>
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>
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
    echo '';
}else{
    header('location:loginpage.php');
}

$user=$_SESSION['userac'];
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

<form action="changepassoutside.php" method="post" >
    <div class="form-group well">
        <h2 id="txtar" class="modal-header">Change Password</h2>
        <input type="password" class="maxlen40 form-control" id="password" name="passchange" placeholder="Password" required><br>
        <input type="password" class="maxlen40 form-control" id="confirmnewp" name="confirmchange" placeholder="Confirm Password" required><br>
        <div class="text-right">
            <button id= "show_password" class="btn btn-secondary" type="button">
                <span class="glyphicon glyphicon-eye-open"></span>
            </button>
            <a href="logout.php">
            <input type="button" class="btn btn-danger" value="Cancel"></a>
            <input type="submit" name="finstep" class="btn-success btn" value="Change">
        </div>
        <div id="sec"></div>
    </div>
    <?php
    //change p happens here
    if(isset($_POST['finstep'])) {
        $pass = $_POST['passchange'];
        $confirm = $_POST['confirmchange'];
        if (strlen($pass) < 8) {
            echo '<script>alert("password must contain atleast 8 characters");
                                  document.getElementById("newp").value="";</script>';
        } else {
            if ($pass !== $confirm) {
                echo "<script>alert('Password did not match.');</script>";
            } else {
                //instructor
                $findininstructor = 'SELECT *FROM tblinstructor WHERE username = :username';
                $stmt = $conn->prepare($findininstructor);
                $stmt->execute(array(
                    ':username' => $user,
                ));
                if ($stmt->rowCount() > 0) {
                    $tblinstructor = $stmt->fetch();
                    $oldpass = $tblinstructor['password'];

                    if (password_verify("$pass", "$oldpass")) {
                        echo "<script>alert('Dude, That was an old password. Think another.');</script>";
                    } else {
                        $passwordxxx = password_hash("$pass", PASSWORD_BCRYPT);
                        $updatepass = 'UPDATE tblinstructor SET password = :password';
                        $stmt = $conn->prepare($updatepass);
                        $stmt->execute(array(
                            ':password' => $passwordxxx,
                        ));
                        if ($stmt) {
                            $_SESSION['user'] = $user;
                            header('location:educatorindex.php');
                        }
                    }
                } else {
                    //student
                    $findinstudent = 'SELECT *FROM tblstudent WHERE username = :username';
                    $stmt = $conn->prepare($findinstudent);
                    $stmt->execute(array(
                        ':username' => $user,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblstudent = $stmt->fetch();
                        $oldpass = $tblstudent['password'];

                        if (password_verify("$pass", "$oldpass")) {
                            echo "<script>alert('Dude, That was an old password. Think another.');</script>";
                        } else {
                            $passwordxxx = password_hash("$pass", PASSWORD_BCRYPT);
                            $updatepass = 'UPDATE tblstudent SET password = :password';
                            $stmt = $conn->prepare($updatepass);
                            $stmt->execute(array(
                                ':password' => $passwordxxx,
                            ));
                            if ($stmt) {
                                $_SESSION['user2'] = $user;
                                header('location:studentindex.php');
                            }
                        }
                    } else {
                        //parent
                        $findinparent = 'SELECT *FROM tblparent WHERE username = :username';
                        $stmt = $conn->prepare($findinparent);
                        $stmt->execute(array(
                            ':username' => $user,
                        ));
                        if ($stmt->rowCount() > 0) {
                            $tblparent = $stmt->fetch();
                            $oldpass = $tblparent['password'];

                            if (password_verify("$pass", "$oldpass")) {
                                echo "<script>alert('Dude, That was an old password. Think another.');</script>";
                            } else {
                                $passwordxxx = password_hash("$pass", PASSWORD_BCRYPT);
                                $updatepass = 'UPDATE tblparent SET password = :password';
                                $stmt = $conn->prepare($updatepass);
                                $stmt->execute(array(
                                    ':password' => $passwordxxx,
                                ));
                                if ($stmt) {
                                    $_SESSION['user3'] = $user;
                                    header('location:parentindex.php');
                                }
                            }

                        }

                    }
                }
            }
        }
    }
    //change p happens here
    ?>
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

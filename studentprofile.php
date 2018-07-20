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

session_start();
if (isset($_SESSION['user']))
{
    echo '';

}else{
    header('location:loginpage.php');
}

$studregno=$_GET['studregno'];
?>

<!DOCTYPE html>
<html>
<head>
    <title id="educatorindex">University Corner</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
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
    <!--date table-->
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.16/media/css/dataTables.bootstrap.min.css">

</head>

<body>
<!--top nav-->
<div class="navbar-fixed-top">
    <nav class="navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand text-primary" href="#educatorindex">University Corner</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="educatorindex.php"><img class="img-responsive" src="images/house-hi.png"></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<!--top navbar-->

<?php
$studprofile='SELECT *FROM tblstudent WHERE studregno = :studregno';
$stmt=$conn->prepare($studprofile);
$stmt->execute(array(
   ':studregno'=>$studregno,
));
if($stmt->rowCount()>0){
    $tblstudent=$stmt->fetch();
     $fname = $tblstudent[1];
     $mname = $tblstudent[6];
     $lname = $tblstudent[2];
     $studcode = $tblstudent[15];
     $address = $tblstudent[5];
     $birthmonth = $tblstudent[12];
     $birthday = $tblstudent[13];
     $birthyear = $tblstudent[14];
     $contact = $tblstudent[3];
     $guardiancontact = $tblstudent[4];
}

?>
<br><br><br><br>
<h3 class="text-info modal-header container text-capitalize"><?php echo $fname.' '.$mname.' '.$lname?></h3>
<br>
<div class="container">


<div class="col-lg-4">
    <?php
    $retrieveimg='SELECT *FROM tblstudent WHERE studregno = :studregno';
    $stmt=$conn->prepare($retrieveimg);
    $stmt->execute(array(
        ':studregno' => $studregno,
    ));
    if($stmt->rowCount()>0){
        $tblstudent=$stmt->fetch();
        $img=$tblstudent['studentimg'];
        if($img !== null){
            echo "<img src=\"profilepics/$img\" class='imgprofiles img-rounded'>";
        }else{
            echo '<img src="img/profiledefault.jpg" class="imgprofiles img-rounded">';
        }
    }
    ?>
    <!--profile picture-->
</div>


<div class="col-lg-4">
    <h4 class="text-success text-capitalize"><?php echo 'Student Code: '?></h4><h4><?php echo $studcode; ?></h4><br>
    <h4 class="text-success text-capitalize"><?php echo 'Address: '?></h4><h4><?php echo $address; ?></h4><br>
    <h4 class="text-success text-capitalize"><?php echo 'Birthday: '?></h4><h4><?php echo $birthmonth.' '.$birthday.', '.$birthyear; ?></h4><br>
    <h4 class="text-success text-capitalize"><?php echo 'Phone Number: '?></h4><h4><?php echo $contact; ?></h4><br>
</div>

<div class="col-lg-4">
    <?php
    if (isset($_SESSION['user'])) {
        echo '<h4 class="text-info">Who\'s Monitoring This Kid?</h4>';
        $fetchparents = 'SELECT tblclass_parent.studregno, tblparent.contact, tblparent.parentregno, tblparent.parentimg,
                    tblparent.fname, tblparent.mname, tblparent.lname FROM tblclass_parent
                    INNER JOIN tblparent ON tblclass_parent.parentregno = tblparent.parentregno
                    WHERE studregno = :studregno';
        $stmt = $conn->prepare($fetchparents);
        $stmt->execute(array(
            ':studregno' => $studregno,
        ));

        if ($stmt->rowCount() > 0) {
            echo '<div class="listblock">';
            echo '<table class="parentlist table table-striped">';
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<th>';
                echo "<a href=\"parentprofile.php?parentregno=$result[parentregno]\" class=\"btn btn-link text-capitalize\">";
                echo $result['fname'] . ' ' . $result['mname'] . ' ' . $result['lname'];
                echo "</a>";
                echo '</th>';
                echo '<th>';
                if ($result['parentimg'] !== null) {
                    echo "<img src=\"profilepics/$result[parentimg]\" class='profiledefault2 img-rounded'>";
                } else {
                    echo '<img src="img/profiledefault.jpg" class="profiledefault2 img-rounded">';
                }
                echo '</th>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';

        }
    }else{
        echo '';
    }
    ?>
</div>


</div>




<!-- Footer -->
<?php
date_default_timezone_set('asia/manila');
$date = new DateTime('now');
$copyrightyear = date('Y');
?>
<div class="panel-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright text-success">Copyright &copy; University Corner <?php echo $copyrightyear?></span>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
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



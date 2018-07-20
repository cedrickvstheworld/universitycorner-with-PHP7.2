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
?>

<?php
session_start();
if (isset($_SESSION['user3']))
{
    echo '';

}else{
    header('location:loginpage.php');
}


?>
<?php
if(isset($_GET['studregno'])){
    echo '';
    $studregno=$_GET['studregno'];
}else{
    header('location:parentindex.php');
}
?>
<?php

$username=$_SESSION['user3'];
$searchid = 'SELECT *FROM tblparent WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblparent = $query->fetch();
    $parentregno = $tblparent[0];

}
?>
<?php
$fetchstudinfo='SELECT *FROM tblstudent WHERE studregno = :studregno';
$stmt=$conn->prepare($fetchstudinfo);
$stmt->execute(array(
   ':studregno'=>$studregno,
));
if($stmt->rowCount()>0){
    $tblstudent=$stmt->fetch(PDO::FETCH_ASSOC);
    $studname=$tblstudent['fname'].' '.$tblstudent['mname'].' '.$tblstudent['lname'];
    $stucode=$tblstudent['studcode'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title id="parentview">University Corner</title>
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
                <a class="navbar-brand text-primary" href="#parentview">University Corner</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="parentindex.php"><img class="img-responsive" src="images/house-hi.png"></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="pagefont dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="img-responsive" src="images/cog.png"></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" href="#changepmodalparent">Change Password</a></li>
                            <li><a data-toggle="modal" href="#changeppmodal">Change Profile Photo</a></li>
                            <li><a data-toggle="modal" href="#editaccountmodal">Edit Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php">Log-out</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<!--top navbar-->


<div class="bodyscroll">
    <div class="pagebody pagefont">

        <div class="container">
            <div class="container-fluid">
                <div class="col-lg-6">
                 <h3 class="text-capitalize text-info">
                     <!--profile picture-->
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
                             echo "<img src=\"profilepics/$img\" class='profiledefault3 img-rounded'>";
                         }else{
                             echo '<img src="img/profiledefault.jpg" class="profiledefault3 img-rounded">';
                         }
                     }
                     ?>
                     <!--profile picture-->
                     <?php
                     echo $studname;
                     ?>
                 </h3>
                </div>

                <div class="col-lg-6 text-right">
                    <h4 class="text-capitalize">
                        <br>
                        <?php
                        echo 'Student Code: '.$stucode;
                        ?>
                    </h4>
                </div>
                <div class="col-lg-12 container-fluid">

                    <div id="exTab3" class="options">
                        <ul  class="nav nav-pills">
                            <li class="active"><a href="#attendance" data-toggle="tab" class="tabtext">Attendance</a>
                            </li>
                            <li><a href="#3b" data-toggle="tab" class="tabtext">Classes</a>
                            </li>
                        </ul>

                        <div class="tab-content clearfix well">
                            <div class="tab-pane active" id="attendance">
                                <div class="content2">
                                    <div class="col-sm-12 attendancehistory">
                                        <label>Attendance History</label>
                                        <?php
                                        $fetchattendance='SELECT tblclass.subjectdesc,tblattendance.studregno,tblattendance.attendancedate,
                                          tblattendance.attendancetime,tblattendance.stat FROM tblattendance
                                          INNER JOIN tblclass ON tblattendance.classid = tblclass.classid
                                          WHERE studregno = :studregno';
                                        $query4343=$conn->prepare($fetchattendance);
                                        $query4343->execute(array(
                                            ':studregno'=>$studregno,
                                        ));

                                        if($query4343->rowCount()>0){

                                            echo '<table id="table_id8" class="display table" cellspacing="0" width="100%">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th class="text-info">Subject</th>';
                                            echo '<th class="text-info">Date</th>';
                                            echo '<th class="text-info">Time</th>';
                                            echo '<th class="text-info">Status</th>';
                                            echo '</tr>';
                                            echo '</thead>';

                                            echo '<tbody>';
                                            while ($result=$query4343->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
                                                echo '<td>'.$result['subjectdesc'].'</td>';
                                                echo '<td>'.$result['attendancedate'].'</td>';
                                                echo '<td>'.$result['attendancetime'].'</td>';
                                                echo '<td>'.$result['stat'].'</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="3b">
                                <div class="content2">
                                    <label>Class Lists</label>
                                    <?php
                                    $fetchclasslists='SELECT tblclass_student.studregno, tblclass.classid, tblclass.subjectdesc, tblclass.insregno,
                                                      tblclass.subjectcode FROM tblclass_student 
                                                      INNER JOIN tblclass ON tblclass_student.classid = tblclass.classid
                                                      WHERE studregno = :studregno';
                                    $query4343=$conn->prepare($fetchclasslists);
                                    $query4343->execute(array(
                                        ':studregno'=>$studregno,
                                    ));

                                    if($query4343->rowCount()>0){

                                        echo '<table id="table_id78" class="display table" cellspacing="0" width="100%">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th class="text-info">Subject</th>';
                                        echo '<th class="text-info">Description</th>';
                                        echo '<th class="text-info">Instructor</th>';
                                        echo '</tr>';
                                        echo '</thead>';

                                        echo '<tbody>';
                                        while ($result=$query4343->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                            echo '<td>'.$result['subjectdesc'].'</td>';
                                            echo '<td>'.$result['subjectcode'].'</td>';
                                            echo '<td>';
                                            echo "<a href=\"instructorprofile2.php?insregno=$result[insregno]\" class='btn-link text-info text-capitalize'>";
                                            $getinstructorname='SELECT *FROM tblinstructor WHERE insregno = :insregno';
                                            $stmt=$conn->prepare($getinstructorname);
                                            $stmt->execute(array(
                                               'insregno'=>$result['insregno'],
                                            ));
                                            if($stmt->rowCount()>0){
                                                $tblinstructor=$stmt->fetch(PDO::FETCH_ASSOC);
                                                $insname=$tblinstructor['fname'].' '.$tblinstructor['lname'];
                                                echo $insname;
                                            }
                                            echo '</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>';
                                        echo '</table>';
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<!--change profile photo modal-->
<div id="changeppmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="parentindex.php" enctype="multipart/form-data" method="post">
            <h3 class="modal-header">Select New Profile Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                </div>
                <div class="col-lg-6">

                    <img id="blah" src="<?php

                    $retrieveimg = 'SELECT *FROM tblparent WHERE parentregno = :parentregno';
                    $stmt = $conn->prepare($retrieveimg);
                    $stmt->execute(array(
                        ':parentregno' => $parentregno,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblparent = $stmt->fetch();
                        $img = $tblparent['parentimg'];
                        if ($img !== null) {
                            echo "profilepics/$img";
                        }else{
                            echo 'img/profiledefault.jpg';
                        }
                    }

                    ?>" class="profiledefault img-rounded">
                    <br>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn-success btn" disabled id="upload" name="upload" value="Change">
            </div>
            <?php
            //change profile pic
            if(isset($_POST['upload'])){
                $image=$_FILES['profilepic']['name'];
                $temp_dir=$_FILES['profilepic']['tmp_name'];
                $imageType = $_FILES["profilepic"]["type"];

                if (substr($imageType, 0, 5) === "image") {
                    $upload_dir='profilepics/';
                    $imgExt=strtolower(pathinfo($image,PATHINFO_EXTENSION));
                    $picProfile=$username.'.'.$imgExt;
                    move_uploaded_file($temp_dir, $upload_dir.$picProfile);
                    $uploadimg="UPDATE tblparent SET parentimg = :img WHERE parentregno = :parentregno";
                    $stmt= $conn->prepare($uploadimg);
                    $stmt->execute(array(
                        ':img'=>$picProfile ,
                        ':parentregno'=> $parentregno,
                    ));
                    if ($stmt) {
                        echo '<script>window.top.location = "parentindex.php";</script>';
                    }
                } else {
                    echo '<script>alert("Invalid File Type")</script>';
                }
            }
            //change profile pic
            ?>
        </form>
    </div>
</div>


<!--change profile photo modal-->

<!--changepmodal-->
<div id="changepmodalparent" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod0();" title="Close" class="close">X</a>
        <h3 class="modal-header">Change Password</h3>
        <form action="editparentaccount.php" method="post">
            <input type="hidden" id="parentregnop" name="parentregnop" value="<?php echo $parentregno; ?>">
            <input type="password" class="maxlen40 form-control" id="currentp" name="currentp" placeholder="Current Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="newp" name="newp" placeholder="New Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="confirmnewp" name="confirmnewp" placeholder="Confirm New Password" required>
            <br>
            <div class="text-right">
                <button id= "show_password" class="btn btn-secondary" type="button">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
                <input type="button" class="btn btn-success" onclick="fncchangepparent();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod89();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="parentregnoup" name="parentregnoup" value="<?php echo $parentregno; ?>">
            <div class="col-lg-4">
                <input type="text" class="letters maxlen30 form-control" id="nfname" name="nfname" placeholder="First Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="letters maxlen30 form-control" id="nmname" name="nmname" placeholder="Middle Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="letters maxlen30 form-control" id="nlname" name="nlname" placeholder="Last Name">
            </div>
            <br>
            <br>
            <br>
            <input type="text" class="maxlen70 form-control" id="naddress" name="naddress" placeholder="Address">
            <br>
            <div class="col-lg-12">
                <label>Birthday</label>
                <select id="nbirthmonth" name="nbirthmonth" class="input-sm">
                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>
                </select>
                <select id="nbirthday" name="nbirthday" class="input-sm">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>13</option>
                    <option>14</option>
                    <option>15</option>
                    <option>16</option>
                    <option>17</option>
                    <option>18</option>
                    <option>19</option>
                    <option>20</option>
                    <option>21</option>
                    <option>22</option>
                    <option>23</option>
                    <option>24</option>
                    <option>25</option>
                    <option>26</option>
                    <option>27</option>
                    <option>28</option>
                    <option>29</option>
                    <option>30</option>
                    <option>31</option>
                </select>
                <input type="number" class="input-sm" min="1960" max="2500" id="nbirthyear" name="nbirthyear" placeholder="Year" required>

            </div>
            <br><br><br>
            <div class="col-lg-4">
                <input type="text" class="maxlen11 form-control" id="ncontact" name="ncontact" placeholder="Contact">
            </div>
            <div class="col-lg-8 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfo56();" id="updateinfo" name="updateinfo" value="Update">
            </div>
            <br><br>
            <div id="show2"></div>
        </form>

    </div>
</div>

<!--editaccountmodal-->

<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="cediescripts.js"></script>
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="DataTables-1.10.16/media/js/jquery.dataTables.min.js"></script>
<script src="DataTables-1.10.16/media/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
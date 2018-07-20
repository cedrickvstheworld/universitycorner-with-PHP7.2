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
if (isset($_SESSION['user2']))
{
    echo '';

}else{
    header('location:loginpage.php');
}


?>

<?php

$username=$_SESSION['user2'];
$studregno='';
$searchid = 'SELECT *FROM tblstudent WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblstudent = $query->fetch();
    $studregno = $tblstudent[0];

}
?>

<!DOCTYPE html>
<html>
<head>
    <title id="studentview">University Corner</title>
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
                <a class="navbar-brand text-primary" href="#studentview">University Corner</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="studentindex.php"><img class="img-responsive" src="images/house-hi.png"></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="pagefont dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="img-responsive" src="images/cog.png"></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" href="#changepmodal">Change Password</a></li>
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
                    <?php
                    echo '<h3 class="text-info service-heading container">';
                    if (isset($_GET['classcode'])){
                        $subjectdesc='';
                        $classid='';
                        $query='SELECT *FROM tblclass WHERE classcode = :classcode';
                        $stmt= $conn->prepare($query);
                        $stmt->execute(array(
                            ':classcode'=>$_GET['classcode'],
                        ));
                        if($stmt->rowCount()>0){
                            $tblclass=$stmt->fetch();
                            $subjectdesc = $tblclass[6];
                            $classid = $tblclass[0];
                            $subjectcode = $tblclass[1];
                            $classcode = $tblclass[5];
                            $insregno = $tblclass[2];

                        }
                        echo $subjectdesc;
                    }else{
                        header ('location:loginpage.php');
                    }
                    echo '</h3>';

                    $fetchinstructorname='SELECT *FROM tblinstructor WHERE insregno = :insregno';
                    $stmt=$conn->prepare($fetchinstructorname);
                    $stmt->execute(array(
                       ':insregno'=>$insregno,
                    ));

                    if($stmt->rowCount()>0){
                        $tblinstructor=$stmt->fetch(PDO::FETCH_ASSOC);
                        $insname=$tblinstructor['fname'].' '.$tblinstructor['mname'].' '.$tblinstructor['lname'];
                    }
                    ?>
                    <h6 class="text-default text-capitalize">
                        <?php
                        if(isset($_GET['classcode'])){
                            echo  'Instructor: ';
                            echo "<a href=\"instructorprofile.php?insregno=$insregno\" class='btn-link'>"; echo $insname ; echo '</a>';
                        }else{
                            echo '';
                        }
                        ?></h6>
                </div>

                <div class="col-lg-6 text-right">
                    <h4 class="text-default">
                        <?php
                        if (isset($_GET['classcode'])){
                            echo $subjectcode;
                        }else{
                            echo '';
                        }
                        ?></h4>
                    <h5 class="text-default">
                        <?php
                        if(isset($_GET['classcode'])){
                            $classcode=$_GET['classcode'];
                            echo  $classcode;
                        }else{
                            echo '';
                        }
                        ?></h5>
                </div>
                <div class="col-lg-12 container-fluid">

                    <div id="exTab3" class="options">
                        <ul  class="nav nav-pills">
                            <li class="active"><a href="#attendance" data-toggle="tab" class="tabtext">Attendance</a>
                            </li>
                            <li><a href="#3b" data-toggle="tab" class="tabtext">Report Card</a>
                            </li>
                        </ul>

                        <div class="tab-content clearfix well">
                            <div class="tab-pane active" id="attendance">
                                <div class="content">
                                    <div class="col-sm-12 attendancehistory">
                                        <label>Attendance History</label>
                                        <?php
                                        $fetchattendancehistory='SELECT tblstudent.studregno,tblstudent.fname,tblstudent.lname,tblattendance.attendancedate,
                                                             tblattendance.attendancetime,tblattendance.stat,tblattendance.classid 
                                                             FROM tblstudent INNER JOIN tblattendance ON tblstudent.studregno = tblattendance.studregno
                                                             WHERE classid = :classid AND tblstudent.studregno = :studregno  ORDER BY attendancedate DESC, attendancetime DESC';
                                        $query4343=$conn->prepare($fetchattendancehistory);
                                        $query4343->execute(array(
                                            ':classid'=> $classid,
                                            ':studregno'=>$studregno,
                                        ));

                                        if($query4343->rowCount()>0){

                                            echo '<table id="table_id8" class="display table" cellspacing="0" width="100%">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th class="text-info">Date</th>';
                                            echo '<th class="text-info">Time</th>';
                                            echo '<th class="text-info">Status</th>';
                                            echo '</tr>';
                                            echo '</thead>';

                                            echo '<tbody>';
                                            while ($result=$query4343->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<tr>';
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
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="col-lg-9">
                                            <h5 class="text-success">Grading Settings</h5>
                                            <?php
                                            if(isset($classid)){
                                                $fetchgs='SELECT *FROM tblgradingsetting WHERE classid= :classid';
                                                $query7680=$conn->prepare($fetchgs);
                                                $query7680->execute(array(
                                                    ':classid'=>$classid,
                                                ));
                                                if($query7680->rowCount()>0) {
                                                    $result2= $query7680->fetch(PDO::FETCH_ASSOC);
                                                    echo '<table class="text-center well">';
                                                    echo '<th>';
                                                    echo '<tr class="text-info">';
                                                    echo '<td style="width: 140px;">Attendance</td>';
                                                    echo '<td style="width: 140px;">Assignment</td>';
                                                    echo '<td style="width: 140px;">Seatwork</td>';
                                                    echo '<td style="width: 140px;">Quiz</td>';
                                                    echo '<td style="width: 140px;">Term Exam</td>';
                                                    echo '<td style="width: 140px;">Project</td>';
                                                    echo '</tr>';
                                                    echo '</th>';
                                                    echo '<tb>';
                                                    echo '<tr>';
                                                    echo '<td>';
                                                    echo $result2['attendance']*100; echo '%';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    echo $result2['assignment']*100; echo '%';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    echo $result2['seatwork']*100; echo '%';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    echo $result2['quiz']*100; echo '%';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    echo $result2['termexam']*100; echo '%';
                                                    echo '</td>';
                                                    echo '<td>';
                                                    echo $result2['project']*100; echo '%';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                    echo '</tb>';
                                                    echo '</table>';
                                                }else{
                                                    echo '<h5 class="text-info">Unset</h5>';
                                                }
                                            }
                                            ?>

                                            <h5 class="text-success">Current ScoreBoard</h5>
                                            <?php
                                            if(isset($classid)){
                                                $fetchgs='SELECT *FROM tblscore WHERE classid= :classid';
                                                $query7680=$conn->prepare($fetchgs);
                                                $query7680->execute(array(
                                                    ':classid'=>$classid,
                                                ));
                                                if($query7680->rowCount()>0) {
                                                    echo '<table class="text-center well" border="1">';
                                                    echo '<th>';
                                                    echo '<tr class="text-info">';
                                                    echo '<td style="width: 90px;">Attendance</td>';
                                                    echo '<td style="width: 90px;">Assignment</td>';
                                                    echo '<td style="width: 90px;">Seatwork</td>';
                                                    echo '<td style="width: 90px;">Quiz</td>';
                                                    echo '<td style="width: 90px;">Term Exam</td>';
                                                    echo '<td style="width: 90px;">Project</td>';
                                                    echo '<td style="width: 90px;">Term</td>';
                                                    echo '</tr>';
                                                    echo '</th>';
                                                    echo '<tbody>';
                                                    while ($result6 = $query7680->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<tr>';
                                                        echo '<td>';
                                                        echo $result6['attendance'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['assignment'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['seatwork'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['quiz'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['termexam'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['project'] . ' items';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        echo $result6['term'];
                                                        echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                    echo '</tbody>';
                                                    echo '</table>';
                                                }
                                                else{
                                                    echo '<h5 class="text-info">Unset</h5>';
                                                }
                                            }
                                            ?>
                                            <?php
                                            $fetchtermp='SELECT *FROM tbltermpercentage WHERE classid = :classid';
                                            $query432=$conn->prepare($fetchtermp);
                                            $query432->execute(array(
                                                ':classid'=>$classid,
                                            ));
                                            if($query432->rowCount()>0){
                                                $tbltermp=$query432->fetch();
                                                $mmidterm = $tbltermp[1];
                                                $mfinterm = $tbltermp[2];
                                                $pgrade = $tbltermp[4];
                                                $midtermp=$mmidterm*100;
                                                $fintermp=$mfinterm*100;
                                                $passinggrade=$pgrade*100;
                                            }
                                            ?>
                                            <label class="text-info">Passing Grade: </label>
                                            <h4><?php
                                                if(isset($passinggrade)){
                                                    echo $passinggrade.'%';
                                                }else{
                                                    echo 'unset';
                                                }
                                                ?></h4><br>
                                        </div>
                                        <div class="col-lg-3 text-right">
                                            <label class="text-success">Term Percentages</label><br>
                                            <label class="">Mid Term:</label><h5><?php
                                                if(isset($midtermp)){
                                                    echo $midtermp.'%';
                                                }else{
                                                    echo 'unset';
                                                }
                                                ?></h5><br>
                                            <label class="">Final Term:</label><h5><?php
                                                if(isset($fintermp)){
                                                    echo $fintermp.'%';
                                                }else{
                                                    echo 'unset';
                                                }
                                                ?></h5>
                                        </div>
                                        <div class="col-lg-12">
                                            <?php
                                            $fetchstudrecord='SELECT tblstudent.studregno,tblstudent.fname, tblstudent.lname,tblevaluatedgrade.classid,
                                                        tblevaluatedgrade.midterm,tblevaluatedgrade.finalterm, tblevaluatedgrade.remarks,
                                                        tblevaluatedgrade.finalgrade,tblevaluatedgrade.equivalent FROM tblstudent INNER JOIN
                                                        tblevaluatedgrade ON tblstudent.studregno = tblevaluatedgrade.studregno 
                                                        WHERE classid = :classid AND tblstudent.studregno = :studregno';
                                            $query309=$conn->prepare($fetchstudrecord);
                                            $query309->execute(array(
                                                ':classid'=>$classid,
                                                ':studregno'=>$studregno,
                                            ));
                                            if($query309->rowCount()>0){

                                                echo '<div class="generalrecordheader">';
                                                echo '<table class="table">';
                                                echo '<tr>';
                                                echo '<th>Reg no</th>';
                                                echo '<th>Name</th>';
                                                echo '<th></th>';
                                                echo '<th>Mid Term</th>';
                                                echo '<th>Final Term</th>';
                                                echo '<th>Remarks</th>';
                                                echo '<th>Final Grade</th>';
                                                echo '<th>Equivalent</th>';
                                                echo '</tr>';
                                                echo '</table>';
                                                echo '</div>';


                                                echo '<div class="">';
                                                echo '<table class="table table-responsive table-striped">';
                                                while ($result55=$query309->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<tr>';
                                                    echo '<td style="width: 110px">';
                                                    echo $result55['studregno'];
                                                    echo '</td>';
                                                    echo '<td style="width: 130px">';
                                                    echo $result55['fname'];
                                                    echo ' ';
                                                    echo $result55['lname'];
                                                    echo '</td>';
                                                    echo '<td style="width: 140px">';
                                                    echo $result55['midterm'].'%';
                                                    echo '</td>';
                                                    echo '<td style="width: 160px">';
                                                    echo $result55['finalterm'].'%';
                                                    echo '</td>';
                                                    echo '<td style="width: 130px">';
                                                    echo $result55['remarks'];
                                                    echo '</td>';
                                                    echo '<td style="width: 170px">';
                                                    echo $result55['finalgrade'].'%';
                                                    echo '</td>';
                                                    echo '<td style="width: 140px">';
                                                    echo $result55['equivalent'];
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }

                                                echo '</table>';
                                                echo '</div>';

                                            }else{
                                                echo 'No Records';
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
    </div>
</div>



<!--changepmodal-->
<div id="changepmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod4();" title="Close" class="close">X</a>
        <h3 class="modal-header">Change Password</h3>
        <form action="editstudentaccount.php" method="post">
            <input type="hidden" id="studregnop" name="studregnop" value="<?php echo $studregno; ?>">
            <input type="password" class="form-control" id="currentp" name="currentp" placeholder="Current Password" required>
            <br>
            <input type="password" class="form-control" id="newp" name="newp" placeholder="New Password" required>
            <br>
            <input type="password" class="form-control" id="confirmnewp" name="confirmnewp" placeholder="Confirm New Password" required>
            <br>
            <div class="text-right">
                <input type="button" class="btn btn-success" onclick="fncchangepstud();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--change profile photo modal-->
<div id="changeppmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="studentview.php" enctype="multipart/form-data" method="post">
            <h3 class="modal-header">Select New Profile Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                </div>
                <div class="col-lg-6">

                    <img id="blah" src="<?php

                    $retrieveimg = 'SELECT *FROM tblstudent WHERE studregno = :studregno';
                    $stmt = $conn->prepare($retrieveimg);
                    $stmt->execute(array(
                        ':studregno' => $studregno,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblstudent = $stmt->fetch();
                        $img = $tblstudent['studentimg'];
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
                    $uploadimg="UPDATE tblstudent SET studentimg = :img WHERE studregno = :studregno";
                    $stmt= $conn->prepare($uploadimg);
                    $stmt->execute(array(
                        ':img'=>$picProfile ,
                        ':studregno'=> $studregno,
                    ));
                    if ($stmt) {
                        echo '<script>window.top.location = "studentindex.php";</script>';
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

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod9();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editstudentaccount.php" method="post">
            <input type="hidden" id="studregnop" name="studregnop" value="<?php echo $studregno; ?>">
            <div class="col-lg-4">
                <input type="text" class="form-control" id="nfname" name="nfname" placeholder="First Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="nmname" name="nmname" placeholder="Middle Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="nlname" name="nlname" placeholder="Last Name">
            </div>
            <br>
            <br>
            <br>
            <input type="text" class="form-control" id="naddress" name="naddress" placeholder="Address">
            <br>
            <div class="col-lg-12">
                <label">Birthday</label>
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
                <input type="number" class="form-control" id="ncontact" name="ncontact" placeholder="Contact">
            </div>
            <div class="col-lg-4">
                <input type="number" class="form-control" id="ngcontact" name="ngcontact" placeholder="Guardian Contact">
            </div>
            <div class="col-lg-4 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfostud();" id="updateinfo" name="updateinfo" value="Update">
            </div>
            <br><br>
            <div id="show2"></div>
        </form>

    </div>
</div>

<!--editaccountmodal-->



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
<script src="DataTables-1.10.16/media/js/jquery.dataTables.min.js"></script>
<script src="DataTables-1.10.16/media/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
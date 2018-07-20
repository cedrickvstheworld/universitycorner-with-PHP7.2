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
if (isset($_SESSION['user']))
{
    echo '';

}else{
    header('location:loginpage.php');

}
?>

<?php
$username=$_SESSION['user'];
$insregno='';
$searchid = 'SELECT *FROM tblinstructor WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblinstructor = $query->fetch();
    $insregno = $tblinstructor[0];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title id="classplatform">University Corner</title>
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
                <a class="navbar-brand text-primary" href="#classplatform">University Corner</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="educatorindex.php"><img class="img-responsive" src="images/house-hi.png"></a></li>
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

<!--main body-->
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
                            $subjectdesc=$tblclass[6];
                            $classid=$tblclass[0];
                            $subjectcode=$tblclass[1];
                            $classcode=$tblclass[5];

                        }
                        echo $subjectdesc;
                    }else{
                        header ('location:loginpage.php');
                    }
                    echo '</h3>';
                    ?>
                </div>

                <div class="col-lg-6 text-right">
                    <h5 class="text-default">
                        <?php
                        if (isset($_GET['classcode'])){
                            echo $subjectcode;
                        }else{
                            echo '';
                        }
                        ?></h5>
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
            </div>
            <div class="col-lg-9 container-fluid">

                <div id="exTab3" class="options">
                    <ul  class="nav nav-pills">
                        <li id="l1" class="active"><a href="#attendance" data-toggle="tab" class="tabtext">Attendance</a>
                        </li>
                        <li><a href="#3b" data-toggle="tab" class="tabtext">Grade Sheet</a>
                        </li>
                        <li><a href="#4b" data-toggle="tab" class="tabtext">Finalization</a>
                        </li>
                        <li id="l5" class=""><a href="#5b" data-toggle="tab" class="tabtext">General Records</a>
                        </li>
                        <li><a href="#6b" data-toggle="tab" class="tabtext">Configurations</a>
                        </li>
                    </ul>

                   <div class="tab-content clearfix well">
                   <div class="tab-pane active" id="attendance">
                            <div class="content">
                                <div class="col-sm-3">

                                    <!--absent or present=-->
                                <form id="attendance" action="classaction.php" method="post">
                                   <input type="hidden" id="classid" value="<?php echo $classid;?>">
                                    <input type="hidden" id="classcode" value="<?php echo $classcode;?>">
                                    <input type="hidden" id="subject" value="<?php echo $subjectdesc;?>">
                                    <label>Student Reg No.</label>
                                    <br>
                                    <input type="text" class="mobile maxlen6 form-control" onchange="attendancebtns();" id="studregno" name="studregno" placeholder="">
                                    <br>
                                    <input type="button" class="btn btn-success" id="submitpresent" onclick="fncPresent();" disabled name="present" value="Present">
                                    <input type="button" class="btn btn-danger" id="submitabsent" onclick="fncAbsent();"  disabled name="absent" value="Absent">
                                    <br>
                                    <br>
                                    <div class="text-center">
                                    <input type="button" class="btn btn-warning" id="submitlate" onclick="fncLate();"  disabled name="late" value="Late">
                                    </div>
                                    <br>
                                    <br>
                                    <div id="att"></div>
                                </form>
                                    <!--absent or present=-->
                                </div>

                                <div class="col-sm-9">
                                    <label>Attendance History</label>
                                    <?php
                                    $fetchattendancehistory='SELECT tblstudent.studregno,tblstudent.fname,tblstudent.lname,tblattendance.attendancedate,
                                                             tblattendance.attendancetime,tblattendance.stat,tblattendance.classid 
                                                             FROM tblstudent INNER JOIN tblattendance ON tblstudent.studregno = tblattendance.studregno
                                                             WHERE classid = :classid   ORDER BY attendancedate DESC, attendancetime DESC';
                                    $query4343=$conn->prepare($fetchattendancehistory);
                                    $query4343->execute(array(
                                       ':classid'=> $classid,
                                    ));

                                    if($query4343->rowCount()>0){


                                        echo '<table id="table_id" class="display table table-striped" cellspacing="0" width="100%">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th class="text-info">R.N.</th>';
                                        echo '<th class="text-info">Name</th>';
                                        echo '<th class="text-info">Date</th>';
                                        echo '<th class="text-info">Time</th>';
                                        echo '<th class="text-info">Status</th>';
                                        echo '</tr>';
                                        echo '</thead>';

                                        echo '<tbody>';
                                        while ($result=$query4343->fetch(PDO::FETCH_ASSOC)) {

                                            echo '<tr>';
                                            echo '<td>'.$result['studregno'].'</td>';
                                            echo '<td>';
                                            echo $result['fname']; echo ' ';
                                            echo $result['lname'];
                                            echo '</td>';
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

                                <!--validatestudreg-->
                                <input type="hidden" id="vclassid" name="vclassid" value="<?php echo $classid;?>">
                                <form id="validatestudreg" action="gsprocessing.php" method="post">
                                <div class="col-lg-3">
                                    <label>Student Reg No.</label>
                                    <br>
                                    <input type="text" class="mobile maxlen6 form-control" id="vstudregno" name="vstudregno" placeholder="">
                                    <br>
                                    <input type="button" class="btn btn-info" id="vvalidate" name="vvalidate" onclick="fncvalidate();" value="Validate">
                                    <br>
                                    <br>
                                    <div>
                                        <h4 class="text-success" id="printinfo"></h4>
                                    </div>
                                </div>
                                </form>
                                <!--validatestudreg-->

                                <!--evaluate-->

                                <div id="gradingblock" style="display: none">
                                <form id="evaluategrade" action="gsprocessing.php" method="post">
                                <div class="col-lg-9">
                                    <div>
                                        <label class="text-success">Select Term</label>
                                        <select onchange="fterm();" id="selectterm" name="selectterm" class="input-sm">
                                            <option>Mid Term</option>
                                            <option>Final Term</option>
                                        </select>
                                    </div>
                                    <?php
                                        $retrievescoring = 'SELECT *FROM tblscore WHERE classid = :classid AND term = :term';
                                        $queryrt = $conn->prepare($retrievescoring);
                                        $queryrt->execute(array(
                                            ':classid' => $classid,
                                            ':term' => 'Mid Term',
                                        ));
                                        if ($queryrt->rowCount() > 0) {
                                            $tblscore = $queryrt->fetch();
                                              $attendancev = $tblscore[1];
                                              $assignmnentv = $tblscore[2];
                                              $seatworkv = $tblscore[3];
                                              $quizv = $tblscore[4];
                                              $termexamv = $tblscore[5];
                                              $projectv = $tblscore[6];
                                        } else {
                                            $attendancev = '';
                                            $assignmnentv = '';
                                            $seatworkv = '';
                                            $quizv = '';
                                            $termexamv = '';
                                            $projectv = '';
                                    }
                                    ?>
                                    <h4><small>Input the scores in the corresponding category to evaluate the average based on the class grading settings (e.g. attained score / total).</small></h4>
                                </div>
                                 <div class="col-lg-3">
                                     <br>
                                    <label class="text-info">Attendance:</label><br>
                                     <input type="number" class="score input-sm" id="attend" name="attend" placeholder=""> /
                                     <input type="number" class="score input-sm" id="attend2" name="attend2" disabled value="<?php echo $attendancev; ?>" placeholder=""><br>
                                    <label class="text-info">Assignment:</label><br>
                                    <input type="number" class="score input-sm" id="assignment" name="assignment" placeholder=""> /
                                     <input type="number" class="score input-sm" id="assignment2" name="assignment2" disabled value="<?php echo $assignmnentv; ?>" placeholder="">
                                     <br>
                                     <br>
                                     <div id="averagehere" style="display: none;">
                                     <h3 class="text-success" id="printave"></h3>
                                     </div>
                                </div>
                                <div class="col-lg-3">
                                    <br>
                                    <label class="text-info">Seatwork:</label><br>
                                    <input type="number" class="score input-sm" id="seatwork" name="seatwork" placeholder=""> /
                                    <input type="number" class="score input-sm" id="seatwork2" name="seatwork2" disabled value="<?php echo $seatworkv; ?>" placeholder=""><br>
                                    <label class="text-info">Quiz:</label><br>
                                    <input type="number" class="score input-sm" id="quiz" name="quiz" placeholder=""> /
                                    <input type="number" class="score input-sm" id="quiz2" name="quiz2" disabled value="<?php echo $quizv; ?>" placeholder="">
                                </div>
                                <div class="col-lg-3">
                                    <br>
                                    <label class="text-info">Project:</label><br>
                                    <input type="number" class="score input-sm" id="project" name="project" placeholder=""> /
                                    <input type="number" class="score input-sm" id="project2" name="project2" disabled value="<?php echo $projectv; ?>" placeholder=""><br>
                                    <label class="text-info">Term Examination:</label><br>
                                    <input type="number" class="score input-sm" id="termexam" name="termexam" placeholder=""> /
                                    <input type="number" class="score input-sm" id="termexam2" name="termexam2" disabled value="<?php echo $termexamv; ?>" placeholder="">
                                </div>
                                    <div class="container col-lg-12 text-right">
                                        <input type="button" class="btn btn-danger" id="cancel" name="cancel" onclick="fnccancel();" value="Cancel">
                                        <input type="button" class="btn btn-success" id="evaluate" name="evaluate" onclick="fncevaluate();" value="Evaluate">
                                    </div>
                                </form>
                                </div>
                                <!--evaluate-->
                            </div>
                   </div>

                       <div class="tab-pane" id="4b">

                           <div class="content">

                               <!--validatestudreg-->
                               <input type="hidden" id="fclassid" name="fclassid" value="<?php echo $classid;?>">
                               <form id="fvalidatestudreg" action="finalization.php" method="post">
                                   <div class="col-lg-3">
                                       <label>Student Reg No.</label>
                                       <br>
                                       <input type="text" class="mobile maxlen6 form-control" id="fstudregno" name="fstudregno" placeholder="">
                                       <br>
                                       <input type="button" class="btn btn-info" id="fvalidate" name="fvalidate" onclick="fncfvalidate();" value="Validate">
                                       <br>
                                       <br>
                                       <div>
                                           <h4 class="text-success" id="fprintinfo"></h4>
                                       </div>
                                   </div>

                               <!--validatestudreg-->

                               <!--finalize grades-->
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
                                   <div class="col-lg-9">
                                       <div id="finalizedgradeblock" style="display: none;">
                                       <div class="col-lg-7">
                                           <label class="text-success">Term Results</label><br><br>
                                       <label class="text-info">Mid Term:</label><br>
                                           <input type="text" id="midres" name="midres" class="score input-sm" disabled value="" placeholder="">%<br>
                                       <label class="text-info">Final Term:</label><br>
                                           <input type="text" id="finres" name="finres" class="score input-sm" disabled value="" placeholder="">%<br>
                                           <h4><small>The Above results was assessed based on your grading settings.</small></h4>
                                           <h4><small class="text-danger">If the student doesn't comply with the class requirements:</small></h4>
                                           <!--drop and inc-->
                                           <input type="button" class="btn btn-warning" name="inc" id="inc" onclick="fncinc();" value="Incomplete Grade">
                                           <br><small class="text-danger">or</small><br>
                                           <input type="button" class="btn btn-danger" name="drop" id="drop" onclick="fncdrop();" value="Drop Student">
                                           <!--drop and inc-->
                                       </div>
                                       <div class="col-lg-5">
                                           <label class="text-info">Term Percentages:</label><br><br>
                                           <input type="hidden" id="midtermp" name="midtermp" value="<?php
                                           if(isset($midtermp)){
                                               echo $midtermp;
                                           }else{
                                               echo 0;
                                           }
                                           ?>">
                                           <input type="hidden" id="fintermp" name="fintermp" value="<?php
                                           if(isset($fintermp)){
                                               echo $fintermp;
                                           }else{
                                               echo 0;
                                           }
                                           ?>">
                                           <label class="">Mid Term:</label><h4><?php
                                               if(isset($midtermp)){
                                                   echo $midtermp.'%';
                                               }else{
                                                   echo 0;
                                               }
                                               ?></h4><br>
                                           <label class="">Final Term:</label><h4><?php
                                               if(isset($fintermp)){
                                                   echo $fintermp.'%';
                                               }else{
                                                   echo 0;
                                               }
                                               ?></h4><br>
                                           <div class="text-right">
                                           <input type="button" class="btn btn-danger" id="cancel2" name="cancel2" onclick="fnccancel2();" value="Cancel">
                                           <input type="button" class="btn btn-success" name="finalize" id="finalize" onclick="finalizegrade();" value="Finalize"><br><br>
                                               <div id="resulthere" style="display: none;">
                                                   <h5 class="text-info" id="finalresult"></h5>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!--finalize grades-->
                               </form>
                           </div>
                       </div>

                       <!--general records-->
                       <div class="tab-pane" id="5b">

                           <div class="content">
                               <div class="container-fluid">
                                   <div class="col-lg-12">
                                       <?php
                                       $fetchstudrecord='SELECT tblstudent.studregno,tblstudent.fname, tblstudent.lname,tblevaluatedgrade.classid,
                                                        tblevaluatedgrade.midterm,tblevaluatedgrade.finalterm, tblevaluatedgrade.remarks,
                                                        tblevaluatedgrade.finalgrade,tblevaluatedgrade.equivalent FROM tblstudent INNER JOIN
                                                        tblevaluatedgrade ON tblstudent.studregno = tblevaluatedgrade.studregno WHERE classid = :classid';
                                       $query309=$conn->prepare($fetchstudrecord);
                                       $query309->execute(array(
                                               ':classid'=>$classid,
                                       ));
                                       if($query309->rowCount()>0){

                                           echo '<table id="table_id3" class="display table table-striped" cellspacing="0" width="100%">';
                                           echo '<thead>';
                                           echo '<tr>';
                                           echo '<th class="text-info">Reg no</th>';
                                           echo '<th class="text-info">Name</th>';
                                           echo '<th class="text-info">Mid Term</th>';
                                           echo '<th class="text-info">Final Term</th>';
                                           echo '<th class="text-info">Remarks</th>';
                                           echo '<th class="text-info">Final Grade</th>';
                                           echo '<th class="text-info">Equivalent</th>';
                                           echo '</tr>';
                                           echo '</thead>';


                                           echo '<tbody>';

                                           while ($result55=$query309->fetch(PDO::FETCH_ASSOC)) {
                                               echo '<tr>';
                                               echo '<td>'.$result55['studregno'].'</td>';
                                               echo '<td>'.$result55['fname'].' '.$result55['lname'].'</td>';
                                               echo '<td>'.$result55['midterm'].'%'.'</td>';
                                               echo '<td>'.$result55['finalterm'].'%'.'</td>';
                                               echo '<td>'.$result55['remarks'].'</td>';
                                               echo '<td>'.$result55['finalgrade'].'%'.'</td>';
                                               echo '<td>'.$result55['equivalent'].'</td>';
                                               echo '</tr>';
                                           }
                                           echo '</tbody>';
                                           echo '</table>';


                                       }else{
                                           echo 'No Records';
                                       }
                                       ?>
                                       <input type="button" class="btn btn-info" id="refreshgr" onclick="refreshgr();" value="Refresh">
                                       <input type="hidden" id="classcoderfr" value="<?php echo $classcode?>">
                                       <div id="refresh"></div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <!--general records-->

                       <!--configurations-->
                       <div class="tab-pane" id="6b">
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
                                               echo '<td style="width: 90px;">Attendance</td>';
                                               echo '<td style="width: 90px;">Assignment</td>';
                                               echo '<td style="width: 90px;">Seatwork</td>';
                                               echo '<td style="width: 90px;">Quiz</td>';
                                               echo '<td style="width: 90px;">Term Exam</td>';
                                               echo '<td style="width: 90px;">Project</td>';
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
                                           $fetchgs='SELECT *FROM tblscore WHERE classid= :classid ';
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
                                       <br>
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
                               </div>
                           </div>
                           <!--configurations-->
                   </div>
                </div>
            </div>
        </div>


            <!--student list-->
            <div class="studentlistbox col-lg-3 container-fluid">
                <div class="studentlist">
                    <form action="classplatform.php" method="post">
                        <table class="table table-responsive">
                            <?php
                            if(isset($classid)){
                                $fetchstudents='SELECT tblstudent.studregno, tblstudent.fname, tblstudent.lname
                                    FROM tblclass_student INNER JOIN tblstudent 
                                    ON tblclass_student.studregno = tblstudent.studregno WHERE classid= :classid';
                                $query999=$conn->prepare($fetchstudents);
                                $query999->execute(array(
                                    ':classid'=>$classid,
                                ));
                                if ($query999->rowCount()>0){
                                    echo '<h4 class="text-info">';
                                    echo 'Student Lists';
                                    echo '</h4>';
                                    echo '<thead class="theadtitle text-default">';
                                    echo '<tr>';
                                    echo '<td class="">Reg no</td>';
                                    echo '<td class="">Name</td>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="listbody">';
                                    while ($result=$query999->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo "<a href=\"studentprofile.php?studregno=$result[studregno]\" name='attendance check' class='btn-success btn'>".$result['studregno'].'</a>';
                                        echo '</td>';
                                        echo '<td>' . $result['fname'];
                                        echo ' ';
                                        echo $result['lname'] . '</td>';
                                        $studregno = $result['studregno'];
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                }else{
                                    echo 'you have no students yet';
                                }
                            }else{
                                echo '';
                            }

                            ?>
                        </table>
                    </form>
                </div>
            </div>
    </div>


        </div>


<!--main body-->


<!--show attendance history of a student-->
<div id="showhere" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a title="Close" onclick="hidemod();" class="close">X</a>
        <h4 class="modal-header">Attendance Records</h4>
        <div id="viewhere">
<!--table shows here-->
        </div>
    </div>
</div>

<!--show attendance history-->

<!-- Footer -->
<div class="panel-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright text-success">Copyright &copy; University Corner 2017</span>
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

<!--changepmodal-->
<div id="changepmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod2();" title="Close" class="close">X</a>
        <h3 class="modal-header">Change Password</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="insregnop" name="insregnop" value="<?php echo $insregno; ?>">
            <input type="password" class="maxlen40 form-control" id="currentp" name="currentp" placeholder="Current Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="newp" name="newp" placeholder="New Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="confirmnewp" name="confirmnewp" placeholder="Confirm New Password" required>
            <br>
            <div class="text-right">
                <input type="button" class="btn btn-success" onclick="fncchangep();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod3();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="insregnoup" name="insregnoup" value="<?php echo $insregno; ?>">
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
                <input type="text" class="mobile maxlen11 form-control" id="ncontact" name="ncontact" placeholder="Contact">
            </div>
            <div class="col-lg-8 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfo();" id="updateinfo" name="updateinfo" value="Update">
            </div>
            <br><br>
            <div id="show2"></div>
        </form>

    </div>
</div>

<!--editaccountmodal-->

    <!--change profile photo modal-->
    <div id="changeppmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
        <div class="form-group well">
            <a href="" title="Close" class="close">X</a>
            <form action="classplatform.php" enctype="multipart/form-data" method="post">
                <h3 class="modal-header">Select New Profile Photo</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                    </div>
                    <div class="col-lg-6">

                        <img id="blah" src="<?php

                        $retrieveimg = 'SELECT *FROM tblinstructor WHERE insregno = :insregno';
                        $stmt = $conn->prepare($retrieveimg);
                        $stmt->execute(array(
                            ':insregno' => $insregno,
                        ));
                        if ($stmt->rowCount() > 0) {
                            $tblinstructor = $stmt->fetch();
                            $img = $tblinstructor['insimg'];
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
                        $uploadimg="UPDATE tblinstructor SET insimg = :img WHERE insregno = :insregno";
                        $stmt= $conn->prepare($uploadimg);
                        $stmt->execute(array(
                            ':img'=>$picProfile ,
                            ':insregno'=> $insregno,
                        ));
                        if ($stmt) {
                            echo '<script>window.top.location = "educatorindex.php";</script>';
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




<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="cediescripts.js"></script>
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="DataTables-1.10.16/media/js/jquery.dataTables.min.js"></script>
<script src="DataTables-1.10.16/media/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
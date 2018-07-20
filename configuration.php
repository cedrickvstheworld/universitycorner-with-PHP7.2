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


// grade setting
if(isset($_POST['btngradingsetting'])){
    if( $_POST['attendance']!==''&&
        $_POST['assignment']!==''&&
        $_POST['seatwork']!==''&&
        $_POST['quiz']!==''&&
        $_POST['termexam']!==''&&
        $_POST['project']!==''&&
        $_POST['classcode']!==''
    ) {
        $insregno = $_POST['insregno'];
        if (($_POST['attendance'] + $_POST['assignment'] + $_POST['seatwork'] + $_POST['quiz'] + $_POST['termexam'] + $_POST['project']) !== 100) {
            echo "<script>alert('category percentages should be equal to 100%');</script>";
        } else {
            $validateclasscode = 'SELECT *FROM tblclass WHERE classcode = :classcode AND insregno = :insregno';
            $query5443 = $conn->prepare($validateclasscode);
            $query5443->execute(array(
                ':classcode' => $_POST['classcode'],
                ':insregno' => $insregno,));

            if ($query5443->rowCount() > 0) {
                $tblclass = $query5443->fetch();
                $classid = $tblclass[0];
                $validateupdatability = 'SELECT *FROM tblevaluatedgrade WHERE classid = :classid';
                $query54433 = $conn->prepare($validateupdatability);
                $query54433->execute(array(
                    ':classid' => $classid,));
                if ($query54433->rowCount() === 0) {
                    $updatesettings = 'SELECT *FROM tblgradingsetting WHERE classid = :classid ';
                    $query35 = $conn->prepare($updatesettings);
                    $query35->execute(array(':classid' => $classid,));
                    if ($query35->rowCount() > 0) {
                        //setting updated here
                        $deletecurrent = 'DELETE FROM tblgradingsetting WHERE classid = :classid';
                        $query3 = $conn->prepare($deletecurrent);
                        $query3->execute(array(
                            ':classid' => $classid,
                        ));
                        if ($query3) {
                            $attendance = $_POST['attendance'] * 0.01;
                            $assignment = $_POST['assignment'] * 0.01;
                            $seatwork = $_POST['seatwork'] * 0.01;
                            $quiz = $_POST['quiz'] * 0.01;
                            $termexam = $_POST['termexam'] * 0.01;
                            $project = $_POST['project'] * 0.01;
                            $upsettings1 = "INSERT INTO tblgradingsetting
                                     VALUES ($classid, $attendance, $assignment, $seatwork, $quiz, $termexam, $project)";
                            if ($conn->query($upsettings1)) {
                                echo "<script>alert('Grading settings was successfully updated.');</script>";
                                echo "<script>window.top.location='educatorindex.php';</script>";
                            }
                        }
                    } else {
                        //setting inserted here
                        $attendance = $_POST['attendance'] * 0.01;
                        $assignment = $_POST['assignment'] * 0.01;
                        $seatwork = $_POST['seatwork'] * 0.01;
                        $quiz = $_POST['quiz'] * 0.01;
                        $termexam = $_POST['termexam'] * 0.01;
                        $project = $_POST['project'] * 0.01;
                        $insertsettings = "INSERT INTO tblgradingsetting
                                     VALUES ($classid, $attendance, $assignment, $seatwork, $quiz, $termexam, $project)";
                        if ($conn->query($insertsettings)) {
                            echo "<script>alert('Grading settings successfully set.');</script>";
                            echo "<script>window.top.location='educatorindex.php';</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Mid Term was already evaluated in this class. You cannot change the grading setting.');</script>";
                }

            } else {
                echo "<script>
                      alert('you have no class with that class code.');
                      document.getElementById('classcode').value='';
                      </script>";
            }
        }
    }else{
        echo '<script>alert("fill the fields.");</script>';
    }
}



//set scoreboard
if(isset($_POST['btnsetscoreboard'])){
    if( $_POST['iattendance']!==''&&
        $_POST['iassignment']!==''&&
        $_POST['iseatwork']!==''&&
        $_POST['iquiz']!==''&&
        $_POST['itermexam']!==''&&
        $_POST['iproject']!==''&&
        $_POST['iclasscode']!==''
    ) {
        $insregno = $_POST['insregno'];
    $validateclasscode='SELECT *FROM tblclass WHERE classcode = :classcode AND insregno = :insregno';
    $query5443=$conn->prepare($validateclasscode);
    $query5443->execute(array(
        ':classcode'=> $_POST['iclasscode'],
        ':insregno'=> $insregno,));

    if($query5443->rowCount()>0) {
        $tblclass = $query5443->fetch();
        $classid = $tblclass[0];
        if($_POST['selectterm'] === 'Mid Term') {
            $findintblscore = 'SELECT *FROM tblscore WHERE classid = :classid AND term = :term';
            $query = $conn->prepare($findintblscore);
            $query->execute(array(
                ':classid' => $classid,
                ':term'=>'Mid Term',
                ));
            if($query->rowCount()>0){
                $update='UPDATE tblscore set attendance = :attendance, assignment = :assignment,
                seatwork = :seatwork, quiz = :quiz, termexam = :termexam, project = :project
                WHERE classid = :classid AND term = :term';
                $stmt=$conn->prepare($update);
                $stmt->execute(array(
                    ':classid'=>$classid,
                    ':attendance'=>$_POST['iattendance'],
                    ':assignment'=>$_POST['iassignment'],
                    ':seatwork'=>$_POST['iseatwork'],
                    ':quiz'=>$_POST['iquiz'],
                    ':termexam'=>$_POST['itermexam'],
                    ':project'=>$_POST['iproject'],
                    ':term'=>'Mid Term',
                ));
                if($stmt){
                    $deleterecord='UPDATE tblevaluatedgrade SET midterm = :midterm, remarks = :remarks, finalgrade = :finalgrade,
                                  equivalent = :equivalent WHERE classid = :classid';
                    $stmt=$conn->prepare($deleterecord);
                    $stmt->execute(array(
                        ':midterm'=>null,
                        ':remarks'=>null,
                        ':finalgrade'=>null,
                        ':equivalent'=>null,
                        ':classid'=>$classid,
                    ));
                    if ($stmt) {
                        echo "<script>alert('Mid Term Scoreboard was successfully updated.');</script>";
                        echo "<script>window.top.location='educatorindex.php';</script>";
                    }
                }
            }else{
                $insert='INSERT INTO tblscore VALUES (:classid, :attendance, :assignment, :seatwork, :quiz, :termexam, :project, :term)';
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                    ':classid'=>$classid,
                    ':attendance'=>$_POST['iattendance'],
                    ':assignment'=>$_POST['iassignment'],
                    ':seatwork'=>$_POST['iseatwork'],
                    ':quiz'=>$_POST['iquiz'],
                    ':termexam'=>$_POST['itermexam'],
                    ':project'=>$_POST['iproject'],
                    ':term'=>'Mid Term',
                ));
                if($stmt){
                    echo "<script>alert('Mid Term Scoreboard was successfully Set.');</script>";
                    echo "<script>window.top.location='educatorindex.php';</script>";
                }
            }
        }else{
            $findintblscore = 'SELECT *FROM tblscore WHERE classid = :classid AND term = :term';
            $query = $conn->prepare($findintblscore);
            $query->execute(array(
                ':classid' => $classid,
                ':term'=>'Final Term',
            ));
            if($query->rowCount()>0){
                $update='UPDATE tblscore set attendance = :attendance, assignment = :assignment,
                seatwork = :seatwork, quiz = :quiz, termexam = :termexam, project = :project
                WHERE classid = :classid AND term = :term';
                $stmt=$conn->prepare($update);
                $stmt->execute(array(
                    ':classid'=>$classid,
                    ':attendance'=>$_POST['iattendance'],
                    ':assignment'=>$_POST['iassignment'],
                    ':seatwork'=>$_POST['iseatwork'],
                    ':quiz'=>$_POST['iquiz'],
                    ':termexam'=>$_POST['itermexam'],
                    ':project'=>$_POST['iproject'],
                    ':term'=>'Final Term',
                ));
                if($stmt){
                    $deleterecord='UPDATE tblevaluatedgrade SET finalterm = :finalterm, remarks = :remarks, finalgrade = :finalgrade,
                                  equivalent = :equivalent WHERE classid = :classid';
                    $stmt=$conn->prepare($deleterecord);
                    $stmt->execute(array(
                        ':finalterm'=>null,
                        ':remarks'=>null,
                        ':finalgrade'=>null,
                        ':equivalent'=>null,
                        ':classid'=>$classid,
                    ));
                    if ($stmt) {
                        echo "<script>alert('Final Term Scoreboard was successfully updated.');</script>";
                        echo "<script>window.top.location='educatorindex.php';</script>";
                    }
                }
            }else{
                $insert='INSERT INTO tblscore VALUES (:classid, :attendance, :assignment, :seatwork, :quiz, :termexam, :project, :term)';
                $stmt=$conn->prepare($insert);
                $stmt->execute(array(
                    ':classid'=>$classid,
                    ':attendance'=>$_POST['iattendance'],
                    ':assignment'=>$_POST['iassignment'],
                    ':seatwork'=>$_POST['iseatwork'],
                    ':quiz'=>$_POST['iquiz'],
                    ':termexam'=>$_POST['itermexam'],
                    ':project'=>$_POST['iproject'],
                    ':term'=>'Final Term',
                ));
                if($stmt){
                    echo "<script>alert('Final Term Scoreboard was successfully Set.');</script>";
                    echo "<script>window.top.location='educatorindex.php';</script>";
                }
            }
        }
    }else{
        echo "<script>alert('you have no class with that class code.');
                       document.getElementById('iclasscode').value='';</script>";
    }
    }else{
        echo '<script>alert("fill the fields.");</script>';
    }
}


//set term percentages
if(isset($_POST['setpercentage'])){
    if( $_POST['midpercent']!==''&&
        $_POST['finalpercent']!==''&&
        $_POST['sclasscode']!==''&&
        $_POST['submissiondate']!==''
    ) {
        $insregno = $_POST['insregno'];
    if((($_POST['midpercent']+$_POST['finalpercent'])=== 100) && ($_POST['midpercent']>0 && $_POST['finalpercent']>0)){
        date_default_timezone_set('asia/manila');
        $datestr = date('Y-m-d');
        if($_POST['submissiondate'] > $datestr){
            $validateclasscode='SELECT *FROM tblclass WHERE classcode = :classcode AND insregno = :insregno';
            $query5443=$conn->prepare($validateclasscode);
            $query5443->execute(array(
                ':classcode'=> $_POST['sclasscode'],
                ':insregno'=> $insregno,));

            if($query5443->rowCount()>0){
                $tblclass= $query5443->fetch();
                $classid=$tblclass[0];
                $validateupdatability = 'SELECT *FROM tblevaluatedgrade WHERE classid = :classid';
                $query54433 = $conn->prepare($validateupdatability);
                $query54433->execute(array(
                    ':classid' => $classid,));
                if ($query54433->rowCount() === 0) {
                //success validation event
                $findexistence='SELECT *FROM tbltermpercentage WHERE classid = :classid';
                $query31=$conn->prepare($findexistence);
                $query31->execute(array(
                    ':classid'=>$classid,
                ));

                if($query31->rowCount()>0){
                    $deleteexisting='DELETE FROM tbltermpercentage WHERE classid = :classid';
                    $query313=$conn->prepare($deleteexisting);
                    $query313->execute(array(
                        ':classid'=>$classid,
                    ));
                    if($query313){
                        $midterm= $_POST['midpercent'] * 0.01;
                        $finalterm= $_POST['finalpercent'] * 0.01;
                        $passinggrade= $_POST['passinggrade'] * 0.01;
                        $insert="INSERT INTO tbltermpercentage VALUES 
                                    ($classid, $midterm, $finalterm,'".$_POST['submissiondate']."', $passinggrade)";
                        if($conn->query($insert)){
                            echo "<script>alert('Term percentages was successfully updated.');</script>";
                            echo "<script>window.top.location='educatorindex.php';</script>";
                        }
                    }
                }else{
                    $midterm= $_POST['midpercent'] * 0.01;
                    $finalterm= $_POST['finalpercent'] * 0.01;
                    $passinggrade= $_POST['passinggrade'] * 0.01;
                    $insert="INSERT INTO tbltermpercentage VALUES 
                                    ($classid, $midterm, $finalterm,'".$_POST['submissiondate']."', $passinggrade)";
                    if($conn->query($insert)){
                        echo "<script>alert('Term percentages was successfully set.');</script>";
                        echo "<script>window.top.location='educatorindex.php';</script>";
                    }
                }
                } else {
                    echo "<script>alert('Mid Term was already evaluated in this class. You cannot change Percentage settings.');</script>";
                }

            }else{
                echo "<script>alert('you have no class with that class code.');
                              document.getElementById('sclasscode').value='';</script>";
            }
        }else{
            echo "<script>alert('Submission Date must not be a past date.');</script>";
        }
    }else{
        echo "<script>alert('Mid term and Final term percentages should be equal to 100% and each must not be less than 0.');</script>";
    }
    }else{
        echo '<script>alert("fill the fields.");</script>';
    }
}
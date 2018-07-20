<?php
//validate student reg no for evaluation
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

try {
    $conn=new PDO($server, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    echo 'NOT CONNECTED' .$ex->getMessage();
}
if(isset($_POST['vvalidate'])) {

    if ($_POST['vstudregno'] === '') {
        echo "<script>alert('Enter a student number to be validated.');</script>";
        echo "<script>document.getElementById('gradingblock').style.display='none';</script>";
    } else {
        $validatestudreg = 'SELECT *FROM tblclass_student WHERE studregno = :studregno AND classid = :classid';
        $query1 = $conn->prepare($validatestudreg);
        $query1->execute(array(
            ':studregno' => $_POST['vstudregno'],
            ':classid' => $_POST['vclassid']
        ));

        if ($query1->rowCount() > 0) {
            $getstudentinfo = 'SELECT *FROM tblstudent WHERE studregno = :studregno';
            $query2 = $conn->prepare($getstudentinfo);
            $query2->execute(array(
                ':studregno' => $_POST['vstudregno'],
            ));
            if ($query2->rowCount() > 0) {
                $tblstudent=$query2->fetch();
                $fname = $tblstudent['1'];
                $lname = $tblstudent['2'];
                echo $fname.' '.$lname;
                echo "<script>document.getElementById('vstudregno').disabled = true;</script>";
                echo "<script>document.getElementById('gradingblock').style.display='block';</script>";
            }

        } else {
            echo "<script>alert('you have no student in this class with this reg no.');</script>";
            echo "<script>document.getElementById('gradingblock').style.display='none';</script>";
        }
    }
}
//validate student reg no for evaluation ends here


if (isset($_POST['selectterm'])) {
    if ($_POST['selectterm'] === 'Final Term') {
        $selectfscore='SELECT *FROM tblscore WHERE classid = :classid AND term = :term';
        $stmt=$conn->prepare($selectfscore);
        $stmt->execute(array(
           ':classid'=>$_POST['vclassid'],
            ':term'=>'Final Term',
        ));
        if($stmt->rowCount()>0){
            $tblscore = $stmt->fetch();
            $attendancev = $tblscore[1];
            $assignmnentv = $tblscore[2];
            $seatworkv = $tblscore[3];
            $quizv = $tblscore[4];
            $termexamv = $tblscore[5];
            $projectv = $tblscore[6];
            echo "<script>
                  document.getElementById('attend2').value = $attendancev;
                  document.getElementById('assignment2').value = $assignmnentv;
                  document.getElementById('seatwork2').value = $seatworkv;
                  document.getElementById('quiz2').value = $quizv;
                  document.getElementById('termexam2').value = $termexamv;
                  document.getElementById('project2').value = $projectv;
                  </script>";
        }else{
            echo "<script>
                  document.getElementById('attend2').value = '';
                  document.getElementById('assignment2').value = '';
                  document.getElementById('seatwork2').value = '';
                  document.getElementById('quiz2').value = '';
                  document.getElementById('termexam2').value = '';
                  document.getElementById('project2').value = '';
                  </script>";
        }
    }elseif($_POST['selectterm'] === 'Mid Term'){
        $selectmscore='SELECT *FROM tblscore WHERE classid = :classid AND term = :term';
        $stmt=$conn->prepare($selectmscore);
        $stmt->execute(array(
            ':classid'=>$_POST['vclassid'],
            ':term'=>'Mid Term',
        ));
        if($stmt->rowCount()>0){
            $tblscore = $stmt->fetch();
            $attendancev = $tblscore[1];
            $assignmnentv = $tblscore[2];
            $seatworkv = $tblscore[3];
            $quizv = $tblscore[4];
            $termexamv = $tblscore[5];
            $projectv = $tblscore[6];
            echo "<script>
                  document.getElementById('attend2').value = $attendancev;
                  document.getElementById('assignment2').value = $assignmnentv;
                  document.getElementById('seatwork2').value = $seatworkv;
                  document.getElementById('quiz2').value = $quizv;
                  document.getElementById('termexam2').value = $termexamv;
                  document.getElementById('project2').value = $projectv;
                  </script>";
        }else{
            echo "<script>
                  document.getElementById('attend2').value = '';
                  document.getElementById('assignment2').value = '';
                  document.getElementById('seatwork2').value = '';
                  document.getElementById('quiz2').value = '';
                  document.getElementById('termexam2').value = '';
                  document.getElementById('project2').value = '';
                  </script>";
        }
    }
}


//evaluating process

if(isset($_POST['evaluate'])) {
    if ($_POST['assignment1'] === ''
        || $_POST['quiz1'] === ''
        || $_POST['attendance1'] === ''
        || $_POST['seatwork1'] === ''
        || $_POST['termexam1'] === ''
        || $_POST['project1'] === '') {
        echo "<script>alert('fill in the attained scores (numerators) with numerical values 0-9');</script>";
    } else {
        if ($_POST['assignment2'] > 0
            || $_POST['quiz2'] > 0
            || $_POST['attendance2'] > 0
            || $_POST['seatwork2'] > 0
            || $_POST['termexam2'] > 0
            || $_POST['project2'] > 0) {
            if ($_POST['assignment1'] > $_POST['assignment2']
                || $_POST['quiz1'] > $_POST['quiz2']
                || $_POST['attendance1'] > $_POST['attendance2']
                || $_POST['seatwork1'] > $_POST['seatwork2']
                || $_POST['termexam1'] > $_POST['termexam2']
                || $_POST['project1'] > $_POST['project2']) {
                echo "<script>alert('check your inputs. Attained score should not be greater than the denominator score.');</script>";
            } else {

                //mid term
                if ($_POST['selectterm'] === 'Mid Term') {
                    $fetchmultiplier = 'SELECT *FROM tblgradingsetting WHERE classid = :classid';
                    $query0445 = $conn->prepare($fetchmultiplier);
                    $query0445->execute(array(
                        ':classid' => $_POST['vclassid'],
                    ));
                    if ($query0445->rowCount() > 0) {
                        $tblgs = $query0445->fetch();
                        $attendancemul = $tblgs[1];
                        $assignmentmul = $tblgs[2];
                        $seatworkmul = $tblgs[3];
                        $quizmul = $tblgs[4];
                        $termexammul = $tblgs[5];
                        $projectmul =$tblgs[6];
                        //Cedrick's Equation 101
                        $midfuckingterm = ((($_POST['attendance1'] / $_POST['attendance2']) * 100) * $attendancemul)
                            + ((($_POST['assignment1'] / $_POST['assignment2']) * 100) * $assignmentmul)
                            + ((($_POST['seatwork1'] / $_POST['seatwork2']) * 100) * $seatworkmul)
                            + ((($_POST['quiz1'] / $_POST['quiz2']) * 100) * $quizmul)
                            + ((($_POST['termexam1'] / $_POST['termexam2']) * 100) * $termexammul)
                            + ((($_POST['project1'] / $_POST['project2']) * 100) * $projectmul);
                        //Cedrick's Equation 101 ends here.. damn so easy.
                        $validatemidtermexistence = 'SELECT *FROM tblevaluatedgrade WHERE classid = :classid AND studregno = :studregno';
                        $query894 = $conn->prepare($validatemidtermexistence);
                        $query894->execute(array(
                            ':classid' => $_POST['vclassid'],
                            ':studregno' => $_POST['vstudregno'],
                        ));
                        if ($query894->rowCount() > 0) {
                            //update here
                            $deleteexistingmidterm='SELECT *FROM tblevaluatedgrade WHERE classid = :classid AND studregno = :studregno';
                            $query8943=$conn->prepare($deleteexistingmidterm);
                            $query8943->execute(array(
                                ':classid'=>$_POST['vclassid'],
                                ':studregno'=>$_POST['vstudregno'],
                            ));
                               if($query8943->rowCount()>0){
                                   $updaterec='UPDATE tblevaluatedgrade SET midterm = :midterm, finalgrade = NULL,
                                                      remarks = NULL , equivalent = NULL WHERE 
                                                      classid = :classid AND studregno = :studregno';
                                   $query457=$conn->prepare($updaterec);
                                   $query457->execute(array(
                                       ':classid'=>$_POST['vclassid'],
                                       ':studregno'=>$_POST['vstudregno'],
                                       ':midterm'=>$midfuckingterm,
                                   ));

                                   if($query457) {
                                       echo "<script>alert(\"Student's Mid term average was successfully updated. Student's final grade was voided because of the change. Re-finalize student's grade.\");</script>";
                                       echo "<script>document.getElementById('averagehere').style.display='block';</script>";
                                       echo 'result: '.$midfuckingterm.'%';
                                   }
                               }

                        } else {

                            //insert here
                            $updatemidterm="INSERT INTO tblevaluatedgrade (studregno, classid, midterm)
                                                       VALUES ('".$_POST['vstudregno']."', '".$_POST['vclassid']."',$midfuckingterm)";

                            if($conn->query($updatemidterm)){
                                echo "<script>alert(\"Student's Mid term average was successfully recorded\");</script>";
                                echo "<script>document.getElementById('averagehere').style.display='block';</script>";
                                echo 'result: '.$midfuckingterm.'%';

                            }
                        }

                    }
                }
                //mid term

                //final term
                elseif($_POST['selectterm'] === 'Final Term'){
                    $fetchmultiplier = 'SELECT *FROM tblgradingsetting WHERE classid = :classid';
                    $query0445 = $conn->prepare($fetchmultiplier);
                    $query0445->execute(array(
                        ':classid' => $_POST['vclassid'],
                    ));
                    if ($query0445->rowCount() > 0) {
                        $tblgs = $query0445->fetch();
                        $attendancemul = $tblgs[1];
                        $assignmentmul = $tblgs[2];
                        $seatworkmul = $tblgs[3];
                        $quizmul = $tblgs[4];
                        $termexammul = $tblgs[5];
                        $projectmul =$tblgs[6];
                        //Cedrick's Equation 101
                        $finfuckingterm = ((($_POST['attendance1'] / $_POST['attendance2']) * 100) * $attendancemul)
                            + ((($_POST['assignment1'] / $_POST['assignment2']) * 100) * $assignmentmul)
                            + ((($_POST['seatwork1'] / $_POST['seatwork2']) * 100) * $seatworkmul)
                            + ((($_POST['quiz1'] / $_POST['quiz2']) * 100) * $quizmul)
                            + ((($_POST['termexam1'] / $_POST['termexam2']) * 100) * $termexammul)
                            + ((($_POST['project1'] / $_POST['project2']) * 100) * $projectmul);
                        //Cedrick's Equation 101 ends here.. damn so easy.
                        $validatefintermexistence = 'SELECT *FROM tblevaluatedgrade WHERE classid = :classid AND studregno = :studregno';
                        $query894 = $conn->prepare($validatefintermexistence);
                        $query894->execute(array(
                            ':classid' => $_POST['vclassid'],
                            ':studregno' => $_POST['vstudregno'],
                        ));
                        if ($query894->rowCount()>0) {
                            //update here
                                $tblgs=$query894->fetch();
                                $finalterm=$tblgs[3];

                                if($finalterm === null) {
                                    //insert here
                                    $updaterec = 'UPDATE tblevaluatedgrade SET finalterm = :finalterm WHERE classid = :classid AND studregno = :studregno';
                                    $query457 = $conn->prepare($updaterec);
                                    $query457->execute(array(
                                        ':classid' => $_POST['vclassid'],
                                        ':studregno' => $_POST['vstudregno'],
                                        ':finalterm' => $finfuckingterm,
                                    ));

                                    if ($query457) {
                                        echo "<script>alert(\"Student's Final term average was successfully recorded\");</script>";
                                        echo "<script>document.getElementById('averagehere').style.display='block';</script>";
                                        echo 'result: '.$finfuckingterm.'%';
                                    }
                                }else {

                                    $updaterec = 'UPDATE tblevaluatedgrade SET finalterm = :finalterm, finalgrade = NULL,
                                                      remarks = NULL , equivalent = NULL
                                                      WHERE classid = :classid AND studregno = :studregno';
                                    $query457 = $conn->prepare($updaterec);
                                    $query457->execute(array(
                                        ':classid' => $_POST['vclassid'],
                                        ':studregno' => $_POST['vstudregno'],
                                        ':finalterm' => $finfuckingterm,
                                    ));

                                    if ($query457) {
                                        echo "<script>alert(\"Student's Final term average was successfully updated.  Student's final grade was voided because of the change. Re-finalize student's grade.\");</script>";
                                        echo "<script>document.getElementById('averagehere').style.display='block';</script>";
                                        echo 'result: '.$finfuckingterm.'%';
                                    }
                                }

                        }else{
                                echo "<script>alert(\"Evaluate Student's Mid Term First\");</script>";
                            }
                        }

                }

                //final term
            }
        } else {
            echo "<script>alert('You cannot evaluate a grade. Please Set a score board for this class');</script>";
        }
    }
}
//evaluating process ends motherfucking here




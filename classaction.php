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
//fucking query for present
if(isset($_POST['btnpresent'])) {
    if ($_POST['pstudregno'] === '') {
      echo "<script>alert('Enter a Student Reg no.');</script>";
    }else{
        $validatestudregno=' SElECT *FROM tblclass_student WHERE studregno = :studregno AND classid = :classid';

        $query9903= $conn->prepare($validatestudregno);
        $query9903->execute(array(
            ':classid'=>$_POST['pclassid'],
            ':studregno'=>$_POST['pstudregno']
        ));

        if($query9903->rowCount()>0){
            date_default_timezone_set('asia/manila');
            $date = new DateTime('now');
            $datestr = date('F-d-Y');
            $timestr =date('h:i:s a');
         $verifypresentstat='SELECT *FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND stat = :stat  AND classid = :classid';
         $query95= $conn->prepare($verifypresentstat);
         $query95->execute(array(
             ':studregno' => $_POST['pstudregno'],
             ':attendancedate' => $datestr,
             ':stat'=>'Present',
             ':classid'=>$_POST['pclassid'],));

         if ($query95->rowCount()>0){
             echo "<script>alert('This student was already recorded as present. Click Absent to change student status to absent or Late to change student status to late.');</script>";
          }else{
                      $deletestata='DELETE FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND classid = :classid';
                      $query3= $conn->prepare($deletestata);
                      $query3->execute(array(
                         ':studregno'=>$_POST['pstudregno'],
                         ':attendancedate'=>$datestr,
                          ':classid'=>$_POST['pclassid'],));
                      if($query3){
                          date_default_timezone_set('asia/manila');
                          $date = new DateTime('now');
                          $datestr = date('F-d-Y');
                          $timestr =date('h:i:s a');

                          $recordaspresent="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                          VALUES ('$datestr', '".$_POST['pstudregno']."', '".$_POST['pclassid']."', 'Present','$timestr')";
                           if($conn->query($recordaspresent)){
                               echo "<script>alert('Recorded as Present.');</script>";
                               $classcode=$_POST['classcode'];
                               echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";

                            }
                  }else{
                      date_default_timezone_set('asia/manila');
                      $date = new DateTime('now');
                      $datestr = date('F-d-Y');
                      $timestr =date('h:i:s a');


           $recordaspresent="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                               VALUES ('$datestr', '".$_POST['pstudregno']."', '".$_POST['pclassid']."', 'Present', '$timestr')";
              if($conn->query($recordaspresent)){
                  echo "<script>alert('Recorded as Present.');</script>";
                  $classcode=$_POST['classcode'];
                  echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";

               }
                  }
          }
        }else{
            echo "<script>alert('There is no student in this class with that reg no.');</script>";
        }
    }
}
//fucking query for present ends here


//fucking query for absent
if(isset($_POST['btnabsent'])) {
    if ($_POST['astudregno'] === '') {
        echo "<script>alert('Enter a Student Reg no.');</script>";

    }else{
        $validatestudregno=' SElECT *FROM tblclass_student WHERE studregno = :studregno AND classid = :classid';

        $query9903= $conn->prepare($validatestudregno);
        $query9903->execute(array(
            ':classid'=>$_POST['aclassid'],
            ':studregno'=>$_POST['astudregno']
        ));

        if($query9903->rowCount()>0){
            date_default_timezone_set('asia/manila');
            $date = new DateTime('now');
            $datestr = date('F-d-Y');
            $timestr =date('h:i:s a');
            $verifypresentstat='SELECT *FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND stat = :stat AND classid = :classid';
            $query95= $conn->prepare($verifypresentstat);
            $query95->execute(array(
                ':studregno' => $_POST['astudregno'],
                ':attendancedate' => $datestr,
                ':stat'=>'Absent',
                ':classid'=>$_POST['aclassid'],));

            if ($query95->rowCount()>0){
                echo "<script>alert('This student was already recorded as absent. Click Present to change student status to present or Late to change student status to late.');</script>";
            }else{
                    $deletestata='DELETE FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND classid = :classid ';
                    $query3= $conn->prepare($deletestata);
                    $query3->execute(array(
                        ':studregno'=>$_POST['astudregno'],
                        ':attendancedate'=>$datestr,
                        ':classid'=>$_POST['aclassid'],
                    ));
                    if($query3){
                        date_default_timezone_set('asia/manila');
                        $date = new DateTime('now');
                        $datestr = date('F-d-Y');
                        $timestr =date('h:i:s a');

                        $recordasabsent="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                          VALUES ('$datestr', '".$_POST['astudregno']."', '".$_POST['aclassid']."', 'Absent', '$timestr')";
                        if($conn->query($recordasabsent)){
                            echo "<script>alert('Recorded as Absent.');</script>";
                            $classcode=$_POST['classcode'];
                            echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";
                        }
                }else{
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('F-d-Y');
                    $timestr =date('h:i:s a');

                    $recordasabsent="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                               VALUES ('$datestr', '".$_POST['astudregno']."', '".$_POST['aclassid']."', 'Absent', '$timestr')";
                    if($conn->query($recordasabsent)){
                        echo "<script>alert('Recorded as Absent.');</script>";
                        $classcode=$_POST['classcode'];
                        echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";
                    }
                }
            }
        }else{
            echo "<script>alert('There is no student in this class with that reg no');</script>";
        }
    }
}

//fucking query for absent ends here


//fucking query for late

if(isset($_POST['btnlate'])) {
    if ($_POST['lstudregno'] === '') {
        echo "<script>alert('Enter a Student Reg no.');</script>";

    }else{
        $validatestudregno=' SElECT *FROM tblclass_student WHERE studregno = :studregno AND classid = :classid';

        $query9903= $conn->prepare($validatestudregno);
        $query9903->execute(array(
            ':classid'=>$_POST['lclassid'],
            ':studregno'=>$_POST['lstudregno']
        ));

        if($query9903->rowCount()>0){
            date_default_timezone_set('asia/manila');
            $date = new DateTime('now');
            $datestr = date('F-d-Y');
            $timestr =date('h:i:s a');
            $verifypresentstat='SELECT *FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND stat = :stat AND classid = :classid';
            $query95= $conn->prepare($verifypresentstat);
            $query95->execute(array(
                ':studregno' => $_POST['lstudregno'],
                ':attendancedate' => $datestr,
                ':stat'=>'Late',
                ':classid'=>$_POST['lclassid'],));

            if ($query95->rowCount()>0){
                echo "<script>alert('This student was already recorded as Late. Click Present to change student status to present or Absent to change student status to absent.');</script>";
            }else{
                $deletestata='DELETE FROM tblattendance WHERE studregno = :studregno AND attendancedate = :attendancedate AND classid = :classid ';
                $query3= $conn->prepare($deletestata);
                $query3->execute(array(
                    ':studregno'=>$_POST['lstudregno'],
                    ':attendancedate'=>$datestr,
                    ':classid'=>$_POST['lclassid'],
                ));
                if($query3){
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('F-d-Y');
                    $timestr =date('h:i:s a');

                    $recordaslate="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                          VALUES ('$datestr', '".$_POST['lstudregno']."', '".$_POST['lclassid']."', 'Late', '$timestr')";
                    if($conn->query($recordaslate)){
                        echo "<script>alert('Recorded as Late.');</script>";
                        $classcode=$_POST['classcode'];
                        echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";
                    }
                }else{
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('F-d-Y');
                    $timestr =date('h:i:s a');

                    $recordaslate="INSERT INTO tblattendance (attendancedate, studregno, classid, stat, attendancetime)
                               VALUES ('$datestr', '".$_POST['lstudregno']."', '".$_POST['lclassid']."', 'Late', '$timestr')";
                    if($conn->query($recordaslate)){
                        echo "<script>alert('Recorded as Late.');</script>";
                        $classcode=$_POST['classcode'];
                        echo "<script>window.location = 'classplatform.php?classcode=$classcode';</script>";
                    }
                }
            }
        }else{
            echo "<script>alert('There is no student in this class with that reg no');</script>";
        }
    }
}
//fucking query for late ends here


// G G W P!





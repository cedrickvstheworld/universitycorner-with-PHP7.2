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

if(isset($_POST['post'])) {
    if ($_POST['postbody'] === '') {
        echo "<script>alert('Your post has an empty body!')</script>";
    } else {
        if ($_POST['classcodep'] === '') {
            echo "<script>alert('Enter a class code.')</script>";
        } else {
            $validateclasscode1 = 'SELECT *FROM tblclass WHERE classcode = :classcode AND insregno = :insregno';
            $query54431 = $conn->prepare($validateclasscode1);
            $query54431->execute(array(
                ':classcode' => $_POST['classcodep'],
                ':insregno' => $_POST['insregno'],));

            if ($query54431->rowCount() > 0) {
                $tblclass = $query54431->fetch();
                $classid = $tblclass[0];
                $subjectdesc = $tblclass[6];
                $postbody = $_POST['postbody'];
                $type = $_POST['type'];
                date_default_timezone_set('asia/manila');
                $date = new DateTime('now');
                $datestr = date('F-d-Y');
                $timestr = date('h:i:s a');

                $checkclass = 'SELECT *FROM tblclass_student WHERE classid = :classid';
                $stmt = $conn->prepare($checkclass);
                $stmt->execute(array(
                    ':classid' => $classid,
                ));
                if ($stmt->rowCount() > 0) {
                    $recordpost = 'INSERT INTO tblpost (classid, postbody, type, postdate, posttime, insregno, subject)
                             VALUES (:classid,:postbody,:type,:datestr,:timestr,:insregno,:subjectdesc)';
                    $query5481 = $conn->prepare($recordpost);
                    $query5481->execute(array(
                        ':classid' => $classid,
                        ':postbody' => $_POST['postbody'],
                        ':type' => $_POST['type'],
                        ':datestr' => $datestr,
                        ':timestr' => $timestr,
                        ':insregno' => $_POST['insregno'],
                        ':subjectdesc' => $subjectdesc,
                    ));


                    if ($query5481) {
                        echo "<script>window.top.location='educatorindex.php';</script>";
                    }

                } else {
                    echo "<script>alert('Please ask your students to join first before you can create a post.')</script>";
                    echo "<script>document.getElementById('classcodep').value='';</script>";
                }

            } else {
                echo "<script>alert('You have no class with that class code.')</script>";
                echo "<script>document.getElementById('classcodep').value='';</script>";
            }
        }
    }
}

//updatepost
if(isset($_POST['updatepost'])){
  $validatechange='SELECT *FROM tblpost WHERE postid = :postid';
  $stmt=$conn->prepare($validatechange);
  $stmt->execute(array(
     ':postid'=>$_POST['postid'],
  ));
  if($stmt->rowCount()>0){
      $tblpost=$stmt->fetch(PDO::FETCH_ASSOC);
      $postbody=$tblpost['postbody'];

      if($_POST['postbody'] === $postbody){
          echo "<script>alert('You did not make any changes in your post dude.');</script>";
      }else{
          if ($_POST['postbody'] === '') {
              echo "<script>alert('Your post has an empty body!');</script>";
          } else {
              date_default_timezone_set('asia/manila');
              $date = new DateTime('now');
              $datestr = date('F-d-Y');
              $timestr = date('h:i:s a');
              $updatepost='UPDATE tblpost SET postbody = :postbody, type = :type, postdate = :postdate, posttime = :posttime
                     WHERE postid = :postid';
              $stmt=$conn->prepare($updatepost);
              $stmt->execute(array(
                  ':postbody'=>$_POST['postbody'],
                  ':type'=>$_POST['type'],
                  ':postdate'=>$datestr,
                  ':posttime'=>$timestr,
                  ':postid'=>$_POST['postid'],
              ));
              if($stmt){
                  echo '<script>window.top.location = "educatorindex.php";</script>';
              }
          }
      }
  }
}
//updatepost
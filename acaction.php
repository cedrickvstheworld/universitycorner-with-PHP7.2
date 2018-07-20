<?php
session_start();
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

try {
    $conn = new PDO($server, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
echo 'NOT CONNECTED'.$ex->getMessage();
}

if(isset($_POST['userac'])){
    echo "<script>window.top.location='changepassoutside.php';</script>";
}else{
    echo'';
}


//account recovery via security question
if(isset($_POST['nextsq'])) {
    $user = $_POST['user'];
    $answer = $_POST['answer'];
    $secquestion = $_POST['secquestion'];
    if ($user === '' || $answer === '') {
        echo "<script>alert('Fill in the Fields');</script>";
    } else {
        //instructor
        $findininstructor = 'SELECT *FROM tblinstructor WHERE username = :username';
        $stmt = $conn->prepare($findininstructor);
        $stmt->execute(array(
            ':username' => $user,
        ));
        if ($stmt->rowCount() > 0) {
            $tblinstructor = $stmt->fetch();
            $secquestionxxx = $tblinstructor['secquestion'];
            $answerxxx = $tblinstructor['answer'];

            if (password_verify("$secquestion", "$secquestionxxx")
                && password_verify("$answer", "$answerxxx")) {
                $_SESSION['userac'] = $user;
                echo "<script>window.top.location='changepassoutside.php';</script>";
                echo "<script>document.getElementById('username').value='';</script>";
                echo "<script>document.getElementById('scanswer').value='';</script>";
            } else {
                echo "<script>alert('Question and answer did not match.');</script>";
                echo "<script>document.getElementById('scanswer').value='';</script>";
            }
        }else{
            //student
            $findinstudent = 'SELECT *FROM tblstudent WHERE username = :username';
            $stmt = $conn->prepare($findinstudent);
            $stmt->execute(array(
                ':username' => $user,
            ));
            if ($stmt->rowCount() > 0){
                $tblstudent = $stmt->fetch();
                $secquestionxxx = $tblstudent['secquestion'];
                $answerxxx = $tblstudent['answer'];

                if (password_verify("$secquestion", "$secquestionxxx")
                    && password_verify("$answer", "$answerxxx")) {
                    $_SESSION['userac'] = $user;
                    echo "<script>window.top.location='changepassoutside.php';</script>";
                    echo "<script>document.getElementById('username').value='';</script>";
                    echo "<script>document.getElementById('scanswer').value='';</script>";
                } else {
                    echo "<script>alert('Question and answer did not match.');</script>";
                    echo "<script>document.getElementById('scanswer').value='';</script>";
                }
            }else{
                //parent
                $findinparent = 'SELECT *FROM tblparent WHERE username = :username';
                $stmt = $conn->prepare($findinparent);
                $stmt->execute(array(
                    ':username' => $user,
                ));
                if ($stmt->rowCount() > 0){
                    $tblparent = $stmt->fetch();
                    $secquestionxxx = $tblparent['secquestion'];
                    $answerxxx = $tblparent['answer'];

                    if (password_verify("$secquestion", "$secquestionxxx")
                        && password_verify("$answer", "$answerxxx")) {
                        $_SESSION['userac'] = $user;
                        echo "<script>window.top.location='changepassoutside.php';</script>";
                        echo "<script>document.getElementById('username').value='';</script>";
                        echo "<script>document.getElementById('scanswer').value='';</script>";
                    } else {
                        echo "<script>alert('Question and answer did not match.');</script>";
                        echo "<script>document.getElementById('scanswer').value='';</script>";
                    }
                }else{
                    echo "<script>alert('User does not exist.');</script>";
                    echo "<script>document.getElementById('username').value='';</script>";
                    echo "<script>document.getElementById('scanswer').value='';</script>";
                }
            }
        }
    }
}
//acount recovery via security question ends here
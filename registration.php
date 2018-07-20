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
if (isset($_SESSION['user'])){
    echo "<script>window.top.location='educatorindex.php';</script>";
}elseif (isset($_SESSION['user2'])){
    echo "<script>window.top.location='studentindex.php';</script>";
}elseif (isset($_SESSION['user3'])){
    echo "<script>window.top.location='parentindex.php';</script>";
}else{
    echo '';
}

//educator registration
if(isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $birthmonth = $_POST['birthmonth'];
    $birthday = $_POST['birthday'];
    $birthyear = $_POST['birthyear'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $contact = $_POST['contact'];
    $secquestion = $_POST['secquestion'];
    $answer = $_POST['answer'];

    if ($fname === '' ||
    $mname === '' ||
    $lname === '' ||
    $address === '' ||
    $birthmonth === '' ||
    $birthday === '' ||
    $birthyear === '' ||
    $username === '' ||
    $password === '' ||
    $confirm === '' ||
    $contact === '' ||
    $secquestion === '' ||
    $answer === '') {
        echo "<script>alert('Complete the fields.');</script>";
    }else{

        $query1 = 'SELECT *FROM tblinstructor WHERE username = :username';
        $query2 = 'SELECT *FROM tblstudent WHERE username = :username';
        $query3 = 'SELECT *FROM tblparent WHERE username = :username';

        $stmt = $conn->prepare($query1);
        $stmt->execute(
            array(
                ':username' => $username,

            )
        );

        if ($stmt->rowCount() > 0) {
            echo '<script>alert("username already exists");</script>';
            echo "<script>document.getElementById('username').value='';</script>";
        } else {
            $stmt = $conn->prepare($query2);
            $stmt->execute(
                array(
                    ':username' => $username,

                )
            );
            if ($stmt->rowCount() > 0) {
                echo '<script>alert("username already exists");</script>';
                echo "<script>document.getElementById('username').value='';</script>";
            } else {
                $stmt = $conn->prepare($query3);
                $stmt->execute(
                    array(
                        ':username' => $username,

                    )
                );
                if ($stmt->rowCount() > 0) {
                    echo '<script>alert("username already exists");</script>';
                    echo "<script>document.getElementById('username').value='';</script>";
                } else {
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('Y');
                    if($birthyear<1920 || $birthyear>($datestr-18) || strlen($birthyear)>4){
                        echo '<script>alert("Enter a valid birthyear. You must be also 18 years old and above.");</script>';
                        echo "<script>document.getElementById('birthyear').value='';</script>";
                    }else {
                        if (strlen($password)<8) {
                            echo '<script>alert("password must contain atleast 8 characters");
                                  document.getElementById("password").value="";</script>';
                        } else {
                            if ($password !== $confirm) {
                                echo '<script>alert("Password did not match.");</script>';
                                echo "<script>document.getElementById('confirm').value='';</script>";
                            } else {
                                $passwordxxx = password_hash("$password", PASSWORD_BCRYPT);
                                $answerxxx = password_hash("$answer", PASSWORD_BCRYPT);
                                $secquestionxxx = password_hash("$secquestion", PASSWORD_BCRYPT);
                                $register = 'INSERT INTO tblinstructor (fname, mname, lname, address, password, secquestion, answer, username, birthmonth, birthday, birthyear, contact)
                                        VALUES (:fname, :mname, :lname, :address, :password, :secquestion, :answer, :username, :birthmonth, :birthday, :birthyear, :contact)';
                                $stmt = $conn->prepare($register);
                                $stmt->execute(array(
                                    ':fname' => $fname,
                                    ':mname' => $mname,
                                    ':lname' => $lname,
                                    ':address' => $address,
                                    ':password' => $passwordxxx,
                                    ':secquestion' => $secquestionxxx,
                                    ':answer' => $answerxxx,
                                    ':username' => $username,
                                    ':birthmonth' => $birthmonth,
                                    ':birthday' => $birthday,
                                    ':birthyear' => $birthyear,
                                    ':contact' => $contact,
                                ));
                                if ($stmt) {
                                    echo "<script>document.getElementById('fname').value='';</script>";
                                    echo "<script>document.getElementById('mname').value='';</script>";
                                    echo "<script>document.getElementById('lname').value='';</script>";
                                    echo "<script>document.getElementById('address').value='';</script>";
                                    echo "<script>document.getElementById('birthyear').value='';</script>";
                                    echo "<script>document.getElementById('username').value='';</script>";
                                    echo "<script>document.getElementById('password').value='';</script>";
                                    echo "<script>document.getElementById('confirm').value='';</script>";
                                    echo "<script>document.getElementById('secquestion').value='';</script>";
                                    echo "<script>document.getElementById('answer').value='';</script>";
                                    echo "<script>document.getElementById('contact').value='';</script>";

                                    $firstlogin = 'SELECT *FROM tblinstructor WHERE password = :password';
                                    $stmt = $conn->prepare($firstlogin);
                                    $stmt->execute(array(
                                        ':password' => $passwordxxx,
                                    ));
                                    if ($stmt->rowCount() > 0) {
                                        $_SESSION['user'] = $username;
                                        echo "<script>window.top.location='loginpage.php';</script>";
                                        echo "<script>alert('Hi $fname! Thank you for signing-up.');</script>";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
//educator registration ends here



//student registration
if(isset($_POST['register2'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $birthmonth = $_POST['birthmonth'];
    $birthday = $_POST['birthday'];
    $birthyear = $_POST['birthyear'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $contact = $_POST['contact'];
    $guardiancontact = $_POST['guardiancontact'];
    $secquestion = $_POST['secquestion'];
    $answer = $_POST['answer'];

    if ($fname === '' ||
        $mname === '' ||
        $lname === '' ||
        $address === '' ||
        $birthmonth === '' ||
        $birthday === '' ||
        $birthyear === '' ||
        $username === '' ||
        $password === '' ||
        $confirm === '' ||
        $contact === '' ||
        $guardiancontact === '' ||
        $secquestion === '' ||
        $answer === '') {
        echo "<script>alert('Complete the fields.');</script>";
    }else{

        $query1 = 'SELECT *FROM tblinstructor WHERE username = :username';
        $query2 = 'SELECT *FROM tblstudent WHERE username = :username';
        $query3 = 'SELECT *FROM tblparent WHERE username = :username';

        $stmt = $conn->prepare($query1);
        $stmt->execute(
            array(
                ':username' => $username,

            )
        );

        if ($stmt->rowCount() > 0) {
            echo '<script>alert("username already exists");</script>';
            echo "<script>document.getElementById('username').value='';</script>";
        } else {
            $stmt = $conn->prepare($query2);
            $stmt->execute(
                array(
                    ':username' => $username,

                )
            );
            if ($stmt->rowCount() > 0) {
                echo '<script>alert("username already exists");</script>';
                echo "<script>document.getElementById('username').value='';</script>";
            } else {
                $stmt = $conn->prepare($query3);
                $stmt->execute(
                    array(
                        ':username' => $username,

                    )
                );
                if ($stmt->rowCount() > 0) {
                    echo '<script>alert("username already exists");</script>';
                    echo "<script>document.getElementById('username').value='';</script>";
                } else {
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('Y');
                    if($birthyear<1920 || $birthyear>($datestr-13) || strlen($birthyear)>4){
                        echo '<script>alert("Enter a valid birthyear. You must be also 13 years old and above.");</script>';
                        echo "<script>document.getElementById('birthyear').value='';</script>";
                    }else {
                        if (strlen($password) < 8) {
                            echo '<script>alert("password must contain atleast 8 characters");
                                  document.getElementById("password").value="";</script>';
                        } else {
                            if ($password !== $confirm) {
                                echo '<script>alert("Password did not match.");</script>';
                                echo "<script>document.getElementById('confirm').value='';</script>";
                            } else {
                                //create studcode here
                                try {
                                    random_int(111111, 999999);
                                } catch (Exception $e) {
                                }
                                $studcode = mt_rand();
                                $checkmtrand = 'SELECT *FROM tblstudent WHERE studcode = :studcode';
                                $query = $conn->prepare($checkmtrand);
                                $query->execute(array(
                                    ':studcode' => $studcode,
                                ));

                                do {
                                    try {
                                        random_int(111111, 999999);
                                    } catch (Exception $e) {
                                    }
                                } while ($query->rowCount() > 0);
                                try {
                                    $studcode = random_int(111111, 999999);
                                } catch (Exception $e) {
                                }
                                $passwordxxx = password_hash("$password", PASSWORD_BCRYPT);
                                $answerxxx = password_hash("$answer", PASSWORD_BCRYPT);
                                $secquestionxxx = password_hash("$secquestion", PASSWORD_BCRYPT);
                                $register = 'INSERT INTO tblstudent (fname, lname, contact, guardiancontact, address, mname, password, secquestion, answer, username, birthmonth, birthday, birthyear, studcode) 
                                           VALUES (:fname, :lname, :contact, :guardiancontact, :address, :mname, :password, :secquestion, :answer, :username, :birthmonth, :birthday, :birthyear, :studcode)';
                                $stmt = $conn->prepare($register);
                                $stmt->execute(array(
                                    ':fname' => $fname,
                                    ':mname' => $mname,
                                    ':lname' => $lname,
                                    ':address' => $address,
                                    ':password' => $passwordxxx,
                                    ':secquestion' => $secquestionxxx,
                                    ':answer' => $answerxxx,
                                    ':username' => $username,
                                    ':birthmonth' => $birthmonth,
                                    ':birthday' => $birthday,
                                    ':birthyear' => $birthyear,
                                    ':contact' => $contact,
                                    ':guardiancontact' => $guardiancontact,
                                    ':studcode' => $studcode,
                                ));
                                if ($stmt) {
                                    echo "<script>document.getElementById('fname').value='';</script>";
                                    echo "<script>document.getElementById('mname').value='';</script>";
                                    echo "<script>document.getElementById('lname').value='';</script>";
                                    echo "<script>document.getElementById('address').value='';</script>";
                                    echo "<script>document.getElementById('birthyear').value='';</script>";
                                    echo "<script>document.getElementById('username').value='';</script>";
                                    echo "<script>document.getElementById('password').value='';</script>";
                                    echo "<script>document.getElementById('confirm').value='';</script>";
                                    echo "<script>document.getElementById('secquestion').value='';</script>";
                                    echo "<script>document.getElementById('answer').value='';</script>";
                                    echo "<script>document.getElementById('contact').value='';</script>";
                                    echo "<script>document.getElementById('guardiancontact').value='';</script>";

                                    $firstlogin = 'SELECT *FROM tblstudent WHERE password = :password';
                                    $stmt = $conn->prepare($firstlogin);
                                    $stmt->execute(array(
                                        ':password' => $passwordxxx,
                                    ));
                                    if ($stmt->rowCount() > 0) {
                                        $_SESSION['user2'] = $username;
                                        echo "<script>window.top.location='loginpage.php';</script>";
                                        echo "<script>alert('Hi $fname! Thank you for signing-up.');</script>";
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
//student registration ends here



//parent registration
if(isset($_POST['register3'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $birthmonth = $_POST['birthmonth'];
    $birthday = $_POST['birthday'];
    $birthyear = $_POST['birthyear'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $contact = $_POST['contact'];
    $secquestion = $_POST['secquestion'];
    $answer = $_POST['answer'];

    if ($fname === '' ||
        $mname === '' ||
        $lname === '' ||
        $address === '' ||
        $birthmonth === '' ||
        $birthday === '' ||
        $birthyear === '' ||
        $username === '' ||
        $password === '' ||
        $confirm === '' ||
        $contact === '' ||
        $secquestion === '' ||
        $answer === '') {
        echo "<script>alert('Complete the fields.');</script>";
    }else{

        $query1 = 'SELECT *FROM tblinstructor WHERE username = :username';
        $query2 = 'SELECT *FROM tblstudent WHERE username = :username';
        $query3 = 'SELECT *FROM tblparent WHERE username = :username';

        $stmt = $conn->prepare($query1);
        $stmt->execute(
            array(
                ':username' => $username,

            )
        );

        if ($stmt->rowCount() > 0) {
            echo '<script>alert("username already exists");</script>';
            echo "<script>document.getElementById('username').value='';</script>";
        } else {
            $stmt = $conn->prepare($query2);
            $stmt->execute(
                array(
                    ':username' => $username,

                )
            );
            if ($stmt->rowCount() > 0) {
                echo '<script>alert("username already exists");</script>';
                echo "<script>document.getElementById('username').value='';</script>";
            } else {
                $stmt = $conn->prepare($query3);
                $stmt->execute(
                    array(
                        ':username' => $username,

                    )
                );
                if ($stmt->rowCount() > 0) {
                    echo '<script>alert("username already exists");</script>';
                    echo "<script>document.getElementById('username').value='';</script>";
                } else {
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('Y');
                    if ($birthyear < 1920 || $birthyear > ($datestr - 18) || strlen($birthyear) > 4) {
                        echo '<script>alert("Enter a valid birthyear. You must be also 18 years old and above.");</script>';
                        echo "<script>document.getElementById('birthyear').value='';</script>";
                    } else {
                        if (strlen($password) < 8) {
                            echo '<script>alert("password must contain atleast 8 characters");
                                  document.getElementById("password").value="";</script>';
                        } else {
                            if ($password !== $confirm) {
                                echo '<script>alert("Password did not match.");</script>';
                                echo "<script>document.getElementById('confirm').value='';</script>";
                            } else {
                                $passwordxxx = password_hash("$password", PASSWORD_BCRYPT);
                                $answerxxx = password_hash("$answer", PASSWORD_BCRYPT);
                                $secquestionxxx = password_hash("$secquestion", PASSWORD_BCRYPT);
                                $register = 'INSERT INTO tblparent (fname, mname, lname, address, password, secquestion, answer, username, birthmonth, birthday, birthyear, contact) 
                                           VALUES (:fname, :mname, :lname, :address, :password, :secquestion, :answer, :username, :birthmonth, :birthday, :birthyear, :contact) ';
                                $stmt = $conn->prepare($register);
                                $stmt->execute(array(
                                    ':fname' => $fname,
                                    ':mname' => $mname,
                                    ':lname' => $lname,
                                    ':address' => $address,
                                    ':password' => $passwordxxx,
                                    ':secquestion' => $secquestionxxx,
                                    ':answer' => $answerxxx,
                                    ':username' => $username,
                                    ':birthmonth' => $birthmonth,
                                    ':birthday' => $birthday,
                                    ':birthyear' => $birthyear,
                                    ':contact' => $contact,
                                ));
                                if ($stmt) {
                                    echo "<script>document.getElementById('fname').value='';</script>";
                                    echo "<script>document.getElementById('mname').value='';</script>";
                                    echo "<script>document.getElementById('lname').value='';</script>";
                                    echo "<script>document.getElementById('address').value='';</script>";
                                    echo "<script>document.getElementById('birthyear').value='';</script>";
                                    echo "<script>document.getElementById('username').value='';</script>";
                                    echo "<script>document.getElementById('password').value='';</script>";
                                    echo "<script>document.getElementById('confirm').value='';</script>";
                                    echo "<script>document.getElementById('secquestion').value='';</script>";
                                    echo "<script>document.getElementById('answer').value='';</script>";
                                    echo "<script>document.getElementById('contact').value='';</script>";

                                    $firstlogin = 'SELECT *FROM tblparent WHERE password = :password';
                                    $stmt = $conn->prepare($firstlogin);
                                    $stmt->execute(array(
                                        ':password' => $passwordxxx,
                                    ));
                                    if ($stmt->rowCount() > 0) {
                                        $_SESSION['user3'] = $username;
                                        echo "<script>window.top.location='loginpage.php';</script>";
                                        echo "<script>alert('Hi $fname! Thank you for signing-up.');</script>";
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
//parent registration ends here
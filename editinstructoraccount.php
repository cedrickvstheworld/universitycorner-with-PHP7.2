<?php
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

try {
    $conn = new PDO($server, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    echo 'not connected' .$ex->getMessage();
}

//change password
        if(isset($_POST['changep'])) {
            if ($_POST['currentp'] === '' ||
                $_POST['newp'] === '' ||
                $_POST['confirmnewp'] === '') {
                echo "<script>alert('Fill the fields');</script>";
            } else {
                $verifycurrentp = 'SELECT *FROM tblinstructor WHERE insregno = :insregno';
                $query232 = $conn->prepare($verifycurrentp);
                $query232->execute(array(
                    ':insregno' => $_POST['insregnop'],
                ));

                if ($query232->rowCount() > 0) {
                    $tblinstructor = $query232->fetch();
                    $password = $tblinstructor[5];
                    $pass=$_POST['currentp'];

                    if (password_verify("$pass","$password")) {
                        if (strlen($_POST['newp'])<8) {
                            echo '<script>alert("password must contain atleast 8 characters");
                                  document.getElementById("newp").value="";</script>';
                        } else {
                            if ($_POST['newp'] !== $_POST['confirmnewp']) {
                                echo "<script>alert('Password did not match');</script>";
                                echo "<script>document.getElementById('confirmnewp').value=''</script>";
                            } else {
                                $passc = $_POST['newp'];
                                if (password_verify("$passc", "$password")) {
                                    echo "<script>alert('Dude, You make no changes at all');</script>";
                                    echo "<script>document.getElementById('confirmnewp').value=''</script>";
                                    echo "<script>document.getElementById('currentp').value=''</script>";
                                    echo "<script>document.getElementById('newp').value=''</script>";
                                } else {
                                    $passwordxxx = password_hash("$passc", PASSWORD_BCRYPT);
                                    $updatepassword = 'UPDATE tblinstructor SET password = :newpassword WHERE insregno = :insregno';
                                    $query50 = $conn->prepare($updatepassword);
                                    $query50->execute(array(
                                        ':insregno' => $_POST['insregnop'],
                                        ':newpassword' => $passwordxxx,
                                    ));
                                    if ($query50) {
                                        echo "<script>alert('Your password was successfully updated');</script>";
                                        echo "<script>document.getElementById('confirmnewp').value=''</script>";
                                        echo "<script>document.getElementById('currentp').value=''</script>";
                                        echo "<script>document.getElementById('newp').value=''</script>";
                                        echo "<script>$('#changepmodal').modal('hide');</script>";
                                        echo "<script>window.top.location='educatorindex.php';</script>";

                                    }
                                }
                            }
                        }

                    } else {
                        echo "<script>alert('Incorrect Current Password');</script>";
                        echo "<script>document.getElementById('currentp').value=''</script>";
                    }
                }
            }
        }
//change password


//update info


            if (isset($_POST['updateinfo'])) {
                $insregnoup = $_POST['insregnoup'];
                $nfname = $_POST['nfname'];
                $nmname = $_POST['nmname'];
                $nlname = $_POST['nlname'];
                $naddress = $_POST['naddress'];
                $nbirthmonth = $_POST['nbirthmonth'];
                $nbirthday = $_POST['nbirthday'];
                $nbirthyear = $_POST['nbirthyear'];
                $ncontact = $_POST['ncontact'];
                if (
                    $nfname === '' ||
                    $nmname === '' ||
                    $nlname === '' ||
                    $naddress === '' ||
                    $nbirthyear === '' ||
                    $ncontact === ''
                ) {
                    echo "<script>alert('Fill the fields');</script>";
                } else {
                    date_default_timezone_set('asia/manila');
                    $date = new DateTime('now');
                    $datestr = date('Y');
                    if ($nbirthyear < 1920 || $nbirthyear>($datestr-18) || strlen($nbirthyear) > 4) {
                        echo '<script>alert("Enter a valid birthyear. You must be also 18 years old and above.");</script>';
                        echo "<script>document.getElementById('nbirthyear').value='';</script>";
                    } else {
                        //update here
                        $updateinfo = 'UPDATE tblinstructor SET
                                 fname = :fname,
                                 mname = :mname,
                                 lname = :lname,
                                 address = :address,
                                 birthmonth = :birthmonth,
                                 birthday = :birthday,
                                 birthyear = :birthyear,
                                 contact = :contact
                                WHERE insregno = :insregno';
                        $query501 = $conn->prepare($updateinfo);
                        $query501->execute(array(
                            ':fname' => $nfname,
                            ':mname' => $nmname,
                            ':lname' => $nlname,
                            ':address' => $naddress,
                            ':birthmonth' => $nbirthmonth,
                            ':birthday' => $nbirthday,
                            ':birthyear' => $nbirthyear,
                            ':contact' => $ncontact,
                            ':insregno' => $insregnoup,
                        ));
                        if ($query501) {
                            echo "<script>alert('Profile was successfully updated');</script>";
                            echo "<script>document.getElementById('nfname').value='';</script>";
                            echo "<script>document.getElementById('nmname').value='';</script>";
                            echo "<script>document.getElementById('nlname').value='';</script>";
                            echo "<script>document.getElementById('naddress').value='';</script>";
                            echo "<script>document.getElementById('nbirthyear').value='';</script>";
                            echo "<script>document.getElementById('ncontact').value='';</script>";
                            echo "<script>$('#editaccountmodal').modal('hide');</script>";
                            echo "<script>window.top.location='educatorindex.php';</script>";
                        }
                    }


                }
            }
//update info


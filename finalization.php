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



if(isset($_POST['fvalidate'])) {

    if ($_POST['fstudregno'] === '') {
        echo "<script>alert('Enter a student number to be validated.');</script>";
        echo "<script>document.getElementById('finalizedgradeblock').style.display='none';</script>";
    } else {
        $validatestudreg = 'SELECT *FROM tblclass_student WHERE studregno = :studregno AND classid = :classid';
        $query1 = $conn->prepare($validatestudreg);
        $query1->execute(array(
            ':studregno' => $_POST['fstudregno'],
            ':classid' => $_POST['fclassid']
        ));

        if ($query1->rowCount() > 0) {
            $getstudentinfo = 'SELECT *FROM tblstudent WHERE studregno = :studregno';
            $query2 = $conn->prepare($getstudentinfo);
            $query2->execute(array(
                ':studregno' => $_POST['fstudregno'],
            ));
            if ($query2->rowCount() > 0) {
                $tblstudent=$query2->fetch();
                $fname = $tblstudent['1'];
                $lname = $tblstudent['2'];
                echo $fname.' '.$lname;
                echo "<script>document.getElementById('fstudregno').disabled = true;</script>";
                echo "<script>document.getElementById('finalizedgradeblock').style.display='block';</script>";

                //get results
                $fetchtermres='SELECT *FROM tblevaluatedgrade WHERE classid = :classid AND studregno = :studregno';
                $query766=$conn->prepare($fetchtermres);
                $query766->execute(array(
                    ':classid'=>$_POST['fclassid'],
                    ':studregno'=>$_POST['fstudregno'],
                ));
                if($query766->rowCount()>0){
                    $tblevag=$query766->fetch();
                    $midres = $tblevag[2];
                    $finres = $tblevag[3];
                    echo "<script>document.getElementById('midres').value='$midres';</script>";
                    echo "<script>document.getElementById('finres').value='$finres';</script>";
                }else{
                    echo "<script>document.getElementById('midres').value='';</script>";
                    echo "<script>document.getElementById('finres').value='';</script>";
                }

                //get results
            }
        } else {
            echo "<script>alert('you have no student in this class with this reg no.');</script>";
            echo "<script>document.getElementById('finalizedgradeblock').style.display='none';</script>";

        }
    }
}
//validate student reg no for evaluation ends here

//grade finalization
if(isset($_POST['finalize'])) {
    $validation101 = 'SELECT *FROM tbltermpercentage WHERE classid = :classid';
    $query7864 = $conn->prepare($validation101);
    $query7864->execute(array(
        ':classid' => $_POST['fclassid'],
    ));
    if ($query7864->rowCount() > 0) {
        if ($_POST['midtermresult'] === '' || $_POST['fintermresult'] === '') {
            echo "<script>alert(\"Terms must be evaluated to finalize the student's grade.\");</script>";
        } else {

            $fetchpassinggrade='SELECT *FROM tbltermpercentage WHERE classid = :classid';
            $stmt=$conn->prepare($fetchpassinggrade);
            $stmt->execute(array(
                ':classid'=>$_POST['fclassid'],
            ));

            if ($stmt->rowCount()>0){
                $tbltermpercentage=$stmt->fetch();
                $passinggrade=$tbltermpercentage[4];

                if ($passinggrade === '0.60'){
                    // cedie's mathematics 101
                    $finave = ($_POST['midtermresult'] * ($_POST['midtermperc'] / 100)) + ($_POST['fintermresult'] * ($_POST['fintermperc'] / 100));
// cedie's mathematics 101

//conversion of equivalence 60% passing
                    if ($finave <= 100 && $finave >= 97) {
                        $equivalent = '1.00';
                    } elseif ($finave < 97 && $finave >= 93) {
                        $equivalent = '1.25';
                    } elseif ($finave < 93 && $finave >= 89) {
                        $equivalent = '1.50';
                    } elseif ($finave < 89 && $finave >= 85) {
                        $equivalent = '1.75';
                    } elseif ($finave < 85 && $finave >= 81) {
                        $equivalent = '2.00';
                    } elseif ($finave < 81 && $finave >= 78) {
                        $equivalent = '2.25';
                    } elseif ($finave < 78 && $finave >= 74) {
                        $equivalent = '2.50';
                    } elseif ($finave < 74 && $finave >= 71) {
                        $equivalent = '2.75';
                    } elseif ($finave < 71 && $finave >= 60) {
                        $equivalent = '3.00';
                    } else {
                        $equivalent = '5.00';
                    }
//conversion of equivalence

                    if ($equivalent <= 3.00) {
                        $remarks = 'PASSED';
                    } else {
                        $remarks = 'FAILED';
                    }
                }elseif ($passinggrade === '0.75'){
                    // cedie's mathematics 101
                    $finave = ($_POST['midtermresult'] * ($_POST['midtermperc'] / 100)) + ($_POST['fintermresult'] * ($_POST['fintermperc'] / 100));
// cedie's mathematics 101

//conversion of equivalence 75% passing
                    if ($finave <= 100 && $finave >= 96) {
                        $equivalent = '1.00';
                    } elseif ($finave < 96 && $finave >= 94) {
                        $equivalent = '1.25';
                    } elseif ($finave < 94 && $finave >= 91) {
                        $equivalent = '1.50';
                    } elseif ($finave < 91 && $finave >= 89) {
                        $equivalent = '1.75';
                    } elseif ($finave < 89 && $finave >= 86) {
                        $equivalent = '2.00';
                    } elseif ($finave < 86 && $finave >= 83) {
                        $equivalent = '2.25';
                    } elseif ($finave < 83 && $finave >= 80) {
                        $equivalent = '2.50';
                    } elseif ($finave < 80 && $finave >= 77) {
                        $equivalent = '2.75';
                    } elseif ($finave < 77 && $finave >= 75) {
                        $equivalent = '3.00';
                    } else {
                        $equivalent = '5.00';
                    }
//conversion of equivalence

                    if ($equivalent <= 3.00) {
                        $remarks = 'PASSED';
                    } else {
                        $remarks = 'FAILED';
                    }
                }

                $setrecord = 'UPDATE tblevaluatedgrade SET remarks = :remarks, finalgrade = :finalgrade, equivalent = :equivalent
                   WHERE classid = :classid AND studregno = :studregno';
                $query101 = $conn->prepare($setrecord);
                $query101->execute(array(
                    ':classid' => $_POST['fclassid'],
                    ':studregno' => $_POST['fstudregno'],
                    ':remarks' => $remarks,
                    ':finalgrade' => $finave,
                    ':equivalent' => $equivalent,
                ));
                if ($query101) {
                    echo "<script>alert(\"student's grade was finalized.\");</script>";
                    echo "<script>document.getElementById('resulthere').style.display='block'</script>";
                    echo 'final average: ' . $finave .'%'. '<br>' . 'equivalent: ' . $equivalent . '<br>' . 'remarks: ' . $remarks;
                    //sms notifies here
                }

            }

        }
    }else{
        echo "<script>alert('Set term percentages first.');</script>";
    }
}


//incomplete assessed here
if(isset($_POST['inc'])) {
    $validationfornoobs='SELECT *FROM tblgradingsetting WHERE classid = :classid';
    $query786 = $conn->prepare($validationfornoobs);
    $query786->execute(array(
        ':classid' => $_POST['iclassid'],
    ));
    if ($query786->rowCount()>0) {
        $iremarks = 'INCOMPLETE';
        $ifinalgrade = 0;
        $iequivalent = 0;
        $recordinc = 'SELECT *FROM tblevaluatedgrade WHERE studregno = :studregno AND classid = :classid';
        $query546 = $conn->prepare($recordinc);
        $query546->execute(array(
            ':classid' => $_POST['iclassid'],
            ':studregno' => $_POST['istudregno'],
        ));
        if ($query546->rowCount() > 0) {
            $updateexisting = 'UPDATE tblevaluatedgrade SET remarks = :remarks, finalgrade = :finalgrade, equivalent = :equivalent
                WHERE classid = :classid AND studregno = :studregno';
            $query5464 = $conn->prepare($updateexisting);
            $query5464->execute(array(
                ':classid' => $_POST['iclassid'],
                ':studregno' => $_POST['istudregno'],
                ':remarks' => $iremarks,
                ':finalgrade' => $ifinalgrade,
                ':equivalent' => $iequivalent,
            ));
            if ($query5464) {
                echo "<script>alert('Student marked having an incomplete grade.');</script>";
                echo "<script>document.getElementById('resulthere').style.display='block';</script>";
                echo 'Remarks: ' . $iremarks;


            }

        } else {
            $insertrecinc = "INSERT INTO tblevaluatedgrade
                       VALUES ('" . $_POST['istudregno'] . "','" . $_POST['iclassid'] . "', '0', '0', '$iremarks', '$ifinalgrade', '$iequivalent')";
            if ($conn->query($insertrecinc)) {
                echo "<script>alert('Student marked having an incomplete grade.');</script>";
                echo "<script>document.getElementById('resulthere').style.display='block';</script>";
                echo 'Remarks: ' . $iremarks;
            }
        }

    }else{
        echo "<script>alert('It seems you have not conducted any assessment. This option is unavailable.');</script>";
    }
}
//incomplete assessment ends here. . . .


//drop student
if(isset($_POST['drop'])) {
    $validation101fornoobs = 'SELECT *FROM tblgradingsetting WHERE classid = :classid';
    $query786 = $conn->prepare($validation101fornoobs);
    $query786->execute(array(
        ':classid' => $_POST['dclassid'],
    ));
    if ($query786->rowCount() > 0) {
        $dremarks = 'DROPPED';
        $dfinalgrade = 0;
        $dequivalent = 0;
        $recorddrop = 'SELECT *FROM tblevaluatedgrade WHERE studregno = :studregno AND classid = :classid';
        $query546 = $conn->prepare($recorddrop);
        $query546->execute(array(
            ':classid' => $_POST['dclassid'],
            ':studregno' => $_POST['dstudregno'],
        ));
        if ($query546->rowCount() > 0) {
            $updateexisting = 'UPDATE tblevaluatedgrade SET remarks = :remarks, finalgrade = :finalgrade, equivalent = :equivalent
                WHERE classid = :classid AND studregno = :studregno';
            $query5464 = $conn->prepare($updateexisting);
            $query5464->execute(array(
                ':classid' => $_POST['dclassid'],
                ':studregno' => $_POST['dstudregno'],
                ':remarks' => $dremarks,
                ':finalgrade' => $dfinalgrade,
                ':equivalent' => $dequivalent,
            ));
            if ($query5464) {
                echo "<script>alert('The student has been dropped.');</script>";
                echo "<script>document.getElementById('resulthere').style.display='block';</script>";
                echo 'Remarks: ' . $dremarks;
            }

        } else {
            $insertrecdrop = "INSERT INTO tblevaluatedgrade
                       VALUES ('" . $_POST['dstudregno'] . "','" . $_POST['dclassid'] . "', '0', '0', '$dremarks', '$dfinalgrade', '$dequivalent')";
            if ($conn->query($insertrecdrop)) {
                echo "<script>alert('The student has been dropped.');</script>";
                echo "<script>document.getElementById('resulthere').style.display='block';</script>";
                echo 'Remarks: ' . $dremarks;

            }
        }

    }else{
        echo "<script>alert('It seems you have not conducted any assessment. This option is unavailable.');</script>";
    }
}
//dropping student ends here



//grade finalization ends here bitch

//codes by Cedie .l..
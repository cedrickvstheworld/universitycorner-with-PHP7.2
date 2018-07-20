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
if (isset($_SESSION['user3']))
{
    echo '';

}else{
    header('location:loginpage.php');
}


?>

<?php

$username=$_SESSION['user3'];
$searchid = 'SELECT *FROM tblparent WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblparent = $query->fetch();
    $parentregno = $tblparent[0];
    $parentcontact = $tblparent[13];

}
?>
<!DOCTYPE html>
<html>
<head>
    <title id="parentindex">University Corner</title>
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
                <a class="navbar-brand text-primary" href="#parentindex">University Corner<small id="secondarytext" class="text-muted"> keep learning</small></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pagefont dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="img-responsive" src="images/cog.png"></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" href="#changepmodalparent">Change Password</a></li>
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
    <div class="pagebody pagefont container">

        <div class="col-lg-3">
            <div class="findstud">
            <form action="parentindex.php" method="post">
                <input type="text" class="mobile maxlen6 form-control" name="studcode" placeholder="Student Code" required><br>
                <input type="submit" name="monitor" class="btn btn-success" value="Monitor Student">
                <?php
                //connect to student account
                if(isset($_POST['monitor'])) {
                    $verifystudcode = 'SELECT *FROM tblstudent WHERE studcode = :studcode';
                    $query7878 = $conn->prepare($verifystudcode);
                    $query7878->execute(array(
                        ':studcode' => $_POST['studcode'],
                    ));
                    if ($query7878->rowCount() > 0) {
                        $tblstud = $query7878->fetch();
                        $studregno = $tblstud[0];

                        $verifyexistence='SELECT *FROM tblclass_parent WHERE parentregno = :parentregno
                                           AND studregno = :studregno';
                        $query12=$conn->prepare($verifyexistence);
                        $query12->execute(array(
                           ':parentregno'=>$parentregno,
                           ':studregno'=>$studregno,
                        ));
                        if($query12->rowCount()===0) {
                            $verifytblclassstud='SELECT *FROM tblclass_student WHERE studregno = :studregno';
                            $query909=$conn->prepare($verifytblclassstud);
                            $query909->execute(array(
                                    ':studregno'=>$studregno,
                            ));
                            if($query909->rowCount()>0) {
                                $connectparent = "INSERT INTO tblclass_parent 
                                        VALUES ('$studregno', '$parentregno')";
                                if ($conn->query($connectparent)) {
                                        echo "<script>alert('You can now monitor the student.');</script>";
                                        echo "<script>window.top.location='parentindex.php';</script>";
                                }
                            }else{
                                echo "<script>alert('This Student does not belong to any class yet.');</script>";
                                echo "<script>document.getElementById('studcode').value='';</script>";
                            }
                        }else{
                            echo "<script>alert('The student was already in your monitored list.');</script>";
                            echo "<script>window.top.location='parentindex.php';</script>";
                        }

                    } else {
                        echo "<script>alert('Invalid Student Code. There is no existing student account with that code');</script>";
                        echo "<script>window.top.location='parentindex.php';</script>";
                    }
                }
                //connect to student account
                ?>
            </form>
            </div>
            <div class="monitoredstud">
                <h4 class="theadtitle modal-header">Monitored Students</h4>
                <div class="snewsfeeds text-left">
                    <?php
                    //fetch monitored students
                    $fetchmonitoredstud='SELECT tblstudent.fname, tblstudent.mname, tblstudent.lname,tblstudent.studcode,
                                         tblclass_parent.studregno, tblclass_parent.parentregno FROM tblstudent
                                         INNER JOIN tblclass_parent ON tblstudent.studregno = tblclass_parent.studregno
                                         WHERE parentregno = :parentregno';
                    $query5= $conn->prepare($fetchmonitoredstud);
                    $query5->execute(array(
                        ':parentregno'=> $parentregno,
                    ));
                    if($query5->rowCount()===0){
                        echo 'You have no monitored student';

                    }else{
                        echo '<div class="generalrecordheader2">';
                        echo '<table class="table">';
                        echo '<tr>';
                        echo '<th style="width: 120px">Name</th>';
                        echo '<th>Student Code</th>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';

                        echo '<div class="listblock2">';
                        echo '<table class="classlistbody2 table">';
                        while($result= $query5->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td style="width: 150px; font-weight: bold; font-size: 15px;" >';
                            echo "<a href=\"parentview.php?studregno=$result[studregno]\" class=\"btn-link text-capitalize\">";
                            echo $result['fname'].' '.$result['lname'];
                            echo '</a>';
                            echo '</td>';
                            echo '<td class="text-right">'.$result['studcode'].'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                    }
                    //fetch monitored students
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="text-left" >
                <!--student feeds-->
                <?php
                $fetchstudentrecs='SELECT tblstudent.fname, tblstudent.mname, tblstudent.lname,tblstudent.studcode,
                                   tblclass_parent.studregno, tblclass_parent.parentregno FROM tblstudent
                                   INNER JOIN tblclass_parent ON tblstudent.studregno = tblclass_parent.studregno
                                   WHERE parentregno = :parentregno';
                $query20=$conn->prepare($fetchstudentrecs);
                $query20->execute(array(
                        ':parentregno'=>$parentregno,
                ));
                if($query20->rowCount()===0){
                    echo 'no records to show';
                }else{
                    echo '<table id="table_id6" class="display table" cellspacing="0" width="100%">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="text-info">Report Cards</th>';
                    echo '</tr>';
                    echo '</thead>';

                    echo '<tbody>';

                    while($result= $query20->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr>';
                        echo '<td>';
                        echo '<div class="shityrec well">';
                        //header
                        echo '<div class="col-lg-8">';
                        echo '<h4 class="text-capitalize text-success">'.$result['fname'].' '.$result['mname'].' '.$result['lname'].'</h4>';
                        echo '</div>';
                        echo '<div class="col-lg-4 text-right">';
                        echo '<h4 class="text-info">'.$result['studcode'].'</h4>';
                        echo '</div>';
                        //header
                        echo '<div>';
                        //body
                        $fetchclassrecs='SELECT tblclass.subjectdesc, tblevaluatedgrade.midterm,tblevaluatedgrade.finalterm,
                                         tblevaluatedgrade.remarks,tblevaluatedgrade.finalgrade,tblevaluatedgrade.equivalent,
                                         tblevaluatedgrade.studregno FROM tblevaluatedgrade INNER JOIN tblclass
                                         ON tblevaluatedgrade.classid = tblclass.classid
                                         WHERE studregno = :studregno AND remarks IS NOT NULL';
                        $query201=$conn->prepare($fetchclassrecs);
                        $query201->execute(array(
                                ':studregno'=>$result['studregno'],
                        ));
                        if ($query201->rowCount()===0){
                            echo 'no records';
                        }else{
                            echo '<div class="">';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<h5 class="textp">Report Card</h5>';
                            echo '<table class="table table-striped">';
                            echo '<tr>';
                            echo '<th class="text-info">Subject</th>';
                            echo '<th class="text-info">Mid Term</th>';
                            echo '<th class="text-info">Final Term</th>';
                            echo '<th class="text-info">Remarks</th>';
                            echo '<th class="text-info">Final Grade</th>';
                            echo '<th class="text-info">Equivalent</th>';
                            echo '</tr>';

                            echo '</div>';

                            echo '<div class="">';

                            while($result55=$query201->fetch(PDO::FETCH_ASSOC)){
                                //record table
                                echo '<tr>';
                                echo '<td style="width:">';
                                echo $result55['subjectdesc'];
                                echo '</td>';
                                echo '<td style="width:">';
                                echo $result55['midterm'].'%';
                                echo '</td>';
                                echo '<td style="width: ">';
                                echo $result55['finalterm'].'%';
                                echo '</td>';
                                echo '<td style="width: ">';
                                echo $result55['remarks'];
                                echo '</td>';
                                echo '<td style="width: ">';
                                echo $result55['finalgrade'].'%';
                                echo '</td>';
                                echo '<td style="width: ">';
                                echo $result55['equivalent'];
                                echo '</td>';
                                echo '</tr>';
                                //record table
                            }

                            echo '</table>';
                            echo '</div>';
                            echo '<br>';
                        }
                        //body
                        echo '</div>';
                        echo '</div>';
                        echo '<br>';


                        echo '</td>';
                        echo '</tr>';

                    }
                    echo '</tbody>';
                    echo '</table>';
                }
                ?>
                <!--student feeds-->
                <br><br>
            </div>

        </div>

        <div class="col-lg-3">
            <!--profile-->
            <div class="profileparent text-right">
                <!--profile picture-->
                <?php
                $retrieveimg='SELECT *FROM tblparent WHERE parentregno = :parentregno';
                $stmt=$conn->prepare($retrieveimg);
                $stmt->execute(array(
                    ':parentregno' => $parentregno,
                ));
                if($stmt->rowCount()>0){
                    $tblparent=$stmt->fetch();
                    $img=$tblparent['parentimg'];
                    if($img !== null){
                        echo "<img src=\"profilepics/$img\" class='profiledefault img-rounded'>";
                    }else{
                        echo '<img src="img/profiledefault.jpg" class="profiledefault img-rounded">';
                    }
                }
                ?>
                <!--profile picture-->
                <?php
                $fetchprofile='SELECT *FROM tblparent WHERE parentregno = :parentregno';
                $query56=$conn->prepare($fetchprofile);
                $query56->execute(array(
                    ':parentregno'=>$parentregno,
                ));
                if($query56->rowCount()>0){
                    $tblparent=$query56->fetch();
                    $name=$tblparent[1].' '.$tblparent[2].' '.$tblparent[3];
                    $address=$tblparent[4];
                    $birthday=$tblparent[10].'-'.$tblparent[11].'-'.$tblparent[12];
                    $contactn=$tblparent[13];

                    //display info here

                    echo '<h5 class="text-capitalize">'.$name.'</h5>';
                    echo '<h5 class="text-capitalize">'.$address.'</h5>';
                    echo '<h5>'.$birthday.'</h5>';
                    echo '<h5>'.$contactn.'</h5>';
                }
                ?>
            </div>
            <!--profile-->
        </div>

    </div>
</div>


<!--main body-->




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


<!--change profile photo modal-->
<div id="changeppmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="parentindex.php" enctype="multipart/form-data" method="post">
            <h3 class="modal-header">Select New Profile Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                </div>
                <div class="col-lg-6">

                    <img id="blah" src="<?php

                    $retrieveimg = 'SELECT *FROM tblparent WHERE parentregno = :parentregno';
                    $stmt = $conn->prepare($retrieveimg);
                    $stmt->execute(array(
                        ':parentregno' => $parentregno,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblparent = $stmt->fetch();
                        $img = $tblparent['parentimg'];
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
                    $uploadimg="UPDATE tblparent SET parentimg = :img WHERE parentregno = :parentregno";
                    $stmt= $conn->prepare($uploadimg);
                    $stmt->execute(array(
                        ':img'=>$picProfile ,
                        ':parentregno'=> $parentregno,
                    ));
                    if ($stmt) {
                        echo '<script>window.top.location = "parentindex.php";</script>';
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

<!--changepmodal-->
<div id="changepmodalparent" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod0();" title="Close" class="close">X</a>
        <h3 class="modal-header">Change Password</h3>
        <form action="editparentaccount.php" method="post">
            <input type="hidden" id="parentregnop" name="parentregnop" value="<?php echo $parentregno; ?>">
            <input type="password" class="maxlen40 form-control" id="currentp" name="currentp" placeholder="Current Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="newp" name="newp" placeholder="New Password" required>
            <br>
            <input type="password" class="maxlen40 form-control" id="confirmnewp" name="confirmnewp" placeholder="Confirm New Password" required>
            <br>
            <div class="text-right">
                <button id= "show_password" class="btn btn-secondary" type="button">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </button>
                <input type="button" class="btn btn-success" onclick="fncchangepparent();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod89();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="parentregnoup" name="parentregnoup" value="<?php echo $parentregno; ?>">
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
                <label>Birthday</label>
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
                <input type="text" class="maxlen11 form-control" id="ncontact" name="ncontact" placeholder="Contact">
            </div>
            <div class="col-lg-8 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfo56();" id="updateinfo" name="updateinfo" value="Update">
            </div>
            <br><br>
            <div id="show2"></div>
        </form>

    </div>
</div>

<!--editaccountmodal-->



<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="cediescripts.js"></script>
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="DataTables-1.10.16/media/js/jquery.dataTables.min.js"></script>
<script src="DataTables-1.10.16/media/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
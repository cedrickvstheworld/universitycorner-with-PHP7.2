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
if (isset($_SESSION['user2']))
{
    echo '';

}else{
    header('location:loginpage.php');
}


?>

<?php

$username=$_SESSION['user2'];
$studregno='';
$searchid = 'SELECT *FROM tblstudent WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblstudent = $query->fetch();
    $studregno=$tblstudent[0];
    $studcode=$tblstudent[15];

}
?>


<!DOCTYPE html>
<html>
<head>
    <title id="studentindex">University Corner</title>
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
                <a class="navbar-brand text-primary" href="#studentindex">University Corner<small id="secondarytext" class="text-muted"> keep learning</small></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
    <div class="pagebody pagefont container">

        <div class="col-lg-3">
            <div class="leftcol">

                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" ><input type="button" class="btn btn-success"
                                                    data-toggle="modal" href="#joinclassmodal" value="Join Class"></li>
                </ul>
                <br>
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" ><input type="button" class="btn btn-info"
                                                    data-toggle="modal" href="#studcodemod" value="Show Student Code"></li>
                </ul>
                <br>
                <?php
                echo '<h5>'.'Student Reg No: '.$studregno.'</h5>'.'<br>';
                ?>
            </div>
            <div class="classesshere2">
                <h3 class="theadtitle modal-header">Classes</h3>
                <div class="">
                    <form action="classplatform.php" method="post">

                        <?php

                        $classinfo='SELECT tblclass_student.studregno,tblclass.classid,tblclass.classcode,tblclass.subjectdesc
                                    FROM tblclass_student INNER JOIN tblclass ON tblclass_student.classid = tblclass.classid
                                    WHERE studregno = :studregno';
                        $query5= $conn->prepare($classinfo);
                        $query5->execute(array(
                            ':studregno'=> $studregno,
                        ));
                        if($query5->rowCount()===0){
                            echo 'You did not join any classes';

                        }else{
                            echo '<div class="generalrecordheader">';
                            echo '<table class="table">';
                            echo '<tr>';
                            echo '<th class="text-info" style="width: 120px">Class</th>';
                            echo '<th class="text-info">Class Code</th>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</div>';

                            echo '<div class="listblock">';
                            echo '<table class="classlistbody table">';
                            while($result= $query5->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr>';
                                echo '<td style="width: 120px">';
                                $classcode=$result['classcode'];
                                echo " <a href=\"studentview.php?classcode=$classcode\" class=\"celltext btn-sm btn text-success\">".$result['subjectdesc']. '</a>';
                                echo '</td>';
                                echo '<td class="text-right">'.$result['classcode'].'</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '</div>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="snewsfeeds text-left" >
                <!--news feeds-->
                <?php
                $fetchfeeds='SELECT tblclass_student.classid,tblclass_student.studregno,tblpost.postbody,
                             tblpost.type,tblpost.posttime,tblpost.postdate,tblpost.subject FROM tblpost
                             INNER JOIN tblclass_student ON tblpost.classid = tblclass_student.classid 
                             WHERE studregno = :studregno ORDER BY postdate DESC , posttime DESC';
                $query435=$conn->prepare($fetchfeeds);
                $query435->execute(array(
                    ':studregno' => $studregno,
                ));
                if($query435->rowCount()>0){

                    echo '<br>';
                    echo '<table id="table_id5" class="display table" cellspacing="0" width="100%">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="text-info"></th>';
                    echo '</tr>';
                    echo '</thead>';

                    echo '<tbody>';

                    while($result= $query435->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<tr>';
                        echo '<td>';
                        echo '<div class="well feedscontent">';
                        echo '<h4 class="text-info">'.$result['subject'].'</h4>';
                        echo '<p>'.$result['postbody'].'</p>';
                        echo '<div class="feedinfo col-sm-4">';
                        echo '<h5 class="text-info">'.$result['type'].'</h5>';
                        echo '</div>';
                        echo '<div class="feedinfo col-sm-8">';
                        echo '<h5 class="text-success text-right">'.$result['postdate'].' '.$result['posttime'].'</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '<br>';
                        echo '<br>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                }else{
                    echo 'You have no Feeds.';
                }

                ?>
                <!--news feeds-->
                <br><br>

            </div>

        </div>

        <div class="col-lg-3">
            <!--profile-->
            <div class="profile text-right">
                <!--profile picture-->
                <?php
                $retrieveimg='SELECT *FROM tblstudent WHERE studregno = :studregno';
                $stmt=$conn->prepare($retrieveimg);
                $stmt->execute(array(
                    ':studregno' => $studregno,
                ));
                if($stmt->rowCount()>0){
                    $tblstudent=$stmt->fetch();
                    $img=$tblstudent['studentimg'];
                    if($img !== null){
                        echo "<img src=\"profilepics/$img\" class='profiledefault img-rounded'>";
                    }else{
                        echo '<img src="img/profiledefault.jpg" class="profiledefault img-rounded">';
                    }
                }
                ?>
                <!--profile picture-->
                <?php
                $fetchprofile='SELECT *FROM tblstudent WHERE studregno = :studregno';
                $query56=$conn->prepare($fetchprofile);
                $query56->execute(array(
                    ':studregno'=>$studregno,
                ));
                if($query56->rowCount()>0){
                    $tblstudent=$query56->fetch();
                    $name=$tblstudent[1].' '.$tblstudent[6].' '.$tblstudent[2];
                    $address=$tblstudent[5];
                    $birthday=$tblstudent[12].'-'.$tblstudent[13].'-'.$tblstudent[14];
                    $contactn=$tblstudent[4];

                    //display info here

                    echo '<h5 class="text-capitalize">'.$name.'</h5>';
                    echo '<h5 class="text-capitalize">'.$address.'</h5>';
                    echo '<h5>'.$birthday.'</h5>';
                    echo '<h5>'.$contactn.'</h5>';
                }
                ?>
            </div>
            <!--profile-->
            <!--gradelist-->
            <br><br>
         <div class="gradelist">
             <h3 class="classmark modal-header">Class Marks</h3>
             <?php
               $fetchmarks='SELECT tblclass.subjectdesc,tblevaluatedgrade.remarks, 
                            tblevaluatedgrade.classid,tblevaluatedgrade.studregno
                            FROM tblclass INNER JOIN tblevaluatedgrade
                            ON tblclass.classid = tblevaluatedgrade.classid
                            WHERE studregno = :studregno AND remarks IS NOT NULL ';
               $query22=$conn->prepare($fetchmarks);
               $query22->execute(array(
                  ':studregno'=>$studregno,
               ));
               if($query22->rowCount()===0){
                   echo 'no records';
               }else{
                   echo '<div class="glbody">';
                   echo '<table class="glscroll table">';
                   while($result= $query22->fetch(PDO::FETCH_ASSOC)) {
                       echo '<tr>';
                       echo '<td style="width: 120px">'.$result['subjectdesc'].'</td>';
                       echo '<td class="text-right">'.$result['remarks'].'</td>';
                       echo '</tr>';
                   }
                   echo '</table>';
                   echo '</div>';
               }


             ?>
         </div>
            <!--gradelist-->
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


<!--modals-->

<!--change profile photo modal-->
<div id="changeppmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="studentindex.php" enctype="multipart/form-data" method="post">
            <h3 class="modal-header">Select New Profile Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                </div>
                <div class="col-lg-6">

                    <img id="blah" src="<?php

                    $retrieveimg = 'SELECT *FROM tblstudent WHERE studregno = :studregno';
                    $stmt = $conn->prepare($retrieveimg);
                    $stmt->execute(array(
                        ':studregno' => $studregno,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblstudent = $stmt->fetch();
                        $img = $tblstudent['studentimg'];
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
                    $uploadimg="UPDATE tblstudent SET studentimg = :img WHERE studregno = :studregno";
                    $stmt= $conn->prepare($uploadimg);
                    $stmt->execute(array(
                        ':img'=>$picProfile ,
                        ':studregno'=> $studregno,
                    ));
                    if ($stmt) {
                        echo '<script>window.top.location = "studentindex.php";</script>';
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

<!--joinclassmodal-->
<div id="joinclassmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="studentindex.php" method="post">
        <h3 class="modal-header">Join a Class</h3>
            <div class="text-center">
            <input type="text" class="mobile maxlen6 form-group input-sm" placeholder="enter class code here" name="classcode" required>
        <input type="submit" id="joinbtn" class="btn btn-success" name="join" value="Join">
            </div>
        </form>
    </div>
</div>
<?php
//join class
if (isset($_POST['join'])) {
    $classcode = $_POST['classcode'];
    $validate = 'SELECT *FROM tblclass WHERE classcode=:classcode';
    $query45 = $conn->prepare($validate);
    $query45->execute(array(
        ':classcode' => $classcode,
    ));
    $result34 = $query45->fetch(PDO::FETCH_ASSOC);
    $classid = $result34['classid'];

    if ($query45->rowCount() > 0) {
        $validate23 = 'SELECT *FROM tblclass_student WHERE studregno  = :studregno AND classid = :classid';
        $query76 = $conn->prepare($validate23);
        $query76->execute(array(
            ':classid' => $classid,
            ':studregno' => $studregno,
        ));

        if ($query76->rowCount() === 0) {
            $joinclass = "insert into tblclass_student (studregno, classid) VALUES ($studregno, $classid)";
            if ($conn->query($joinclass)) {
                echo '<script>alert("you have joined a new class");</script>';
                echo "<script>window.top.location='studentindex.php';</script>";
                exit;
            } }
            else {
                echo '<script>alert("you are already in this class");</script>';
                echo "<script>window.top.location='studentindex.php';</script>";
                exit;
            }

        } else {
            echo '<script>alert("invalid class code, please ask the correct class code to your corresponding instructor");</script>';
            echo "<script>window.top.location='studentindex.php';</script>";
            exit;
        }

    }

 //join class


?>
<!--joinclassmodal-->

<!--studcodemod-->
<div id="studcodemod" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="studentindex.php" method="post">
            <h3 class="modal-header">
                <?php
                echo $studcode;
                ?>
            </h3>
            <div class="text-center">
            <p>So what is the use of this thingy?<br>
            Student Code is a unique serial number of yours to link your account to your parent's account.</p>
            </div>
        </form>
    </div>
</div>
<!--studcodemod-->


<!--changepmodal-->
<div id="changepmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod4();" title="Close" class="close">X</a>
        <h3 class="modal-header">Change Password</h3>
        <form action="editstudentaccount.php" method="post">
            <input type="hidden" id="studregnop" name="studregnop" value="<?php echo $studregno; ?>">
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
                <input type="button" class="btn btn-success" onclick="fncchangepstud();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod9();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editstudentaccount.php" method="post">
            <input type="hidden" id="studregnop" name="studregnop" value="<?php echo $studregno; ?>">
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
            <div class="col-lg-4">
                <input type="number" class="mobile maxlen11 form-control" id="ngcontact" name="ngcontact" placeholder="Guardian Contact">
            </div>
            <div class="col-lg-4 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfostud();" id="updateinfo" name="updateinfo" value="Update">
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
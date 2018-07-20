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
if (isset($_SESSION['user']))
{
    echo '';

}else{
    header('location:loginpage.php');
}
?>
<?php
$username=$_SESSION['user'];
$insregno='';
$searchid = 'SELECT *FROM tblinstructor WHERE username = :username ';
$query=$conn->prepare($searchid);
$query->execute(array(
    ':username'=> $username,
));
if ($query->rowCount()>0) {

    $tblinstructor = $query->fetch();
    $insregno = $tblinstructor[0];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title id="educatorindex">University Corner</title>
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
            <a class="navbar-brand text-primary" href="#educatorindex">University Corner<small id="secondarytext" class="text-muted"> keep learning</small></a>
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


<!--page body-->
<div class="bodyscroll">
    <div class="pagebody pagefont container">

        <div class="col-lg-3">
            <div>
                <ul class="classset nav nav-pills nav-stacked well">
                    <li role="presentation" ><a class="text-info" data-toggle="modal" href="#createclassmodal">Create a Class</a></li>
                    <li role="presentation" ><a class="text-info" data-toggle="modal" href="#gradingsetting">Grading Setting</a></li>
                    <li role="presentation" ><a class="text-info" data-toggle="modal" href="#setscoreboard">Set Scoreboard</a></li>
                    <li role="presentation" ><a class="text-info" data-toggle="modal" href="#settermpercentages">Set Term Percentages</a></li>
                </ul>
            </div>
            <div class="classesshere">
                <h3 class="theadtitle modal-header">Your Classes</h3>
                <div class="">
                    <form action="classplatform.php" method="post">

                            <?php

                            $classinfo='select *from tblclass where insregno = :insregno';
                            $query5= $conn->prepare($classinfo);
                            $query5->execute(array(
                                ':insregno'=> $insregno,
                            ));
                            if($query5->rowCount()===0){
                                echo 'You have no classes';

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
                                    echo " <a href=\"classplatform.php?classcode=$classcode\" class=\"celltext btn-sm btn text-success\">".$result['subjectdesc']. '</a>';
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

         <!--create post-->
        <div class="col-lg-6">
            <form action="posting.php" method="post">
                <div class="top">
            <div class="postbox">

                <div class="form-group">
                    <textarea id="postbody" name="postbody" maxlength="255" type="text" class="memo form-control" rows="4"
                              placeholder="Tell them something to do." required><?php
                        if(isset($_GET['postid'])){
                            $postid=$_GET['postid'];
                            $fetchpostinfo='SELECT *FROM tblpost WHERE postid = :postid';
                            $stmt=$conn->prepare($fetchpostinfo);
                            $stmt->execute(array(
                               ':postid'=>$postid,
                            ));
                            if($stmt->rowCount()>0){
                                $tblpost=$stmt->fetch(PDO::FETCH_ASSOC);
                                $postbody=$tblpost['postbody'];
                                echo  $postbody;
                            }
                        }
                        ?></textarea>

                </div>

            </div>
                <div class="col-lg-6">
                    <label><select id="type" name="type" class="input-sm">
                            <option>Assignment</option>
                            <option>Quiz Notice</option>
                            <option>Project</option>
                            <option>Examination</option>
                            <option>Pointers</option>
                        </select></label>
                </div>
                <div class="col-lg-6 text-right">
                    <?php
                    if(isset($_GET['postid'])){
                        echo "<input type='hidden' id='postid' value=\"$_GET[postid]\">";
                        echo '<input class="btn-danger btn" id="cancelupdate" name="cancelupdate" onclick="window.top.location = \'educatorindex.php\';" type="button" value="Cancel">'.' ';

                        echo '<input class="btn-primary btn" id="btnupdatepost" name="btnupdatepost" onclick="updatepost();" type="button" value="Update Post">';
                    }else{
                        echo '<input type="text" class="maxlen6 mobile sclasscode input-sm" id="classcodep" name="classcodep" placeholder="Class Code" required>'.' ';
                        echo '<input class="btn-success btn" id="post" name="post" onclick="postthis();" type="button" value="Post">';
                    }
                    ?>
                </div>
                    <input type="hidden" id="insregnopost" name="insregnopost" value="<?php echo $insregno; ?>" >
                    </div><div id="posting"></div>

            </form><br>
            <div class="newsfeeds text-left" >
                <!--news feeds-->
                <?php
                $fetchfeeds='SELECT *FROM tblpost WHERE insregno = :insregno 
                             ORDER BY postdate DESC, posttime DESC';
                $query435=$conn->prepare($fetchfeeds);
                $query435->execute(array(
                   ':insregno' => $insregno,
                ));
                if($query435->rowCount()>0){
                    echo '<br>';
                    echo '<table id="table_id4" class="display table" cellspacing="0" width="100%">';
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
                        echo '<div class="col-lg-12 well feedscontent">';
                        echo '<div class="col-lg-11">';
                        echo '<h4 class="text-info">'.$result['subject'].'</h4>';
                        echo '</div>';
                        echo '<div class="col-lg-1">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><input type="button" class="btn btn-info btn-sm" value="..."></a>';
                        echo '<ul class="dropdown-menu dropdown-menu-right">';
                        echo "<li><a href=\"educatorindex.php?postid=$result[postid]\">Update Post</a></li>";
                        echo "<li><a title=\"The post will be deleted and won't be able to seen by anyone nor you can retrieve it.\" href=\"postoptions.php?postid=$result[postid]\">Delete Post</a></li>";
                        echo '</ul>';
                        echo '</div>';
                        echo '<div class="col-lg-12">';
                        echo '<p id="postbodyxxx">'.$result['postbody'].'</p>';
                        echo '</div>';
                        echo '<div class="col-sm-4">';
                        echo '<h5 class="text-muted">'.$result['type'].'</h5>';
                        echo '</div>';
                        echo '<div class="col-sm-8">';
                        echo '<h5 class="text-success text-right">'.$result['postdate'].' '.$result['posttime'].'</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
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
        <!--create post-->

        <div class="col-lg-3">
            <div class="profile text-right">
                <!--profile picture-->
                <?php
                $retrieveimg='SELECT *FROM tblinstructor WHERE insregno = :insregno';
                $stmt=$conn->prepare($retrieveimg);
                $stmt->execute(array(
                    ':insregno' => $insregno,
                ));
                if($stmt->rowCount()>0){
                   $tblinstructor=$stmt->fetch();
                   $img=$tblinstructor['insimg'];
                   if($img !== null){
                       echo "<img src=\"profilepics/$img\" class='profiledefault img-rounded'>";
                   }else{
                       echo '<img src="img/profiledefault.jpg" class="profiledefault img-rounded">';
                   }
                }
                ?>
                <!--profile picture-->
                <?php
                $fetchprofile='SELECT *FROM tblinstructor WHERE insregno = :insregno';
                $query56=$conn->prepare($fetchprofile);
                $query56->execute(array(
                        ':insregno'=>$insregno,
                ));
                if($query56->rowCount()>0){
                    $tblinstructor=$query56->fetch();
                    $name=$tblinstructor[1].' '.$tblinstructor[2].' '.$tblinstructor[3];
                    $address=$tblinstructor[4];
                    $birthday=$tblinstructor[10].'-'.$tblinstructor[11].'-'.$tblinstructor[12];
                    $contactn=$tblinstructor[13];

                    //display info here

                    echo '<h5 class="text-capitalize">'.$name.'</h5>';
                    echo '<h5 class="text-capitalize">'.$address.'</h5>';
                    echo '<h5>'.$birthday.'</h5>';
                    echo '<h5>'.$contactn.'</h5>';
                }
                ?>
            </div>
                <div class="pinnedlist well">
                    <h3 class="modal-header">Reminder</h3>
                    <?php
                    $fetchdeadlines='SELECT tblclass.insregno,tblclass.subjectdesc,tbltermpercentage.classid,tbltermpercentage.submissiondate
                                     FROM tbltermpercentage INNER JOIN tblclass ON tbltermpercentage.classid = tblclass.classid 
                                     WHERE insregno = :insregno';
                    $query222=$conn->prepare($fetchdeadlines);
                    $query222->execute(array(
                            ':insregno'=>$insregno,
                    ));
                    if($query222->rowCount()===0){
                        echo 'There is no Due';

                    }else{
                        echo '<div class="text-center">';
                        echo '<table>';
                        echo '<thead class="theadtitle text-info">';
                        echo '<tr>';
                        echo '<td style="width: 100px; text-align: left;">Subject</td>';
                        echo '<td style="width: 160px;">Due Date</td>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '</table>';
                        echo '</div>';

                        echo '<div class="text-center">';
                        echo '<table class="block">';
                        while($result= $query222->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tb>';
                            echo '<tr>';
                            echo '<td style="width: 100px; text-align: left;">'.$result['subjectdesc'].'</td>';
                            echo '<td style="width: 160px;">'.$result['submissiondate'].'</td>';
                            echo '</tr>';
                            echo '</tb>';
                        }
                        echo '</table>';
                        echo '</div>';
                    }

                    ?>
                </div>
            </div>

    </div>
</div>
<!--page body--->

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
        <form action="educatorindex.php" enctype="multipart/form-data" method="post">
            <h3 class="modal-header">Select New Profile Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <input type="file" id="profilepic" onchange="pic();" name="profilepic" class="form-control">
                </div>
                <div class="col-lg-6">

                    <img id="blah" src="<?php

                    $retrieveimg = 'SELECT *FROM tblinstructor WHERE insregno = :insregno';
                    $stmt = $conn->prepare($retrieveimg);
                    $stmt->execute(array(
                        ':insregno' => $insregno,
                    ));
                    if ($stmt->rowCount() > 0) {
                        $tblinstructor = $stmt->fetch();
                        $img = $tblinstructor['insimg'];
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
                        $uploadimg="UPDATE tblinstructor SET insimg = :img WHERE insregno = :insregno";
                        $stmt= $conn->prepare($uploadimg);
                        $stmt->execute(array(
                            ':img'=>$picProfile ,
                            ':insregno'=> $insregno,
                        ));
                        if ($stmt) {
                            echo '<script>window.top.location = "educatorindex.php";</script>';
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

<!--create class modal-->
<div id="createclassmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="educatorindex.php" method="post">
        <h3 class="modal-header">Create a Class</h3>
        <input class="maxlen25 createclass input-sm" name="subjectdesc" placeholder="Subject Description" required>
        <br>
        <br>
         <label class="text-muted">Subject Area:</label>
            <br>
        <label><select name="subjectcode" class="input-sm">
            <option>Engineering</option>
            <option>Arts</option>
            <option>Science</option>
            <option>Education</option>
            <option>Computer Technology</option>
            <option>Literature</option>
            <option>Social Studies</option>
            <option>Tourism</option>
            <option>Mathematics</option>
        </select></label>
            <br>
            <br>
            <div class="modal-footer">
        <input class="btn btn-success" type="submit" name="createclass" value="Create">
            </div>

        </form>
    </div>
</div>

<!--create class modal-->

<!--Grading Setting-->
<div id="gradingsetting" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="configuration.php" method="post">
            <h3 class="modal-header">Grading Setting</h3>
            <input type="hidden" id="insregnogs" value="<?php echo $insregno; ?>">
            <div class="container-fluid">
                <div class="col-lg-4">
            <label class="text-info">Attendance: </label><br><br>
            <label class="text-info">Assignment: </label><br><br>
            <label class="text-info">seatwork: </label><br><br>
            <label class="text-info">Quiz: </label><br><br>
            <label class="text-info">Term Exam: </label><br><br>
            <label class="text-info">Project: </label><br><br>
                </div>
                <div class="col-lg-4">
                    <input class="mobile maxlen2 set input-sm" type="text" id="attendance" name="attendance" placeholder=""> %<br><br>
                    <input class="mobile maxlen2 set input-sm" type="text" id="assignment" name="assignment" placeholder=""> %<br><br>
                    <input class="mobile maxlen2 set input-sm" type="text" id="seatwork" name="seatwork" placeholder=""> %<br><br>
                    <input class="mobile maxlen2 set input-sm" type="text" id="quiz" name="quiz" placeholder=""> %<br><br>
                    <input class="mobile maxlen2 set input-sm" type="text" id="termexam" name="termexam" placeholder=""> %<br><br>
                    <input class="mobile maxlen2 set input-sm" type="text" id="project" name="project" placeholder=""> %<br><br>
                </div>
                <div class="col-lg-4">
                    <label class="text-info">Class Code</label><br>
                    <input class="mobile maxlen6 form-control input-sm" type="text" id="classcode" name="classcode" placeholder="" required>
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-success" type="button" onclick="submitgs();" id="btngradingsetting" name="gradingsetting" value="Set">
            </div>
            <div id="gs"></div>
        </form>
    </div>
</div>


<!--Grading setting modal-->



<!--set scoreboard-->
<div id="setscoreboard" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="configuration.php" method="post">
            <h3 class="modal-header">Set Scoreboard</h3>
            <input type="hidden" id="insregnoss" value="<?php echo $insregno; ?>">
            <div class="container-fluid">
                <div class="col-lg-4">
                    <label class="text-info">Attendance: </label><br><br>
                    <label class="text-info">Assignment: </label><br><br>
                    <label class="text-info">seatwork: </label><br><br>
                    <label class="text-info">Quiz: </label><br><br>
                    <label class="text-info">Term Exam: </label><br><br>
                    <label class="text-info">Project: </label><br><br>
                </div>
                <div class="col-lg-4">
                    <input class="mobile maxlen3 set input-sm" type="text" id="iattendance" name="iattendance" placeholder=""> items<br><br>
                    <input class="mobile maxlen3 set input-sm" type="text" id="iassignment" name="iassignment" placeholder=""> items<br><br>
                    <input class="mobile maxlen3 set input-sm" type="text" id="iseatwork" name="iseatwork" placeholder=""> items<br><br>
                    <input class="mobile maxlen3 set input-sm" type="text" id="iquiz" name="iquiz" placeholder=""> items<br><br>
                    <input class="mobile maxlen3 set input-sm" type="text" id="itermexam" name="itermexam" placeholder=""> items<br><br>
                    <input class="mobile maxlen3 set input-sm" type="text" id="iproject" name="iproject" placeholder=""> items<br><br>
                </div>
                <div class="col-lg-4">
                    <select id="selectterm" name="selectterm" class="input-sm">
                        <option>Mid Term</option>
                        <option>Final Term</option>
                    </select><br><br>
                    <label class="text-info">Class Code</label><br>
                    <input class="mobile maxlen6 form-control input-sm" type="text" id="iclasscode" name="iclasscode" placeholder="" required>
                    <h6 class="text-danger">Updating Scoreboard will delete all the computed records of the selected term.</h6>
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-success" type="button" onclick="submitss();" id="btnsetscoreboard" name="setscoreboard" value="Set">
            </div>
            <div id="ss"></div>
        </form>
    </div>
</div>

<!--set scoreboard-->

<!--Set term percentage modal-->

<div id="settermpercentages" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a href="" title="Close" class="close">X</a>
        <form action="configuration.php" method="post">
            <h3 class="modal-header">Set Percentages</h3>
            <input type="hidden" id="insregnosp" value="<?php echo $insregno; ?>">
            <div class="container-fluid">
                <div class="col-lg-6">
                    <label class="text-info">Mid Term:</label>
                    <input type="text" class="mobile maxlen2 score input-sm" id="midpercent" name="midpercent" placeholder="">%
                    <br><br>
                    <label class="text-info">Final term:</label>
                    <input type="text" class="mobile maxlen2 score input-sm" id="finalpercent" name="finalpercent" placeholder="">%
                    <br><br>
                    <label class="text-info">Passing Grade:</label>
                    <select id="passinggrade" name="passinggrade" class="input-sm">
                        <option>60</option>
                        <option>75</option>
                    </select>%
                </div>
                <div class="col-lg-6">
                    <label class="text-info">Class Code: </label>
                    <input type="text" class="mobile maxlen6 sclasscode input-sm" id="sclasscode" name="sclasscode" placeholder="">
                    <br><br>
                    <label class="text-info">Submission: </label>
                    <input type="date" class="input-sm" id="submissiondate" name="submissiondate" placeholder="">
                    <h6 class="text-danger">This will be the deadline of your class grade submission to be notified to you</h6>
                    <br><br>
                </div>
            </div>

            <div class="modal-footer">
                <input class="btn btn-success" type="button" onclick="submitsp();" id="setpercentage" name="setpercentage" value="Set">
            </div>
            <div id="sp"></div>
        </form>
    </div>
</div>


<!--term percentages-->

<!--changepmodal-->
<div id="changepmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod2();" title="Close" class="close">X</a>
       <h3 class="modal-header">Change Password</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="insregnop" name="insregnop" value="<?php echo $insregno; ?>">
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
            <input type="button" class="btn btn-success" onclick="fncchangep();" id="changepass" name="changepass" value="Change">
                <div id="show"></div>
            </div>
        </form>

    </div>
</div>

<!--changepmodal-->

<!--editaccountmodal-->
<div id="editaccountmodal" class="modal modal-dialog"   role="dialog" aria-hidden="true">
    <div class="form-group well">
        <a onclick="hidemod3();" title="Close" class="close">X</a>
        <h3 class="modal-header">Edit Profile</h3>
        <form action="editinstructoraccount.php" method="post">
            <input type="hidden" id="insregnoup" name="insregnoup" value="<?php echo $insregno; ?>">
            <div class="col-lg-4">
                <input type="text" class="letters maxlen30 form-control" id="nfname" name="nfname" placeholder="First Name">
            </div>
            <div class="col-lg-4">
                <input type="text" class="letters maxlen30  form-control" id="nmname" name="nmname" placeholder="Middle Name">
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
            <input type="number" class="mobile maxlen11 form-control" id="ncontact" name="ncontact" placeholder="Contact">
            </div>
            <div class="col-lg-8 text-right">
                <input type="button" class="btn btn-success" onclick="fnceditinfo();" id="updateinfo" name="updateinfo" value="Update">
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
<?php
//create class
if(isset($_POST['createclass']))
{
    try {
        random_int(111111, 999999);
    } catch (Exception $e) {
    }
    $classcode=mt_rand();
    $checkmtrand='select *from tblclass where classcode= :classcode';
    $query=$conn->prepare($checkmtrand);
    $query->execute(array(
        ':classcode'=> $classcode,
    ));

    do{
        try {
            random_int(111111, 999999);
        } catch (Exception $e) {
        }
    }
    while($query->rowCount()>0);
    try {
        $classcode = random_int(111111, 999999);
    } catch (Exception $e) {
    }


    $createclass="insert into tblclass (subjectcode, insregno,startdate, classcode, subjectdesc) 
VALUES ('".$_POST['subjectcode']."', $insregno, CURRENT_DATE, $classcode,'".$_POST['subjectdesc']."')";

    if($conn->query($createclass)){
        echo "<script>window.top.location='educatorindex.php';</script>";
        exit;
    }

}
?>



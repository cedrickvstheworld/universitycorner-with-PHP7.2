<?php
session_start();
$server= 'mysql:host=sql112.epizy.com;dbname=epiz_21863959_samsdb';
$username='epiz_21863959';
$password='D43yez6S0Krb';

//connection

try{
    $con=new PDO($server,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch (Exception $ex){
    echo'NOT CONNECTED' .$ex->getMessage();
}

?>
<?php
if (isset($_SESSION['user'])){
    header('location:educatorindex.php');
}elseif (isset($_SESSION['user2'])){
    header('location:studentindex.php');
}elseif (isset($_SESSION['user3'])){
    header('location:parentindex.php');
}else{
    echo '';
}
?>
<!DOCTYPE>
<html>
<head>
    <title id="">University Corner</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="registraton.css">
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
</head>

<body>
<h2 class="modal-header text-primary">Educator Registration</h2>

<form action="registration.php" method="post">
    <div class="well container">
        <h4 class="heading">Complete the form with your correct information</h4>
        <div class="text-center col-lg-4">

            <input type="text" class="letters maxlen30 name input-lg" id="fname" name="fname" placeholder="First Name" required>



        </div>
        <div class="text-center col-lg-4">

            <input type="text" class="letters maxlen30 name input-lg" id="mname" name="mname" placeholder="Middle Name" required>

        </div>
        <div class="text-center col-lg-4">

            <input type="text" class="letters maxlen30 name input-lg" id="lname" name="lname" placeholder="Last Name" required>

        </div>


        <div class="col-lg-7">
            <br>
            <input type="text" class="maxlen70 address input-lg" id="address" name="address" placeholder="Address" required>



        </div>
        <div class="col-lg-5 text-right">
            <br>
            <label class="lbl">Birthday</label>
            <select id="birthmonth" name="birthmonth" class="input-lg">
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
            <select id="birthday" name="birthday" class="input-lg">
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
            <input type="text" class="year mobile maxlen4 input-lg" id="birthyear" name="birthyear" placeholder="Year" required>

        </div>
        <div class="col-lg-12">
            <br>
            <input type="tel" class="mobile maxlen11 input-lg" id="contact" name="contact" placeholder="Contact No." required>
        </div>

        <div class="col-lg-12">
            <br>
            <h4 class="heading">Account Security</h4>
        </div>
        <div class="col-lg-4">
            <input class="maxlen30 as input-lg" type="text" id="username" name="username" placeholder="Username" required>
            <br>
            <br>
            <input class="maxlen40 as input-lg" type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <br>
            <input class="maxlen40 as input-lg" type="password" id="confirm" name="confirm" style="width: 290px" placeholder="Confirm Password" required>
            <button id= "show_password" class="btn btn-lg btn-secondary" type="button">
                <span class="glyphicon glyphicon-eye-open"></span>
            </button>
        </div>
        <div class="col-lg-8 text-right">
            <label class="lbl">Security Question</label><br>
            <select id="secquestion" name="secquestion" class="input-lg">
                <option>What is the name of a college you applied to but didn't attend?</option>
                <option>What is the name of the city where you got lost?</option>
                <option>What street did you live on in third grade?</option>
                <option>What is the name of your favorite childhood friend?</option>
                <option>What was the second best birthday present you ever got?</option>
                <option>What is the name of the teacher who gave you your first A?</option>
            </select><br><br>
            <input class="maxlen30 an input-lg" type="text" id="answer" name="answer" placeholder="Answer" required>
        </div>

        <div class="col-lg-12 text-center">
            <input class="sigup btn btn-success" type="button" onclick="educatorsignup();" id="register" name="register" value="Sign-Up">
        </div>


    </div>
    <div id="showhere"></div>

</form>






<!-- Footer -->
<?php
date_default_timezone_set('asia/manila');
$date = new DateTime('now');
$copyrightyear = date('Y');
?>
<div class="panel-footer navbar-fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright text-success">Copyright &copy; University Corner <?php echo $copyrightyear; ?></span>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
                    <li class="list-inline-item">
                        <a class="text-success" href="privacystmt.php" target="_blank">Privacy Statement</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--footer-->


<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="registration.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>
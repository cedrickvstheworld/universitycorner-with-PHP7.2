<!DOCTYPE html>
<html>
<head>
    <title id="page-top">University Corner</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
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
<!--nav-->
<nav class="navbar navbar-inverse">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger text-primary" href="loginpage.php">University Corner<small class="text-muted"> keep learning</small></a>
        <div class="asd container">
        </div>
    </div>

</nav>

<!--nav-->

<div class="container">
<h3 class="modal-header text-info text-center">Privacy Statement</h3>
</div>


<!--paragraph-->
<br>
<p class="privacystmt text-center" style="font-size: 20px">
    This website is under development. Use this site at your own risk.
    For further information, suggestions and inquiries, message me at my fb account
    <a href="https://web.facebook.com/cedrick.domingo.75" class="btn-link">https://web.facebook.com/cedrick.domingo.75</a> <br>
</p>
<!--paragraph-->

<div class="team-member">
    <img class="mx-auto rounded-circle fa-rotate-270" src="img/cedie1.jpg" alt="">
    <h4>Developer - Cedrick Domingo</h4>
    <br>
    <?php
    date_default_timezone_set('asia/manila');
    $date = new DateTime('now');
    $copyrightyear = date('Y');
    ?>
    <p><span class="copyright text-success">Copyright &copy; University Corner <?php echo $copyrightyear; ?></span></p>
</div>


<script src="bootstrap-3.3.7-dist/js/jquery-3.2.1.js"></script>
<script src="cediescripts.js"></script>
<script src="cediescripts2.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>


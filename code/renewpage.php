<?php
if (!isset($SYSTEM_NAME)) {
    require_once "config.php";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - Bootstrap Admin Template</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>

<div class="navbar navbar-fixed-top">

    <div class="navbar-inner">

        <div class="container">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" >
                <?php echo $SYSTEM_NAME; ?>
            </a>

            <div class="nav-collapse">
                <ul class="nav pull-right">

                    <li class="">
                        <a href="leave.php" class="">
                            Don't have an account?
                        </a>

                    </li>

                    <li class="">
                        <a href="welcomepage.php" class="">
                            <i class="icon-chevron-left"></i>
                            Back to The Welcome Page
                        </a>

                    </li>
                </ul>

            </div><!--/.nav-collapse -->

        </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

</div> <!-- /navbar -->

<div class="account-container">

    <div class="content clearfix">

        <form action="checkkey.php" method="post">


            <h1>Re-new Page</h1>
            <div class="login-fields">

                <p>Please enter the Key</p>
                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="fpassword" name="fpassword" value="" placeholder="Key"
                           class="login password-field"/>
                </div> <!-- /password -->

            </div> <!-- /login-fields -->

            <div class="login-actions">

                <button class="button btn btn-success btn-large">Unlock</button>

            </div> <!-- .actions -->
        </form>

        <?php
        if (isset($_GET['fail']))
        {
            echo "<p style='color:#ff0517'>Error : You entered the wrong Key , only i try left</p>";
        }

        ?>
    </div> <!-- /content -->
</div> <!-- /account-container -->
<div class="login-extra">
    <!--a href="#">Reset Password</a>< -->
</div> <!-- /login-extra -->


<?php require_once "common_scripts.php"; ?>
<script src="js/signin.js"></script>

</body>

</html>

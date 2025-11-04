<?php
if (!isset($SYSTEM_NAME)) {
    require_once "config.php";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - <?php echo $SYSTEM_NAME; ?></title>

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

        <form action="checklogin.php" method="post">


            <h1>Member Login</h1>
            <div class="login-fields">

                <p>Please provide your details</p>
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="fusername" name="fusername" value="" placeholder="Username"
                           class="login username-field"/>
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="fpassword" name="fpassword" value="" placeholder="Password"
                           class="login password-field"/>
                </div> <!-- /password -->

            </div> <!-- /login-fields -->

            <div class="login-actions">

                <button class="button btn btn-success btn-large">Sign In</button>

            </div> <!-- .actions -->
        </form>

        <?php
        // Improved error message display with modern styling
        if (isset($_GET['TT'])) {
            echo '<div class="alert alert-error" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #fee; border-left: 4px solid #d00;">
                    <i class="icon-warning-sign"></i> <strong>Error:</strong> Wrong username or password. Please try again.
                  </div>';
        }
        if (isset($_GET['var'])) {
            echo '<div class="alert alert-info" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #e8f4fd; border-left: 4px solid #3a87ad;">
                    <i class="icon-info-sign"></i> <strong>Notice:</strong> Please don\'t skip the login process.
                  </div>';
        }
        if (isset($_GET['lock'])) {
            echo '<div class="alert alert-error" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #fee; border-left: 4px solid #d00;">
                    <i class="icon-lock"></i> <strong>Account Locked:</strong> Your account has been locked. Please contact the administrator to unlock it.
                  </div>';
        }
        if (isset($_GET['TimeChanged'])) {
            echo '<div class="alert alert-warning" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #fff3cd; border-left: 4px solid #f0ad4e;">
                    <i class="icon-time"></i> <strong>Time Error:</strong> The system clock has been changed. Please fix the system time and try again.
                  </div>';
        }
        if (isset($_GET['SystemLock']) && !isset($_GET['AllGood'])) {
            echo '<div class="alert alert-error" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #fee; border-left: 4px solid #d00;">
                    <i class="icon-ban-circle"></i> <strong>System Locked:</strong> The system is currently locked. Please contact the administrator.
                  </div>';
            echo '<form action="renewpage.php" style="margin-top: 15px;">
                    <div class="login-actions">
                        <button class="button btn btn-info btn-large" type="submit">
                            <i class="icon-refresh"></i> Renew System
                        </button>
                    </div>
                  </form>';
        }
        if (isset($_GET['Failtwotimes'])) {
            echo '<div class="alert alert-error" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #fee; border-left: 4px solid #d00;">
                    <i class="icon-remove-sign"></i> <strong>System Shutdown:</strong> The system has been shutdown due to multiple failed attempts. Contact System Admin immediately.
                  </div>';
        }
        if (isset($_GET['AllGood'])) {
            echo '<div class="alert alert-success" style="margin-top: 20px; padding: 12px; border-radius: 4px; background: #dff0d8; border-left: 4px solid #5cb85c;">
                    <i class="icon-ok"></i> <strong>Success:</strong> System renewed successfully. You can login now.
                  </div>';
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

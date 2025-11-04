<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        /* The CSS */
        select {
            padding: 3px;
            margin: 0;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
            -moz-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
            box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
            background: #f8f8f8;
            color: #888;
            border: none;
            outline: none;
            display: inline-block;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
        }

        /* Targetting Webkit browsers only. FF will show the dropdown arrow with so much padding. */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            select {
                padding-right: 18px
            }
        }
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
            <a class="brand" href="index.html"><?php echo $SYSTEM_NAME; ?></a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="icon-user"></i> <?php echo $suser_name; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="Logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- /navbar -->

<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li><a href="homepage.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a></li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                            class="icon-list-alt"></i><span>Forms</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="RegisFrom.php">Registration</a></li>
                        <li><a href="levelsform.php">New Level</a></li>
                        <li class="active"><a href="groupsform.php">New Group</a></li>
                        <li><a href="Markformcontrol.php">Mark Entry</a></li>
                        <li><a href="attendformcontrol.php">Attendance sheet</a></li>
                        <li><a href="#">Other Payment</a></li>
                        <li><a href="#">change Penalty</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                            class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="icons.html">Icons</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="pricing.html">Pricing Plans</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="signup.html">Signup</a></li>
                        <li><a href="error.html">404</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-user"></i>
                            <h3>Your Form</h3></div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="jscontrols">

                                        <!-- 
                                        **********************************
                                        Querying to get Name
                                        **********************************
                                        -->
                                        <?php if (isset($_POST['StudentCode'])) {
                                            // Use prepared statement to prevent SQL injection
                                            $studentCode = safe_get('StudentCode', 0, 'int');
                                            $stmt = $link->prepare("SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = ?");
                                            if ($stmt) {
                                                $stmt->bind_param("i", $studentCode);
                                                $stmt->execute();
                                                $resultSNC = $stmt->get_result();
                                                $rowSNC = $resultSNC->fetch_assoc();
                                                $stmt->close();
                                            } else {
                                                $rowSNC = false;
                                            }
                                            
                                            if ($rowSNC) {
                                                $Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                                $Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                            } else {
                                                $Fname = '';
                                                $Sirname = '';
                                            }
                                        } ?>

                                        <?php //here to display Name
                                        if (isset($Fname)) {
                                            ?>
                                            <div class="controls">
                                                <div class="input-append"><label class="control-label" for="radiobtns">Student
                                                        Name</label>
                                                    <input type="text" id="StudentName" readonly name="StudentName"
                                                           value="<?php echo $Fname; ?>" class="login"/>
                                                    <input type="text" id="StudentName" readonly name="StudentName"
                                                           value="<?php echo $Sirname; ?>" class="login"/>
                                                </div>
                                            </div>
                                        <?php }
                                        if (!isset($_POST['level_id'])) { ?>
                                            <form action="RegisFrom.php" method="POST">
                                                <ul style="float: left">
                                                    <label for="group_id">Which Level</label>
                                                    <select id="level_id" name="level_id" class="icon-pencil">
                                                        <?php $i = 1;
                                                        $result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels`");
                                                        if ($i == 1) {
                                                            echo "<option selected value='nothing'>Level Name</option>";
                                                            $i += 1;
                                                        }
                                                        if ($result) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='$row[Level_id]'>$row[level_name]</option>";
                                                        }
                                                        } ?>
                                                    </select>
                                                </ul>

                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Group Time</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                            <select id="GroupTime" name="GroupTime" class="icon-pencil">
                                                                <option selected value='nothing'>Group Time</option>
                                                                <option value='8'>8 - 10</option>
                                                                <option value='10'>10 - 12</option>
                                                                <option value='12'>12 - 2</option>
                                                                <option value='3'>3 - 5</option>
                                                                <option value='5'>5 - 7</option>
                                                                <option value='7'>7 - 9</option>
                                                            </select>
                                                            <select id="GroupDay" name="GroupDay" class="icon-pencil">
                                                                <option selected value='nothing'>Group Day</option>
                                                                <option value='1'>1st</option>
                                                                <option value='15'>15th</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-primary">+</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo $_POST['StudentCode']; ?>" class="login"/>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <form action="RegisFrom.php" method="POST">
                                                <ul style="float: left">
                                                    <label for="group_id">Which Level</label>
                                                    <select id="level_id" name="level_id" class="icon-pencil">
                                                        <?php
                                                        $result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels`");
                                                        if ($result) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                if ($row['Level_id'] == $_POST['level_id'])
                                                                    echo "<option selected value='$row[Level_id]'>$row[level_name]</option>";
                                                                else
                                                                    echo "<option value='$row[Level_id]'>$row[level_name]</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </ul>

                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Group Time</label>
                                                    <div class="controls">
                                                        <div class="input-append">

                                                            <select id="GroupTime" name="GroupTime" class="icon-pencil">
                                                                <?php
                                                                $result = mysqli_query($link, "SELECT DISTINCT(`group_time`) as grouptime FROM `group`");
                                                                if ($result) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        if ($row['grouptime'] == intval($_POST['GroupTime']))
                                                                            echo "<option selected value='$row[grouptime]'>$row[grouptime]</option>";
                                                                        else
                                                                            echo "<option value='$row[grouptime]'>$row[grouptime]</option>";
                                                                    }
                                                                } ?>
                                                            </select>

                                                            <select id="GroupDay" name="GroupDay" class="icon-pencil">
                                                                <?php if ($_POST['GroupDay'] == 'nothing') { ?>
                                                                    <option selected value='nothing'>Group Day</option>
                                                                    <option value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>
                                                                <?php if ($_POST['GroupDay'] == 1) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option selected value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>

                                                                <?php if ($_POST['GroupDay'] == 15) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option value=1>1st</option>
                                                                    <option selected value=15>15th</option>
                                                                <?php } ?>
                                                            </select>
                                                            <button type="submit" class="btn btn-primary">+</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo $_POST['StudentCode']; ?>" class="login"/>
                                            </form>
                                            <?php
                                        }

                                        /*echo "!i love mom !";
                                        echo "<br>";
                                        print_r($_POST);
                                        echo "<br>";
                                        */

                                        $GT = $_POST['GroupTime'];
                                        switch ($GT) {
                                            case 8:
                                                $GT = "8 - 10";
                                                break;
                                            case 10:
                                                $GT = "10 - 12";
                                                break;
                                            case 12:
                                                $GT = "12 - 2";
                                                break;
                                            case 3:
                                                $GT = "3 - 5";
                                                break;
                                            case 5:
                                                $GT = "5 - 7";
                                                break;
                                            case 7:
                                                $GT = "7 - 9";
                                                break;
                                        }
                                        //echo $GT;
                                        $levelcode = $_POST['level_id'];
                                        echo "<br>";
                                        $Studocode = $_POST['StudentCode'];
                                        if (strlen($_POST['GroupDay']) == 1)
                                            $datafromfrom = date("o") . "-" . date("m") . "-0" . $_POST['GroupDay'];
                                        if (strlen($_POST['GroupDay']) == 2)
                                            $datafromfrom = date("o") . "-" . date("m") . "-" . $_POST['GroupDay'];

                                        // Use prepared statement to prevent SQL injection
                                        $stmt = $link->prepare("SELECT `group_id`,`group_teacher` ,`group_startday` FROM `group` WHERE `group_time` LIKE ? AND `level_id` = ? AND `group_startday` = ? ORDER BY `group_C_date` LIMIT 1");
                                        if ($stmt) {
                                            $stmt->bind_param("sis", $GT, $levelcode, $datafromfrom);
                                            $stmt->execute();
                                            $resultTGT = $stmt->get_result();
                                            $rowTGT = $resultTGT->fetch_assoc();
                                            $stmt->close();
                                        } else {
                                            $rowTGT = false;
                                        }
                                        echo "<br>";
                                        $rowTGT['group_teacher'];
                                        $rowTGT['group_startday'];
                                        $rowTGT['group_id'];

                                        if (isset($GT)){
                                        ?>

                                        <form action="Regis.php" method="POST">

                                            <input type="hidden" id="levelcode" name="levelcode"
                                                   value="<?php echo $levelcode; ?>" class="login"/>
                                            <input type="hidden" id="fromtotime" name="fromtotime"
                                                   value="<?php echo $GT; ?>" class="login"/>
                                            <input type="hidden" id="groupid" name="groupid"
                                                   value="<?php echo $rowTGT['group_id']; ?>" class="login"/>
                                            <input type="hidden" id="StudentCode" name="StudentCode"
                                                   value="<?php echo $_POST['StudentCode']; ?>" class="login"/>

                                            <ul style="float: left">
                                                <label for="CoruseStartDate">Coruse Start Date</label>
                                                <input type="text" id="CoruseStartDate" name="CoruseStartDate"
                                                       value="<?php echo $rowTGT['group_startday']; ?>" class="login"/>
                                            </ul>
                                            <div class="control-group"><label class="control-label" for="radiobtns">Teacher</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <input type="text" id="GroupTeacher" name="GroupTeacher"
                                                               value="<?php echo $rowTGT['group_teacher']; ?>" required
                                                               class="login"/>
                                                    </div>
                                                </div>
                                            </div> <!-- /control-group -->
                                            <ul style="float: left">
                                                <label for="Finstallment">First Installment</label>
                                                <input type="text" id="Finstallment" name="Finstallment"
                                                       placeholder="First Payment" class="login"/>
                                            </ul>
                                            <div class="control-group"><label class="control-label" for="radiobtns">Discount</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <input type="text" id="Discount" name="Discount"
                                                               placeholder="Defoult is 0 " class="login"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            } ?>


                                            <?php if (isset($_GET['RID'])) { ?>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <div class="alert alert-success">
                                                            <button type="button" class="close"
                                                                    data-dismiss="alert">&times;</button>
                                                            Registration Complet & For
                                                            <strong><?php echo $_GET['RID']; ?></strong>.
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
//echo "<h1>Hello, PHP!</h1>";
//$name = $_POST['name']; // CONTAIN NAME OF PERSON
//$pass = $_POST['pass']; // ANY DETAIL OF PERSON
                                                $Regisid = $_GET['RID'];

                                                $link = "<script>window.open('gatepass.php?Regisid=$Regisid', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400')</script>";
                                                echo $link;


                                            }
                                            if (isset($_GET['FGT'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Select the Group Time.
                                                </div>
                                            <?php }
                                            if (isset($_GET['FLID'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Select the Level.
                                                </div> <?php }
                                            if (isset($_GET['GDF'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Group Day.
                                                </div> <?php }
                                            if (isset($_GET['FYI'])) {
                                                ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please enter the Birth Year.
                                                </div><?php } ?>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="reset" class="btn">Reset</button>
                                            </div> <!-- /form-actions -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">&copy; 2015 <a href='http://cafavalley.comoj.com/'>Cafavalley</a></div>
            </div>
        </div>
    </div>
</div>
<?php require_once "common_scripts.php"; ?>
</body>
</html>
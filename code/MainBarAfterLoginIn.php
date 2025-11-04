<?php
if (!isset($suser_name))
{
    session_destroy();
    header("location:index.php?var=why");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>HomePage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
          rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/pages/dashboard.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">


   

    <script language="javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = -document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a
                class="brand" href="homepage.php"><?php echo $SYSTEM_NAME; ?></a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="icon-user"></i> <?php echo $suser_name; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="Logout.php">Logout</a></li>
                        </ul>
                    </li>

                </ul>
                <style>
                    body {
                        font-family: calibri;
                    }

                    input[type=radio] {
                        display: none;
                    }

                    input[type=radio] + label {
                        display: inline-block;
                        margin: -2px;
                        padding: 4px 12px;
                        margin-bottom: 0;
                        font-size: 14px;
                        line-height: 20px;
                        color: #333;
                        text-align: center;
                        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
                        vertical-align: middle;
                        cursor: pointer;
                        background-color: #f5f5f5;
                        background-image: -moz-linear-gradient(top, #fff, #e6e6e6);
                        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fff), to(#e6e6e6));
                        background-image: -webkit-linear-gradient(top, #fff, #e6e6e6);
                        background-image: -o-linear-gradient(top, #fff, #e6e6e6);
                        background-image: linear-gradient(to bottom, #fff, #e6e6e6);
                        background-repeat: repeat-x;
                        border: 1px solid #ccc;
                        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
                        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                        border-bottom-color: #b3b3b3;
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
                        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
                        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                        -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                    }

                    input[type=radio]:checked + label {
                        background-image: none;
                        outline: 0;
                        -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
                        -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
                        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
                        background-color: #e0e0e0;
                    }
                </style>

<?php
function maincheck($title) {
?>

                <form action="Searchedelement.php" method="POST" class="navbar-search pull-right">
                    <input type="text" name="Searchedelement" id="Searchedelement" class="search-query"
                           placeholder="Search"
                           value="<?php if (isset($_POST['Searchedelement'])) echo $_POST['Searchedelement']; ?>">
                    <div class="control-group">
                        <div class="controls">
                            <br/>
                            <input type="radio" id="radio1" name="radio" value="IDsearch" checked>
                            <label for="radio1">ID</label>
                            <input type="radio" id="radio2" name="radio" value="Namesearch">
                            <label for="radio2">Name</label>
                            <input type="radio" id="radio3" name="radio" value="Phonesearch">
                            <label for="radio3">Phone</label>
                            <input type="radio" id="radio4" name="radio" value="Yearsearch">
                            <label for="radio4">Year of Birth</label>

                        </div>    <!-- /controls -->
                    </div> <!-- /control-group -->
                </form>


            </div>
            <!--/.nav-collapse -->
        </div>
        <!-- /container -->
    </div>
    <!-- /navbar-inner -->
</div>
<!-- /navbar -->

<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <?php
                if ($title == 'Homepage') {
                    ?>
                    <li class="active"><a href="homepageAdmin.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                    </li>
                    <?php
                } else { ?>
                    <li><a href="homepageAdmin.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                    </li>
                    <?php
                }
                ?>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                            class="icon-list-alt"></i><span>Forms</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($title == 'Register') { ?>

                            <!-- Scripts are loaded in common_scripts.php (footer) to avoid duplicate jQuery/bootstrap loads -->

                            <li class="active"><a href="RegisFrom.php">Registration</a></li>
                        <?php } else {
                            ?>
                            <li><a href="RegisFrom.php">Registration</a></li>
                        <?php }
                        if ($title == 'Level') { ?>
                            <li class="active"><a href="levelsform.php">New Level</a></li>
                        <?php } else { ?>
                            <li><a href="levelsform.php">New Level</a></li>
                        <?php }
                       
                        if ($title == 'Group') { ?>
                            <li class="active"><a href="groupsform.php">New Group</a></li>
                        <?php } else { ?>
                            <li><a href="groupsform.php">New Group</a></li>
                        <?php }
                        if ($title == 'StudentChangeTime') { ?>
                            <li class="active"><a href="StudentDataTime.php">Student Group Time Change</a></li>
                        <?php } else { ?>
                            <li><a href="StudentDataTime.php">Student Group Time Change</a></li>
                        <?php }
                        if ($title == "Spayment")
                        { ?>
                            <li class="active"><a href="SecondPayment.php">2nd Installment</a></li>
                        <?php }
                        else
                        { ?>
                            <li><a href="SecondPayment.php">2nd Installment</a></li>
                        <?php }
                        if ($title == 'Feeset') { ?>
                            <li class="active"><a href="feesset.php">Fees Set</a></li>
                        <?php } else { ?>
                            <li><a href="feesset.php">Fees Set</a></li>
                        <?php }

                        if ($title == 'MarkControl') { ?>
                            <li class="active"><a href="Markformcontrol.php">Mark Entry</a></li>
                        <?php } else { ?>
                            <li><a href="Markformcontrol.php">Mark Entry</a></li>
                        <?php }
                        if ($title == 'AttendControl') { ?>

                            <li class="active"><a href="attendformcontrol.php">Attendance sheet</a></li>
                        <?php } else { ?>
                            <li><a href="attendformcontrol.php">Attendance sheet</a></li>
                        <?php }
                        if ($title == 'PayControl') { ?>

                            <li class="active"><a href="paymentlistformcontrol.php">Payment sheet with id's</a></li>
                        <?php } else { ?>
                            <li><a href="paymentlistformcontrol.php">Payment sheet with id's</a></li>
                        <?php }

                        if ($title == "PaymentTTF")
                        { ?>
                            <li class="active"><a href="PaymentTTF.php">Extra Fees</a></li>
                        <?php }
                        else
                        { ?>
                            <li><a href="PaymentTTF.php">Extra Fees</a></li>
                        <?php }
                        if ($title == "AddExpenses")
                        { ?>
                            <li class="active"><a href="AddExpenses.php">Add Expenses</a></li>
                        <?php }
                        else
                        { ?>
                            <li><a href="AddExpenses.php">Add Expenses</a></li>
                        <?php }
						 if ($title == "StudentsunactivePool")
                        { ?>
                            <li class="active"><a href="groupsformsetunactive.php">Students unactive Pool</a></li>
                        <?php }
                        else
                        { ?>
                            <li><a href="groupsformsetunactive.php">Students unactive Pool</a></li>
                        <?php }
                        if ($title == 'Freeze') { ?>
                            <li class="active"><a href="freezeform.php">Freeze</a></li>
                        <?php } else { ?>
                            <li><a href="freezeform.php">Freeze</a></li>
                        <?php }
                        if ($title == 'unFreeze') { ?>
                        <li class="active"><a href="unfreezeform.php">UnFreeze</a></li>
                        <?php } else { ?>
                            <li><a href="unfreezeform.php">UnFreeze</a></li>
                        <?php } ?>
                    </ul>
                </li>
				<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-list-alt"></i><span>Scan Related</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($title == 'fileupload')
                        { ?>
                            <li class="active" ><a href="formfileupload.php">Student file Add</a></li>
                        <?php } else { ?>
                            <li><a href="formfileupload.php">Student file Add</a></li>
                        <?php }
                         if ($title == 'reportallfileupload')
                        { ?>
                        <li class="active" ><a href="reportallfileupload.php">List of students who got files</a></li>
                        <?php } else { ?>
                        <li><a href="reportallfileupload.php">List of students who got files</a></li>
                       <?php }
                       if ($title == 'report1upload')
                       { ?>
                       <li class="active" ><a href="report1fileupload.php">display a student's related files</a></li>
                       <?php } else { ?>
                       <li><a href="report1fileupload.php">display a student's related files</a></li>
                      <?php }
		
                        ?>
                        
                    </ul>
                </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($title == 'ReportForAllGroupData')
                        { ?>
                            <li class="active" ><a href="ReportlistOfGroup.php">List of Groups</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfGroup.php">List of Groups</a></li>
                        <?php }
                        if ($title == 'ReportForAllTeacherData')
                        { ?>
                            <li class="active" ><a href="ReportlistOfTeacher.php">List of Teachers</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfTeacher.php">List of Teachers</a></li>
                        <?php }
                        
                         if ($title == 'ReportAllStudents')
                        { ?>
                        <li class="active" ><a href="ReportlistofstudentsO_by_both.php">List of students</a></li>
                        <?php } else { ?>
                        <li><a href="ReportlistofstudentsO_by_both.php">List of students</a></li>
                       <?php }
                       if ($title == 'ReportAllStudentsEandF')
                       { ?>
                       <li class="active" ><a href="ReportlistofstudentsEandF.php">List of students Facebook and email</a></li>
                       <?php } else { ?>
                       <li><a href="ReportlistofstudentsEandF.php">List of students Facebook and email</a></li>
                      <?php }
					   if ($title == 'StudentsunactivePool')
                       { ?>
                       <li class="active" ><a href="ReportlistOfunactiveGroupRegis.php">List of those in the pool</a></li>
                       <?php } else { ?>
                       <li><a href="ReportlistOfunactiveGroupRegis.php">List of those in the pool</a></li>
                      <?php }
					   if ($title == 'reportshowunactive')
                       { ?>
                       <li class="active" ><a href="ReportlistOfunactiveGroup.php">List of groups in the pool</a></li>
                       <?php } else { ?>
                       <li><a href="ReportlistOfunactiveGroup.php">List of groups in the pool</a></li>
                      <?php }
                        if ($title == 'ReportAllFreezeStudents')
                        { ?>
                            <li class="active" ><a href="ReportlistOfFreezePeople.php">List of freeze students</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfFreezePeople.php">List of freeze students</a></li>
                        <?php }
                        if ($title == 'ReportForLevelBooks')
                        { ?>
                            <li class="active" ><a href="ReportlistOfLevel.php">Books Used</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfLevel.php">Books Used</a></li>
                        <?php } 
                        if ($title == 'ReportForaStudent')
                        { ?>
                            <li class="active" ><a href="ReportForaStudent.php">Certain Student</a></li>
                        <?php } else { ?>
                            <li><a href="ReportForaStudent.php">Certain Student</a></li>
                        <?php }
                        if ($title == 'ReportForaStudentwtihmark')
                        { ?>
                            <li class="active" ><a href="ReportForAStudentwithMarks.php">Certain Student with marks</a></li>
                        <?php } else { ?>
                            <li><a href="ReportForAStudentwithMarks.php">Certain Student with marks</a></li>
                        <?php }
                        if ($title == 'ReportForAGroupData')
                        { ?>
                            <li class="active" ><a href="ReportlistOfAGroup.php">Certain Group</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfAGroup.php">Certain Group</a></li>
                        <?php }
                        if ($title == 'ReportAllAFreezeStudents')
                        { ?>
                            <li class="active" ><a href="ReportlistOfAFreezePeople.php">Certain Level Freeze</a></li>
                        <?php } else { ?>
                            <li><a href="ReportlistOfAFreezePeople.php">Certain Level Freeze</a></li>
                        <?php }
                        if ($title == 'ReportOfPaymentOfToday')
                        { ?>
                            <li class="active" ><a href="ReportOfPaymentOfToday.php">Payment of the day</a></li>
                        <?php } else { ?>
                            <li><a href="ReportOfPaymentOfToday.php">Payment of the day</a></li>
                        <?php }
                        ?>
                        
                    </ul>
                </li>


            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->
<?php
}

function maincheckRegis($title) {
?>



</div>
<!--/.nav-collapse -->
</div>
<!-- /container -->
</div>
<!-- /navbar-inner -->
</div>
<!-- /navbar -->

<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <?php
                if ($title == 'HomepageRegis') {
                    ?>
                    <li class="active"><a href="homepageRegis.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                    </li>
                    <?php
                } else { ?>
                    <li><a href="homepageRegis.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                    </li>
                    <?php
                }
                ?>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                            class="icon-list-alt"></i><span>Forms</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <?php
                        if ($title == 'RegisRemove') { ?>
                            <li class="active"><a href="StudentDataRegis.php">Delete Registertion</a></li>
                        <?php } else { ?>
                            <li><a href="StudentDataRegis.php">Delete Registertion</a></li>
                        <?php }
                      if ($title == 'StudentEdit') { ?>
                          <li class="active"><a href="StudentDataMan.php">Student Data Edit</a></li>
                      <?php } else { ?>
                          <li><a href="StudentDataMan.php">Student Data Edit</a></li>
                      <?php }
                       if ($title == 'Teacher') { ?>
                        <li class="active"><a href="teachersform.php">New Teacher</a></li>
                    <?php } else { ?>
                        <li><a href="teachersform.php">New Teacher</a></li>
                    <?php }
                      if ($title == 'GateLost') { ?>
                          <li class="active"><a href="LostGatePass.php">Gate Pass</a></li>
                      <?php } else { ?>
                          <li><a href="LostGatePass.php">Gate Pass</a></li>
                      <?php }
                      if ($title == 'AddTime') { ?>
                          <li class="active"><a href="AddTimes.php">Manage Times</a></li>
                      <?php } else { ?>
                          <li><a href="AddTimes.php">Manage Times</a></li>
                      <?php }
                      if ($title == 'AddPassNumber') { ?>
                          <li class="active"><a href="AddLastNumber.php">Changing the Last Number</a></li>
                      <?php } else { ?>
                          <li><a href="AddLastNumber.php">Changing the Last Number</a></li>
                      <?php }
                      ?>
                    </ul>
                </li>
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
<?php
if ($title == 'ReportOfPaymentOfSDate')
{ ?>
    <li class="active" ><a href="ReportOfPaymentOfSelectedDate.php">Payment of a past day</a></li>
<?php } else { ?>
    <li><a href="ReportOfPaymentOfSelectedDate.php">Payment of a past day</a></li>
<?php }
if ($title == 'ReportOfPaymentOfTime')
{ ?>
    <li class="active" ><a href="ReportOfPaymentOfTime.php">Payment for a Period</a></li>
<?php } else { ?>
    <li><a href="ReportOfPaymentOfTime.php">Payment for a Period</a></li>
<?php }
?>
                    </ul>
                </li>


            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->
<?php
}
function maincheckLock($title) {
    ?>



    </div>
    <!--/.nav-collapse -->
    </div>
    <!-- /container -->
    </div>
    <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->

    <div class="subnavbar">
        <div class="subnavbar-inner">
            <div class="container">
                <ul class="mainnav">
                    <?php
                    if ($title == 'HomepageRegis') {
                        ?>
                        <li class="active"><a href="homepageLock.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                        </li>
                        <?php
                    } else { ?>
                        <li><a href="homepageLock.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="icon-list-alt"></i><span>Forms</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>-</li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>-</li>
                        </ul>
                    </li>


                </ul>
            </div>
            <!-- /container -->
        </div>
        <!-- /subnavbar-inner -->
    </div>
    <!-- /subnavbar -->
    <?php
}
?>
</body>

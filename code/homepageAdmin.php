<?php
require_once "config.php";
require_once "configspecial.php";
require_once "MainBarAfterLoginIn.php";
maincheck("Homepage");


// Get today's statistics with error handling
$Students_today = 0;
$groups_open = 0;
$Payment_today = 0;
$success_today = 0;

// New students today
$Get_count = mysqli_query($link, "SELECT DISTINCT(`ST_Gid`) FROM `student` WHERE S_date_On = '$today'");
if ($Get_count) {
    $Students_today = mysqli_num_rows($Get_count);
}

// Groups opened today
$Get_count = mysqli_query($link, "SELECT * FROM `registration` WHERE `status` = '1' AND regis_date = '$today'");
if ($Get_count) {
    $groups_open = mysqli_num_rows($Get_count);
}

// Payments today
$Payment_other = array('money' => 0);
$Get_count = mysqli_query($link, "SELECT SUM(`payment`) as money FROM `paymenttwo` WHERE P_created_date = '$today'");
if ($Get_count) {
    $Payment_other = mysqli_fetch_array($Get_count);
    if (!$Payment_other || !isset($Payment_other['money'])) {
        $Payment_other = array('money' => 0);
    }
}

$Payment_begin = array('money' => 0);
$Get_count = mysqli_query($link, "SELECT SUM(`paid_fees`) as money FROM `registration` WHERE regis_date = '$today'");
if ($Get_count) {
    $Payment_begin = mysqli_fetch_array($Get_count);
    if (!$Payment_begin || !isset($Payment_begin['money'])) {
        $Payment_begin = array('money' => 0);
    }
}

$Payment_today = ($Payment_other['money'] ?? 0) + ($Payment_begin['money'] ?? 0);

// Success rate calculation
$Students_count = 0;
$Get_count = mysqli_query($link, "SELECT DISTINCT(`ST_Gid`) FROM `student`");
if ($Get_count) {
    $Students_count = mysqli_num_rows($Get_count);
}

$success_today_pass = 0;
if ($Students_count > 0) {
    $Get_count = mysqli_query($link, "SELECT `mark` FROM `mark` WHERE `mark` > 50");
    if ($Get_count) {
        $success_today_pass = mysqli_num_rows($Get_count);
        $success_today = round(($success_today_pass / $Students_count) * 100, 0);
    }
}

?>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    
                    <!-- Welcome Header -->
                    <div style="margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h1 style="margin: 0 0 10px 0; color: #0b9bba; font-size: 28px;">
                            <i class="icon-user" style="margin-right: 10px;"></i>
                            Welcome, <?php echo escape_html($suser_name); ?>
                        </h1>
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            <?php echo date('l, F j, Y'); ?> | Admin Dashboard
                        </p>
                        <?php if (isset($_GET['Lastmonth']) && $_GET['Lastmonth'] == "Twitter") { ?>
                            <div style="margin-top: 15px; padding: 12px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                                <strong style="color: #856404;"><i class="icon-warning-sign"></i> System Renewal Notice:</strong>
                                <span style="color: #856404;">It has been one month. Please renew your system license.</span>
                                <a href='Redirectrenewpage.php' class="btn btn-warning btn-small" style="margin-left: 15px;">
                                    <i class="icon-refresh"></i> Renew Now
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="widget widget-nopad">
                        <div class="widget-content" style="padding: 0;">
                            <div id="big_stats">
                                <div class="stat">
                                    <i class="icon-user"></i>
                                    <h4>New Students Today</h4>
                                    <span class="value"><?php echo $Students_today; ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-group"></i>
                                    <h4>Groups Opened</h4>
                                    <span class="value"><?php echo $groups_open; ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-money"></i>
                                    <h4>Today's Payments</h4>
                                    <span class="value"><?php echo number_format($Payment_today ?? 0, 0); ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-trophy"></i>
                                    <h4>Success Rate</h4>
                                    <span class="value"><?php echo $success_today; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms Section -->
                    <div class="widget">
                        <div class="widget-header"> 
                            <i class="icon-file"></i>
                            <h3> Quick Actions & Forms</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <div class="shortcuts" style="margin-top: 20px;">
                                <a href="RegisFrom.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-user"></i></span>
                                    <span class="shortcut-label">Registration</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Register students</small>
                                </a>
                                <a href="levelsform.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-book"></i></span>
                                    <span class="shortcut-label">New Level</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Add/Modify courses</small>
                                </a>
                                <a href="groupsform.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-group"></i></span>
                                    <span class="shortcut-label">New Group</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Open groups</small>
                                </a>
                                <a href="SecondPayment.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-credit-card"></i></span>
                                    <span class="shortcut-label">2nd Installment</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Complete fees</small>
                                </a>
                                <a href="feesset.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-cog"></i></span>
                                    <span class="shortcut-label">Fees Settings</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">System fees</small>
                                </a>
                                <a href="Markformcontrol.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-edit"></i></span>
                                    <span class="shortcut-label">Mark Entry</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Enter marks</small>
                                </a>
                                <a href="attendformcontrol.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-list"></i></span>
                                    <span class="shortcut-label">Attendance</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Print sheets</small>
                                </a>
                                <a href="OtherPaymentStudent.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-file-text"></i></span>
                                    <span class="shortcut-label">Placement Test</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Extra fees</small>
                                </a>
                                <a href="freezeform.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-pause"></i></span>
                                    <span class="shortcut-label">Freeze</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Freeze studies</small>
                                </a>
                                <a href="unfreezeform.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-play"></i></span>
                                    <span class="shortcut-label">UnFreeze</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Resume studies</small>
                                </a>
                            </div>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->
                    
                    <!-- Reports Section -->
                    <div class="widget widget-nopad">
                        <div class="widget-header"> 
                            <i class="icon-list-alt"></i>
                            <h3>Reports & Analytics</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <ul class="news-items" style="margin-top: 20px;">
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-group" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportlistOfGroup.php">List Of Groups</a></span>
                                        <p class="news-item-preview">Display all registered groups with their details and statistics.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-user" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportlistofstudentsEandF.php">List Of Students</a></span>
                                        <p class="news-item-preview">Display all students ordered by ID or by Name with comprehensive information.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-book" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportlistOfLevel.php">Books Used</a></span>
                                        <p class="news-item-preview">Display the number of books that were used across all courses.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-search" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportForaStudent.php">Certain Student</a></span>
                                        <p class="news-item-preview">Display all related data for a specific student including courses, payments, and marks.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-calendar" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportlistOfAGroup.php">Certain Group</a></span>
                                        <p class="news-item-preview">Display group information and statistics from a specific date range.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-money" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportOfPaymentOfToday.php">Payment of the Day</a></span>
                                        <p class="news-item-preview">Display today's income and payment details for financial tracking.</p>
                                    </div>
                                </li>
                                <!-- <li>
                                    <div class="news-item-date">
                                        <span class="news-item-day"><i class="icon-time" style="font-size: 24px; color: #19bc9c;"></i></span>
                                    </div>
                                    <div class="news-item-detail">
                                        <span class="news-item-title"><a href="ReportOfPaymentOfTime.php">Payment of a Period</a></span>
                                        <p class="news-item-preview">Display income and payment statistics for a selected time period.</p>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->
                    
                </div>
                <!-- /span12 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /extra-inner -->
</div>
<!-- /extra -->
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <p style="text-align: center; color: #999; margin: 10px 0;">
                        &copy; <?php echo date('Y'); ?> <?php echo $SYSTEM_NAME; ?> | 
                        Powered by <a href='http://cafavalley.comoj.com/' target='_blank'>Cafavalley</a>
                    </p>
                </div>
                <!--div class="span12"> &copy; 2013 <a href="http://www.egrappler.com/">Bootstrap Responsive Admin Template</a>. </div><-->
                <!-- /span12 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /footer-inner -->
</div>
<!-- /footer -->
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->


<?php require_once "common_scripts.php"; ?>
</body>
</html>

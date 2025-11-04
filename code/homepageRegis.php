<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("HomepageRegis");
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
                            <?php echo date('l, F j, Y'); ?> | Registration Dashboard
                        </p>
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
                                <a href="Regis.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-remove"></i></span>
                                    <span class="shortcut-label">Delete Registration</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Remove student registration</small>
                                </a>
                                <a href="StudentDataMan.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-edit"></i></span>
                                    <span class="shortcut-label">Edit Student Data</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Check/edit student info</small>
                                </a>
                                <a href="leveltolevel.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-exchange"></i></span>
                                    <span class="shortcut-label">Group Time Change</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Change group period</small>
                                </a>
                                <a href="time.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-time"></i></span>
                                    <span class="shortcut-label">Manage Times</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Add/modify/remove times</small>
                                </a>
                                <a href="AddLastNumber.php" class="shortcut">
                                    <span class="shortcut-icon"><i class="icon-plus-sign"></i></span>
                                    <span class="shortcut-label">Change Last Number</span>
                                    <small style="display: block; margin-top: 5px; color: #999; font-size: 11px;">Manage student numbering</small>
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
                            <div style="padding: 40px 20px; text-align: center; color: #999;">
                                <i class="icon-info-sign" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                <p style="font-size: 16px;">No reports available for this user type.</p>
                            </div>
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
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>
</body>
</html>

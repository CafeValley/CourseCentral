<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckLock("HomepageRegis");

// Get member statistics
$total_members = 0;
$active_members = 0;
$locked_members = 0;

$resultStats = mysqli_query($link, "SELECT COUNT(*) as total, SUM(CASE WHEN M_Active = 1 THEN 1 ELSE 0 END) as active, SUM(CASE WHEN M_Active = 0 THEN 1 ELSE 0 END) as locked FROM `members`");
if ($resultStats) {
    $statsRow = mysqli_fetch_assoc($resultStats);
    $total_members = $statsRow['total'] ?? 0;
    $active_members = $statsRow['active'] ?? 0;
    $locked_members = $statsRow['locked'] ?? 0;
}

// Handle lock/unlock actions
if (isset($_POST['lock'])) {
    $memberid = safe_get('memberid', 0, 'int');
    $stmt = $link->prepare("UPDATE `members` SET M_Active = 0 WHERE member_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $memberid);
        $stmt->execute();
        $stmt->close();
    }
    // Refresh page to show updated status
    header("Location: homepageLock.php");
    exit();
}
if (isset($_POST['unlock'])) {
    $memberid = safe_get('memberid', 0, 'int');
    $stmt = $link->prepare("UPDATE `members` SET M_Active = 1 WHERE member_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $memberid);
        $stmt->execute();
        $stmt->close();
    }
    // Refresh page to show updated status
    header("Location: homepageLock.php");
    exit();
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
                            <i class="icon-lock" style="margin-right: 10px;"></i>
                            Welcome, <?php echo escape_html($suser_name); ?>
                        </h1>
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            <?php echo date('l, F j, Y'); ?> | User Management Dashboard
                            <?php if (isset($_GET['Lastmonth'])) { ?>
                                <span class="label label-info" style="margin-left:10px;">Last month: <?php echo escape_html($_GET['Lastmonth']); ?></span>
                            <?php } ?>
                        </p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="widget widget-nopad">
                        <div class="widget-content" style="padding: 0;">
                            <div id="big_stats">
                                <div class="stat">
                                    <i class="icon-user"></i>
                                    <h4>Total Members</h4>
                                    <span class="value"><?php echo $total_members; ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-ok"></i>
                                    <h4>Active Users</h4>
                                    <span class="value"><?php echo $active_members; ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-ban-circle"></i>
                                    <h4>Locked Users</h4>
                                    <span class="value"><?php echo $locked_members; ?></span>
                                </div>
                                <div class="stat">
                                    <i class="icon-cog"></i>
                                    <h4>System Status</h4>
                                    <span class="value"><?php echo $locked_members > 0 ? 'Alert' : 'OK'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Management Table -->
                    <div class="widget">
                        <div class="widget-header"> 
                            <i class="icon-lock"></i>
                            <h3>User Management</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <?php
                            $resultLMember = mysqli_query($link, "SELECT `member_id`, CONCAT(UCASE(LEFT(`member_user`, 1)), SUBSTRING(`member_user`, 2)) as member_user, `member_pass`, `member_type`, `M_Active` FROM `members` ORDER BY `member_type`, `member_user`");
                            
                            if ($resultLMember && mysqli_num_rows($resultLMember) > 0) {
                            ?>
                            <div style="overflow-x: auto;">
                                <table class="table table-striped table-bordered" style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align: center;"><strong>#</strong></th>
                                            <th width="25%"><strong>Username</strong></th>
                                            <th width="25%"><strong>Password</strong></th>
                                            <th width="20%" style="text-align: center;"><strong>Type</strong></th>
                                            <th width="15%" style="text-align: center;"><strong>Status</strong></th>
                                            <th width="10%" style="text-align: center;"><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $countx = 0;
                                        while ($rowMember = mysqli_fetch_array($resultLMember)) {
                                            $countx += 1;
                                            $Memberid = $rowMember['member_id'];
                                            $MemberName = escape_html($rowMember['member_user']);
                                            // Don't show actual password - show if hashed or not
                                            $MemberPass = strlen($rowMember['member_pass']) > 50 ? '•••••••• (Hashed)' : '••••••••';
                                            $MemberType = escape_html($rowMember['member_type']);
                                            $MemberLock = $rowMember['M_Active'];
                                        ?>
                                        <form action="homepageLock.php" method="POST">
                                            <input type="hidden" name="memberid" value="<?php echo $Memberid; ?>">
                                            <tr>
                                                <td style="text-align: center;">&nbsp;<?php echo $countx; ?></td>
                                                <td><strong><?php echo $MemberName; ?></strong></td>
                                                <td><?php echo $MemberPass; ?></td>
                                                <td style="text-align: center;">
                                                    <span class="label label-info"><?php echo $MemberType; ?></span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php if ($MemberLock == 1) { ?>
                                                        <span class="label label-success">Active</span>
                                                    <?php } else { ?>
                                                        <span class="label label-important">Locked</span>
                                                    <?php } ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php if ($MemberLock == 1) { ?>
                                                        <button name="lock" type="submit" class="btn btn-danger btn-small">
                                                            <i class="icon-lock"></i> Lock
                                                        </button>
                                                    <?php } else { ?>
                                                        <button name="unlock" type="submit" class="btn btn-success btn-small">
                                                            <i class="icon-unlock"></i> Unlock
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </form>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            } else {
                            ?>
                            <div style="padding: 40px 20px; text-align: center; color: #999;">
                                <i class="icon-user" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                <p style="font-size: 16px;">No members found.</p>
                            </div>
                            <?php
                            }
                            ?>
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

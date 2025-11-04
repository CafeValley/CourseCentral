<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("Group");
?>
<?php
$BuName = "";
function teacherdatahander($teacher_Id)
{
    global $link;

    $stmt = $link->prepare("SELECT `id`, `name`, `name2`, `name3`, `age`, `tel`, `tel2`, `appointeddate`, `interviewcomment`, `whenwasit`, `whodidthis` FROM `teachers` WHERE `id` = ?");
    if ($stmt) {
        $stmt->bind_param("i", $teacher_Id);
        $stmt->execute();
        $resultSNC = $stmt->get_result();
        $count = $resultSNC->num_rows;
        if ($count > 0) {
            $rowSNC = $resultSNC->fetch_assoc();
            $Fname = $rowSNC['name'] . " " . $rowSNC['name2'];
            $Sirname = " " . $rowSNC['name3'];
            $FullName = $Fname . " " . $Sirname;
            $stmt->close();
            return ($FullName);
        } else {
            $stmt->close();
            return ($teacher_Id);
        }
    }
    return ($teacher_Id);
}
?>
<link href="css/modern-forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input,
    textarea {
        width: 120px;
        height: 34px;
        display: inline-block;
        margin-bottom: 2em;
        padding: .75em .5em;
        color: #999;
        border: 1px solid #e9e9e9;
        outline: none;
    }

    input:focus,
    textarea:focus {
        -moz-box-shadow: inset 0 0 3px #aaa;
        -webkit-box-shadow: inset 0 0 3px #aaa;
        box-shadow: inset 0 0 3px #aaa;
    }

    textarea {
        height: 100px;
    }

    ul {
        margin: 0;
    }
</style>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">

                    <!-- Page Header -->
                    <div
                        style="margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h1 style="margin: 0 0 10px 0; color: #0b9bba; font-size: 28px;">
                            <i class="icon-group" style="margin-right: 10px;"></i>
                            Groups Management
                        </h1>
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            Create new groups, modify existing ones, or search by start date
                        </p>
                    </div>

                    <!-- Debug panel (temporary) -->
                    <div id="debug-info"
                        style="margin-bottom:20px;padding:12px;border-radius:6px;background:#fff8e1;border:1px solid #ffe08a;color:#333;display:none;">
                        <strong>Debug:</strong>
                        <div id="debug-content" style="margin-top:8px;font-size:13px;"></div>
                    </div>

                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-group"></i>
                            <h3>Groups</h3>
                        </div>

                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                                    <?php if (isset($_POST['callingsingle'])) { ?>
                                    <li><a href="#New" data-toggle="tab"><i class="icon-plus"></i> New Group</a></li>
                                    <?php } else { ?>
                                    <li class="active"><a href="#New" data-toggle="tab"><i class="icon-plus"></i> New
                                            Group</a></li>
                                    <?php } ?>

                                    <li><a href="#Modify" data-toggle="tab"><i class="icon-edit"></i> Modify All</a>
                                    </li>
                                    <?php if (isset($_POST['callingsingle'])) { ?>
                                    <li class="active"><a href="#singlecall" data-toggle="tab"><i
                                                class="icon-calendar"></i> Search by Date</a></li>
                                    <?php } else { ?>
                                    <li><a href="#singlecall" data-toggle="tab"><i class="icon-calendar"></i> Search by
                                            Date</a></li>
                                    <?php } ?>
                                </ul>

                                <div class="tab-content">
                                    <?php if (isset($_POST['callingsingle'])) { ?>
                                    <div class="tab-pane" id="New">
                                        <?php } else { ?>
                                        <div class="tab-pane active" id="New">
                                            <?php } ?>


                                            <form action="groups.php" method="post" class="group-form-container">
                                                <div class="form-section">
                                                    <h4><i class="icon-book"></i> Course & Timing</h4>
                                                    <div style="margin-bottom: 20px;">
                                                        <label
                                                            style="display: block; margin-bottom: 8px; font-weight: 600;">Select
                                                            Level</label>
                                                        <select id="level_id" name="level_id"
                                                            style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                                            required>
                                                            <?php
                                                            $i = 1;
                                                            $resultlevel = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels` ORDER BY `level_name`");
                                                            if ($i == 1) {
                                                                echo "<option selected value='nothing'>-- Select Level --</option>";
                                                                $i += 1;
                                                            }
                                                            while ($rowlevel = mysqli_fetch_assoc($resultlevel)) {
                                                                echo "<option value='" . escape_html($rowlevel['Level_id']) . "'>" . escape_html($rowlevel['level_name']) . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <label
                                                            style="display: block; margin-bottom: 8px; font-weight: 600;">Group
                                                            Time</label>
                                                        <div>
                                                            <?php DisplayInterval(); ?>
                                                            <style>
                                                                #GroupTime {
                                                                    width: 100%;
                                                                    max-width: 400px;
                                                                    padding: 10px;
                                                                    border: 1px solid #ddd;
                                                                    border-radius: 4px;
                                                                }
                                                            </style>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h4><i class="icon-user"></i> Teacher & Schedule</h4>
                                                    <div style="margin-bottom: 20px;">
                                                        <label
                                                            style="display: block; margin-bottom: 8px; font-weight: 600;">Group
                                                            Teacher</label>
                                                        <select id="GroupTeacher" name="GroupTeacher"
                                                            style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                            <?php
                                                            echo "<option selected value='nothing'>-- Select Teacher --</option>";
                                                            $resultteacher = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3` FROM `teachers` ORDER BY `name`");
                                                            if ($resultteacher && mysqli_num_rows($resultteacher) > 0) {
                                                                while ($rowteacher = mysqli_fetch_assoc($resultteacher)) {
                                                                    $teacherName = trim(escape_html($rowteacher['name'] . " " . $rowteacher['name2'] . " " . $rowteacher['name3']));
                                                                    if (empty($teacherName)) {
                                                                        $teacherName = "Teacher ID: " . escape_html($rowteacher['id']);
                                                                    }
                                                                    echo "<option value='" . escape_html($rowteacher['id']) . "'>" . $teacherName . "</option>";
                                                                }
                                                            } else {
                                                                // Show error if query fails or no teachers found
                                                                if (!$resultteacher) {
                                                                    error_log("Teacher query failed: " . mysqli_error($link));
                                                                    echo "<option value='nothing' disabled>Error loading teachers</option>";
                                                                } else {
                                                                    echo "<option value='nothing' disabled>No teachers available</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <label
                                                            style="display: block; margin-bottom: 8px; font-weight: 600;">Group
                                                            Day Type</label>
                                                        <select id="GroupDay" name="GroupDay"
                                                            style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                                            required>
                                                            <option selected value='nothing'>-- Select Day Type --
                                                            </option>
                                                            <option value='e'>Even</option>
                                                            <option value='d'>Odd</option>
                                                            <option value='o'>Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h4><i class="icon-calendar"></i> Start Date</h4>
                                                    <div style="margin-bottom: 20px;">
                                                        <label
                                                            style="display: block; margin-bottom: 8px; font-weight: 600;">Group
                                                            Start Day</label>
                                                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                                            <select id="Day" name="Day"
                                                                style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                                <option value="Day" selected>Day</option>
                                                                <option value="1">1st</option>
                                                                <option value="15">15th</option>
                                                            </select>
                                                            <select id="Month" name="Month"
                                                                style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                                <option value="Month" selected>Month</option>
                                                                <?php for ($i = 1; $i <= 12; $i++) {
                                                                    echo "<option value='$i'>$i</option>";
                                                                } ?>
                                                            </select>
                                                            <select id="Year" name="Year"
                                                                style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"
                                                                required>
                                                                <option value="Year" selected>Year</option>
                                                                <?php for ($i = date("Y") + 1; $i >= 1970; $i--) {
                                                                    echo "<option value='$i'>$i</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                if (isset($_GET['GID'])) {
                                                    echo '<div class="modern-alert modern-alert-success" style="margin-top: 20px;">
                                                            <i class="icon-ok"></i> <strong>Success!</strong> 
                                                            Group created successfully! Group ID: <strong>' . escape_html($_GET['GID']) . '</strong>
                                                          </div>';
                                                }

                                                // Error messages
                                                if (isset($_GET['GDF'])) {
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                            <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select the Group Day.
                                                          </div>';
                                                }
                                                if (isset($_GET['FYI'])) {
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                            <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select the Year.
                                                          </div>';
                                                }
                                                if (isset($_GET['FLID'])) {
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                            <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select the Level.
                                                          </div>';
                                                }
                                                if (isset($_GET['FGT'])) {
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                            <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select the Group Time.
                                                          </div>';
                                                }
                                                if (isset($_GET['FT'])) {
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                            <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select a Teacher.
                                                          </div>';
                                                }
                                                ?>

                                                <div class="form-actions"
                                                    style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                                    <button type="submit" class="btn btn-primary btn-large">
                                                        <i class="icon-save"></i> Create Group
                                                    </button>
                                                    <button type="reset" class="btn">
                                                        <i class="icon-refresh"></i> Reset
                                                    </button>
                                                </div>
                                            </form>
                                        </div>






                                        <?php if (isset($_POST['callingsingle'])) { ?>
                                        <div class="tab-pane active" id="singlecall">
                                            <?php } else { ?>
                                            <div class="tab-pane" id="singlecall">

                                                <?php } ?>

                                                <form action="groupsform.php" method="post"
                                                    class="group-form-container">
                                                    <input type="hidden" name="callingsingle" value="SETTime">
                                                    <div class="form-section">
                                                        <h4><i class="icon-calendar"></i> Search Groups by Start Date
                                                        </h4>
                                                        <p style="color: #666; margin-bottom: 20px;">Enter the start
                                                            date to find and edit groups starting on that day.</p>
                                                        <div style="margin-bottom: 20px;">
                                                            <label
                                                                style="display: block; margin-bottom: 8px; font-weight: 600;">Select
                                                                Start Date</label>
                                                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                                                <select id="DayScall" name="DayScall"
                                                                    style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                                    <?php
                                                                        $daySelected = isset($_POST['DayScall']) ? $_POST['DayScall'] : 'Day';
                                                                        ?>
                                                                    <option value="Day"
                                                                        <?php echo ($daySelected == 'Day') ? 'selected' : ''; ?>>
                                                                        Day</option>
                                                                    <option value="1"
                                                                        <?php echo ($daySelected == '1') ? 'selected' : ''; ?>>
                                                                        1st</option>
                                                                    <option value="15"
                                                                        <?php echo ($daySelected == '15') ? 'selected' : ''; ?>>
                                                                        15th</option>
                                                                </select>

                                                                <select id="MonthScall" name="MonthScall"
                                                                    style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                                    <option value="Month"
                                                                        <?php echo (!isset($_POST['MonthScall']) || $_POST['MonthScall'] == 'Month') ? 'selected' : ''; ?>>
                                                                        Month</option>
                                                                    <?php
                                                                        for ($i = 1; $i <= 12; $i++) {
                                                                            $selected = (isset($_POST['MonthScall']) && $_POST['MonthScall'] == $i) ? 'selected' : '';
                                                                            echo "<option value='$i' $selected>$i</option>";
                                                                        }
                                                                        ?>
                                                                </select>

                                                                <select id="YearScall" name="YearScall"
                                                                    style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                                    <option value="Year"
                                                                        <?php echo (!isset($_POST['YearScall']) || $_POST['YearScall'] == 'Year') ? 'selected' : ''; ?>>
                                                                        Year</option>
                                                                    <?php
                                                                        for ($i = date("Y") + 1; $i >= 1970; $i--) {
                                                                            $selected = (isset($_POST['YearScall']) && $_POST['YearScall'] == $i) ? 'selected' : '';
                                                                            echo "<option value='$i' $selected>$i</option>";
                                                                        }
                                                                        ?>
                                                                </select>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="icon-search"></i> Search
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <?php
                                                    // Only process if form was submitted
                                                    if (isset($_POST['YearScall']) && isset($_POST['MonthScall']) && isset($_POST['DayScall'])) {
                                                        $YearS = $_POST['YearScall'];
                                                        $montS = $_POST['MonthScall'];
                                                        if ($montS < 10 && $montS != 'Month')
                                                            $montS = "0" . $montS;

                                                        $daysS = $_POST['DayScall'];
                                                        if ($daysS < 10 && $daysS != 'Day')
                                                            $daysS = "0" . $daysS;

                                                        $fulldate = $YearS . "-" . $montS . "-" . $daysS;

                                                        if ((strpos($fulldate, 'Day') !== false) || (strpos($fulldate, 'Month') !== false) || (strpos($fulldate, 'Year') !== false)) {
                                                            echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                                    <i class="icon-warning-sign"></i> <strong>Warning:</strong> Please select a correct date.
                                                                  </div>';
                                                        } else {

                                                            // Handle form submissions with security
                                                            $group_id = "";
                                                            $group_time = "";
                                                            $group_teacher = "";
                                                            $group_day = "";
                                                            $group_startday = "";
                                                            $feesforbookgroup = "";
                                                            $feesforgroup = "";
                                                            $level_id = "";

                                                            if (isset($_POST['group_id'])) {
                                                                $group_id = safe_get('group_id', 0, 'int');
                                                                $group_time = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : '';
                                                                $group_teacher = safe_get('group_teacher', '', 'string');
                                                                $group_day = safe_get('group_day', '', 'string');
                                                                $group_startday = safe_get('group_startday', '', 'string');
                                                                $feesforbookgroup = safe_get('feesforbookgroup', 0, 'float');
                                                                $feesforgroup = safe_get('feesforgroup', 0, 'float');
                                                                $level_id = safe_get('Level_id', 0, 'int');
                                                            }

                                                            // Handle Edit with prepared statements
                                                            if (isset($_POST['E']) && $group_id > 0) {
                                                                $stmt = $link->prepare("UPDATE `group` SET `level_id` = ?, `group_time` = ?, `group_teacher` = ?, `group_day` = ?, `group_startday` = ?, `feesforgroup` = ?, `feesforbookgroup` = ? WHERE `group_id` = ?");
                                                                if ($stmt) {
                                                                    $stmt->bind_param("issssddi", $level_id, $group_time, $group_teacher, $group_day, $group_startday, $feesforgroup, $feesforbookgroup, $group_id);
                                                                    $stmt->execute();
                                                                    $stmt->close();
                                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                                            <i class="icon-ok"></i> <strong>Success!</strong> Group updated successfully.
                                                                          </div>';
                                                                }
                                                            }

                                                            // Handle Delete with prepared statements
                                                            if (isset($_POST['D']) && $group_id > 0) {
                                                                $stmt = $link->prepare("DELETE FROM `group` WHERE `group_id` = ?");
                                                                if ($stmt) {
                                                                    $stmt->bind_param("i", $group_id);
                                                                    $stmt->execute();
                                                                    $stmt->close();
                                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                                            <i class="icon-ok"></i> <strong>Success!</strong> Group deleted successfully.
                                                                          </div>';
                                                                }
                                                            }

                                                            // Search for groups with prepared statement
                                                            $stmt = $link->prepare("SELECT COUNT(*) as count FROM `group` WHERE `group_startday` = ?");
                                                            if ($stmt) {
                                                                $stmt->bind_param("s", $fulldate);
                                                                $stmt->execute();
                                                                $Sql_Select = $stmt->get_result();
                                                                $Sql_Select_Count = $Sql_Select->fetch_assoc();
                                                                $stmt->close();

                                                                if ($Sql_Select_Count && $Sql_Select_Count['count'] > 0) {
                                                                    $stmt2 = $link->prepare("SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `feesforgroup`, `feesforbookgroup` FROM `group` WHERE `group_startday` = ? ORDER BY `group_id` ASC");
                                                                    if ($stmt2) {
                                                                        $stmt2->bind_param("s", $fulldate);
                                                                        $stmt2->execute();
                                                                        $Result_Between = $stmt2->get_result();

                                                                        // Get levels and teachers for dropdowns
                                                                        $levels_result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels` ORDER BY `level_name`");
                                                                        $teachers_result = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3` FROM `teachers` ORDER BY `name`");
                                                                        $group_days_result = mysqli_query($link, "SELECT DISTINCT `group_day` FROM `group`");

                                                    ?>
                                                <div class="group-form-container" style="margin-top: 20px;">
                                                    <h4 style="color: #0b9bba; margin-bottom: 15px;">Groups Starting on
                                                        <?php echo escape_html($fulldate); ?></h4>
                                                    <div style="overflow-x: auto;">
                                                        <table class="groups-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Level</th>
                                                                    <th>Time</th>
                                                                    <th>Teacher</th>
                                                                    <th>Day</th>
                                                                    <th>Start Date</th>
                                                                    <th>Fees</th>
                                                                    <th>Books Fee</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                                        while ($Row_Set = mysqli_fetch_assoc($Result_Between)) {
                                                                                        ?>
                                                                <form
                                                                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                                    method="post"
                                                                    onsubmit='return confirm("Are you sure?")'>
                                                                    <input type="hidden" name="callingsingle"
                                                                        value="SETTime">
                                                                    <input type="hidden" name="DayScall"
                                                                        value="<?php echo escape_html($_POST['DayScall'] ?? 'Day'); ?>">
                                                                    <input type="hidden" name="MonthScall"
                                                                        value="<?php echo escape_html($_POST['MonthScall'] ?? 'Month'); ?>">
                                                                    <input type="hidden" name="YearScall"
                                                                        value="<?php echo escape_html($_POST['YearScall'] ?? 'Year'); ?>">
                                                                    <input type="hidden" name="group_id"
                                                                        value="<?php echo escape_html($Row_Set['group_id']); ?>">
                                                                    <tr>
                                                                        <td>
                                                                            <select name="Level_id"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <?php
                                                                                                            mysqli_data_seek($levels_result, 0);
                                                                                                            while ($level_row = mysqli_fetch_assoc($levels_result)) {
                                                                                                                $selected = ($level_row['Level_id'] == $Row_Set['level_id']) ? 'selected' : '';
                                                                                                                echo "<option value='" . escape_html($level_row['Level_id']) . "' $selected>" . escape_html($level_row['level_name']) . "</option>";
                                                                                                            }
                                                                                                            ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <?php DisplayInterval($Row_Set['group_time']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <select name="group_teacher"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <option value="">No teacher</option>
                                                                                <?php
                                                                                                            if ($teachers_result && mysqli_num_rows($teachers_result) > 0) {
                                                                                                                mysqli_data_seek($teachers_result, 0);
                                                                                                                while ($teacher_row = mysqli_fetch_assoc($teachers_result)) {
                                                                                                                    $teacher_name = escape_html($teacher_row['name'] . " " . $teacher_row['name2'] . " " . $teacher_row['name3']);
                                                                                                                    if (trim($teacher_name) === '') {
                                                                                                                        $teacher_name = 'Teacher ID: ' . escape_html($teacher_row['id']);
                                                                                                                    }
                                                                                                                    $selected = ($teacher_row['id'] == $Row_Set['group_teacher']) ? 'selected' : '';
                                                                                                                    echo "<option value='" . escape_html($teacher_row['id']) . "' $selected>$teacher_name</option>";
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo "<option value=''>No teachers available</option>";
                                                                                                            }
                                                                                                            ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="group_day"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <?php
                                                                                                            $day_map = array('e' => 'Even', 'd' => 'Odd', 'o' => 'Other');
                                                                                                            mysqli_data_seek($group_days_result, 0);
                                                                                                            while ($day_row = mysqli_fetch_assoc($group_days_result)) {
                                                                                                                $day_value = $day_row['group_day'];
                                                                                                                $day_label = isset($day_map[$day_value]) ? $day_map[$day_value] : $day_value;
                                                                                                                $selected = ($day_value == $Row_Set['group_day']) ? 'selected' : '';
                                                                                                                echo "<option value='" . escape_html($day_value) . "' $selected>" . escape_html($day_label) . "</option>";
                                                                                                            }
                                                                                                            ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="date" name="group_startday"
                                                                                value="<?php echo escape_html($Row_Set['group_startday']); ?>"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="feesforgroup"
                                                                                value="<?php echo escape_html($Row_Set['feesforgroup']); ?>"
                                                                                step="0.01"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="feesforbookgroup"
                                                                                value="<?php echo escape_html($Row_Set['feesforbookgroup']); ?>"
                                                                                step="0.01"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <button type="submit" name="E"
                                                                                class="btn btn-success btn-small"
                                                                                style="margin-right: 5px;">
                                                                                <i class="icon-edit"></i> Edit
                                                                            </button>
                                                                            <button type="submit" name="D"
                                                                                class="btn btn-danger btn-small">
                                                                                <i class="icon-remove"></i> Delete
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </form>
                                                                <?php
                                                                                        }
                                                                                        ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php
                                                                        $stmt2->close();
                                                                    }
                                                                } else {
                                                                    echo '<div class="modern-alert modern-alert-info" style="margin-top: 20px;">
                                                                            <i class="icon-info-sign"></i> <strong>Info:</strong> No groups found for this start date.
                                                                          </div>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                            </div>


                                            <div class="tab-pane" id="Modify">
                                                <div class="group-form-container">
                                                    <?php
                                                            // Handle form submissions with security
                                                            $group_id = "";
                                                            $group_time = "";
                                                            $group_teacher = "";
                                                            $group_day = "";
                                                            $group_startday = "";
                                                            $feesforbookgroup = "";
                                                            $feesforgroup = "";
                                                            $level_id = "";

                                                            if (isset($_POST['group_id'])) {
                                                                $group_id = safe_get('group_id', 0, 'int');
                                                                $group_time = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : '';
                                                                $group_teacher = safe_get('group_teacher', '', 'string');
                                                                $group_day = safe_get('group_day', '', 'string');
                                                                $group_startday = safe_get('group_startday', '', 'string');
                                                                $feesforbookgroup = safe_get('feesforbookgroup', 0, 'float');
                                                                $feesforgroup = safe_get('feesforgroup', 0, 'float');
                                                                $level_id = safe_get('Level_id', 0, 'int');
                                                            }

                                                            // Handle Edit with prepared statements
                                                            if (isset($_POST['E']) && $group_id > 0) {
                                                                $stmt = $link->prepare("UPDATE `group` SET `level_id` = ?, `group_time` = ?, `group_teacher` = ?, `group_day` = ?, `group_startday` = ?, `feesforgroup` = ?, `feesforbookgroup` = ? WHERE `group_id` = ?");
                                                                if ($stmt) {
                                                                    $stmt->bind_param("issssddi", $level_id, $group_time, $group_teacher, $group_day, $group_startday, $feesforgroup, $feesforbookgroup, $group_id);
                                                                    $stmt->execute();
                                                                    $stmt->close();
                                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                                            <i class="icon-ok"></i> <strong>Success!</strong> Group updated successfully.
                                                                          </div>';
                                                                }
                                                            }

                                                            // Handle Delete with prepared statements
                                                            if (isset($_POST['D']) && $group_id > 0) {
                                                                $stmt = $link->prepare("DELETE FROM `group` WHERE `group_id` = ?");
                                                                if ($stmt) {
                                                                    $stmt->bind_param("i", $group_id);
                                                                    $stmt->execute();
                                                                    $stmt->close();
                                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                                            <i class="icon-ok"></i> <strong>Success!</strong> Group deleted successfully.
                                                                          </div>';
                                                                }
                                                            }

                                                            // Get groups count
                                                            $Sql_Select = mysqli_query($link, "SELECT COUNT(*) as count FROM `group`");
                                                            $Sql_Select_Count = mysqli_fetch_assoc($Sql_Select);

                                                            if ($Sql_Select_Count && $Sql_Select_Count['count'] > 0) {
                                                                $Result_Between = mysqli_query($link, "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `feesforgroup`, `feesforbookgroup` FROM `group` ORDER BY `group_id` ASC");

                                                                // Get dropdown data
                                                                $levels_result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels` ORDER BY `level_name`");
                                                                $teachers_result = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3` FROM `teachers` ORDER BY `name`");
                                                                $group_days_result = mysqli_query($link, "SELECT DISTINCT `group_day` FROM `group`");
                                                                $day_map = array('e' => 'Even', 'd' => 'Odd', 'o' => 'Other');

                                                                if ($Result_Between && mysqli_num_rows($Result_Between) > 0) {
                                                            ?>
                                                    <h4 style="color: #0b9bba; margin-bottom: 15px;">All Groups</h4>
                                                    <div style="overflow-x: auto;">
                                                        <table class="groups-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Level</th>
                                                                    <th>Time</th>
                                                                    <th>Teacher</th>
                                                                    <th>Day</th>
                                                                    <th>Start Date</th>
                                                                    <th>Fees</th>
                                                                    <th>Books Fee</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                                while ($Row_Set = mysqli_fetch_assoc($Result_Between)) {
                                                                                ?>
                                                                <form
                                                                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                                                    method="post"
                                                                    onsubmit='return confirm("Are you sure?")'>
                                                                    <input type="hidden" name="group_id"
                                                                        value="<?php echo escape_html($Row_Set['group_id']); ?>">
                                                                    <tr>
                                                                        <td>
                                                                            <select name="Level_id"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <?php
                                                                                                    mysqli_data_seek($levels_result, 0);
                                                                                                    while ($level_row = mysqli_fetch_assoc($levels_result)) {
                                                                                                        $selected = ($level_row['Level_id'] == $Row_Set['level_id']) ? 'selected' : '';
                                                                                                        echo "<option value='" . escape_html($level_row['Level_id']) . "' $selected>" . escape_html($level_row['level_name']) . "</option>";
                                                                                                    }
                                                                                                    ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <?php DisplayInterval($Row_Set['group_time']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <select name="group_teacher"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <option value="">No teacher</option>
                                                                                <?php
                                                                                                    if ($teachers_result && mysqli_num_rows($teachers_result) > 0) {
                                                                                                        mysqli_data_seek($teachers_result, 0);
                                                                                                        while ($teacher_row = mysqli_fetch_assoc($teachers_result)) {
                                                                                                            $teacher_name = escape_html($teacher_row['name'] . " " . $teacher_row['name2'] . " " . $teacher_row['name3']);
                                                                                                            if (trim($teacher_name) === '') {
                                                                                                                $teacher_name = 'Teacher ID: ' . escape_html($teacher_row['id']);
                                                                                                            }
                                                                                                            $selected = ($teacher_row['id'] == $Row_Set['group_teacher']) ? 'selected' : '';
                                                                                                            echo "<option value='" . escape_html($teacher_row['id']) . "' $selected>$teacher_name</option>";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "<option value=''>No teachers available</option>";
                                                                                                    }
                                                                                                    ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="group_day"
                                                                                style="width: 100%; padding: 8px;">
                                                                                <?php
                                                                                                    mysqli_data_seek($group_days_result, 0);
                                                                                                    while ($day_row = mysqli_fetch_assoc($group_days_result)) {
                                                                                                        $day_value = $day_row['group_day'];
                                                                                                        $day_label = isset($day_map[$day_value]) ? $day_map[$day_value] : $day_value;
                                                                                                        $selected = ($day_value == $Row_Set['group_day']) ? 'selected' : '';
                                                                                                        echo "<option value='" . escape_html($day_value) . "' $selected>" . escape_html($day_label) . "</option>";
                                                                                                    }
                                                                                                    ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="date" name="group_startday"
                                                                                value="<?php echo escape_html($Row_Set['group_startday']); ?>"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="feesforgroup"
                                                                                value="<?php echo escape_html($Row_Set['feesforgroup']); ?>"
                                                                                step="0.01"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="feesforbookgroup"
                                                                                value="<?php echo escape_html($Row_Set['feesforbookgroup']); ?>"
                                                                                step="0.01"
                                                                                style="width: 100%; padding: 8px;"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <button type="submit" name="E"
                                                                                class="btn btn-success btn-small"
                                                                                style="margin-right: 5px;">
                                                                                <i class="icon-edit"></i> Edit
                                                                            </button>
                                                                            <button type="submit" name="D"
                                                                                class="btn btn-danger btn-small">
                                                                                <i class="icon-remove"></i> Delete
                                                                            </button>
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
                                                                    echo '<div style="padding: 40px; text-align: center; color: #999;">
                                                                            <i class="icon-info-sign" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                                                            <p style="font-size: 16px;">No groups found. Create a new group first.</p>
                                                                          </div>';
                                                                }
                                                            } else {
                                                                echo '<div style="padding: 40px; text-align: center; color: #999;">
                                                                        <i class="icon-info-sign" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                                                        <p style="font-size: 16px;">No groups found. Create a new group first.</p>
                                                                      </div>';
                                                            }
                                                            ?>
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
        </div>


        <?php require_once "common_footer.php"; ?>
        <?php require_once "common_scripts.php"; ?>

        <!-- Diagnostic script: logs whether jQuery and scripts are present -->
        <script>
            try {
                console.log('groupsform.php diagnostic: jQuery present? ', (typeof window.jQuery !== 'undefined') ?
                    jQuery.fn.jquery : 'undefined');
                console.log('groupsform.php diagnostic: script tags on page:', Array.prototype.slice.call(document
                    .querySelectorAll('script[src]')).map(function (s) {
                    return s.getAttribute('src');
                }));
            } catch (e) {
                try {
                    console.error('Diagnostic error:', e);
                } catch (_) {}
            }
        </script>

        <script>
            (function () {
                if (typeof jQuery !== 'undefined') {
                    jQuery(function ($) {
                        try {
                            // Enable bootstrap tab behavior on click
                            $("a[data-toggle='tab']").on('click', function (e) {
                                e.preventDefault();
                                $(this).tab('show');
                            });

                            // Enable dropdowns if available
                            if ($.fn.dropdown) {
                                $('.dropdown-toggle').dropdown();
                            }

                            // If page loaded with a hash (e.g. groupsform.php#New), activate that tab
                            var hash = window.location.hash;
                            if (hash) {
                                var $tab = $("a[data-toggle='tab'][href='" + hash + "']");
                                if ($tab.length) {
                                    // show the tab corresponding to the hash
                                    $tab.tab('show');
                                    // ensure the tab-pane gets focus/visibility
                                    var $pane = $(hash + ".tab-pane");
                                    if ($pane.length) {
                                        // add active class for non-bootstrap fallback
                                        $pane.addClass('active');
                                    }
                                    // scroll to top to make sure content is visible
                                    try {
                                        window.scrollTo(0, 0);
                                    } catch (e) {}
                                }
                            }

                        } catch (err) {
                            // Log errors to console for easier debugging
                            if (console && console.error) console.error(err);
                        }
                    });
                }
            })();
        </script>
        </body>

        </html>
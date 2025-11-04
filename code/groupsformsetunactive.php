<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("SetGroupunactive");
?>
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input, textarea {
        width: 120px;
        height: 34px;
        display: inline-block;
        margin-bottom: 2em;
        padding: .75em .5em;
        color: #999;
        border: 1px solid #e9e9e9;
        outline: none;
    }

    input:focus, textarea:focus {
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
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-group"></i>
                            <h3>Set Groups inactive</h3></div>
                        <div class="widget-content" style="padding:25px;">
                            <div class="tabbable">
							<div class="tab-pane" id="Modify">
                                        <?php
                                        // Handle set inactive
                                        if (isset($_POST['D'])) {
                                            $group_id = safe_get('group_id', 0, 'int');
                                            if ($group_id > 0) {
                                                mysqli_begin_transaction($link);
                                                try {
                                                    // Move registrations to registrationunactive
                                                    $stmtSelReg = $link->prepare("SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `group_id` = ?");
                                                    $stmtSelReg->bind_param("i", $group_id);
                                                    $stmtSelReg->execute();
                                                    $resRegs = $stmtSelReg->get_result();
                                                    $stmtInsReg = $link->prepare("INSERT INTO `registrationunactive` (`regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                                    $stmtDelReg = $link->prepare("DELETE FROM `registration` WHERE `regis_id` = ?");
                                                    while ($row = $resRegs->fetch_assoc()) {
                                                        $stmtInsReg->bind_param(
                                                            "iiiddiis",
                                                            $row['regis_id'], $row['level_id'], $row['group_id'], $row['paid_fees'], $row['discount'], $row['status'], $row['st_id'], $row['regis_date']
                                                        );
                                                        $stmtInsReg->execute();
                                                        $rid = (int)$row['regis_id'];
                                                        $stmtDelReg->bind_param("i", $rid);
                                                        $stmtDelReg->execute();
                                                    }
                                                    $stmtInsReg->close();
                                                    $stmtDelReg->close();
                                                    $stmtSelReg->close();

                                                    // Move group to groupunactive
                                                    $stmtSelGrp = $link->prepare("SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup` FROM `group` WHERE `group_id` = ?");
                                                    $stmtSelGrp->bind_param("i", $group_id);
                                                    $stmtSelGrp->execute();
                                                    $rowG = $stmtSelGrp->get_result()->fetch_assoc();
                                                    $stmtSelGrp->close();
                                                    if ($rowG) {
                                                        $stmtInsGrp = $link->prepare("INSERT INTO `groupunactive` (`group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                                        $stmtInsGrp->bind_param(
                                                            "iisssssdd",
                                                            $rowG['group_id'], $rowG['level_id'], $rowG['group_time'], $rowG['group_teacher'], $rowG['group_day'], $rowG['group_startday'], $rowG['group_C_date'], $rowG['feesforgroup'], $rowG['feesforbookgroup']
                                                        );
                                                        $stmtInsGrp->execute();
                                                        $stmtInsGrp->close();
                                                    }

                                                    // Delete original group
                                                    $stmtDelGrp = $link->prepare("DELETE FROM `group` WHERE `group_id` = ?");
                                                    $stmtDelGrp->bind_param("i", $group_id);
                                                    $stmtDelGrp->execute();
                                                    $stmtDelGrp->close();

                                                    mysqli_commit($link);
                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 15px;"><i class="icon-ok"></i> Group set inactive successfully.</div>';
                                                } catch (Exception $e) {
                                                    mysqli_rollback($link);
                                                    echo '<div class="modern-alert modern-alert-warning" style="margin-bottom: 15px;"><i class="icon-warning-sign"></i> Failed to set group inactive.</div>';
                                                }
                                            }
                                        }

                                        // Count groups
                                        $Sql_Select = mysqli_query($link, "SELECT count(*) as c FROM `group`");
                                        $Sql_Select_Count = $Sql_Select ? mysqli_fetch_assoc($Sql_Select) : ['c' => 0];
                                        if ((int)$Sql_Select_Count['c'] > 0) {

                                            // Select groups within 10 days window
                                            $sqltoselect = "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup` FROM `group` WHERE curdate() between group_startday  AND group_startday + INTERVAL 10 DAY  ORDER BY `group`.`group_id` ASC ";
                                            $Result_Between = mysqli_query($link,$sqltoselect );

                                           ?>
                                        <table class="table table-striped table-sm">
                                            <tr>
                                                <td>Level Name</td>
                                                <td>Time</td>
                                                <td>Teacher</td>
                                                <td>Day</td>
                                                <td>Starting Day</td>
                                                <td>Fees</td>
                                                <td>Books Fees</td>
                                            </tr>
                                            <?php
                                            $N_Labels = 0;
                                            while ($Row_Set = mysqli_fetch_array($Result_Between)) {
                                                {

                                                    ?>
                                                    <form id="Form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                                                          onSubmit='return confirm("Are you sure?")'>
                                                        <input id="group_id" autofocus="" name="group_id"
                                                               value='<?php echo $Row_Set['group_id'] ?>' type="hidden">

                                                        <tr><td>    <select id='Level_id' name='Level_id' class="icon-pencil"><?php
                                                                $Result_Between_Level = mysqli_query($link, "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book` FROM `levels` ");
                                                                while ($Row_Set_Level = mysqli_fetch_array($Result_Between_Level)) {
                                                                    if ($Row_Set_Level['Level_id'] == $Row_Set['level_id']) {
                                                                        echo "<option selected value = " . $Row_Set_Level['Level_id'] . ">" . $Row_Set_Level['level_name'] . "</option>";
                                                                    } else {
                                                                        echo "<option value = " . $Row_Set_Level['Level_id'] . ">" . $Row_Set_Level['level_name'] . "</option>";
                                                                    }
                                                                } ?>
                                                            </select>
                                                            </td>
                                                      <td>
                                                        <?php
                                                            DisplayInterval($Row_Set['group_time']); 
                                                            ?>
                                                       </td>

                                                          <td>
                                                            <?php echo $Row_Set['group_teacher']; ?>
                                                            </td>
                                                            <td>
                                                            <select id='group_day' name='group_day' class="icon-pencil"><?php
                                                                $Result_Group_Time = mysqli_query($link, "SELECT  DISTINCT (`group_day`) FROM `group` ");
                                                                while ($Row_Group_Time = mysqli_fetch_array($Result_Group_Time)) {
                                                                    if ($Row_Group_Time['group_day'] == 'e') 
                                                                        $ValueToShow = "Even";
                                                                    if ($Row_Group_Time['group_day'] == 'o')
                                                                        $ValueToShow = "Other";
                                                                    if ($Row_Group_Time['group_day'] == 'd')
                                                                        $ValueToShow = "Odd";
                                                                    if ($Row_Set['group_day'] == $Row_Group_Time['group_day']) {
                                                                        echo "<option selected value = " . $Row_Group_Time['group_day'] . ">" . $ValueToShow . "</option>";
                                                                    } else {
                                                                        echo "<option value = " . $Row_Group_Time['group_day'] . ">" . $ValueToShow . "</option>";
                                                                    } } ?>
                                                            </select>
                                                            </td>
                                                            <td>
                                                            <?php echo $Row_Set['group_startday'];?>
                                                            </td>
                                                            <td>
                                                                <?php echo $Row_Set['feesforgroup'];?>
                                                            </td>
                                                            <td>
                                                                <?php echo $Row_Set['feesforbookgroup'];?>
                                                            </td>


                                                            <td>
                                                            <button type="submit" name="D" class="btn btn-danger">Set inactive</button>
                                                            </td>
                                                        </tr></form><?php $N_Labels +=1;
                                                    } } } else { ?>
                                            <div class="alert">
                                                <button type="button" class="close" 
                                                        data-dismiss="alert">&times;</button>
                                                <strong>No!</strong>Groups to retrieve , Or you deleted all of them.
                                            </div><?php
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

<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>

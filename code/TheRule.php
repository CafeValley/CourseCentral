<?php
/*/
echo "<br>";
echo "i love mom";
print_r($_POST);
echo "<br>";
/*/
function DisplayRule($RulesList) {

    global $link;
    require_once "config.php";
    ?>
<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="widget ">
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                        <!--
                                        **********************************
                                        Querying to get Name
                                        **********************************
                                        -->
                                        <?php //here to display Name
                                        if (!isset($_POST['DeathCall'])){
                                        if ($RulesList == "MarkList") { ?>
                                    <form action="Markformcontrol.php" method="POST">
                                        <?php }
                                        if ($RulesList == "AttendList") { ?>
                                        <form action="attendformcontrol.php" method="POST">
                                            <?php }
                                            if ($RulesList == "PaymList") { ?>
                                            <form action="paymentlistformcontrol.php" method="POST">
                                                <?php } ?>
                                            <ul style="float: left">
                                                <label for="group_id">Which Level</label>
                                                <select id="level_id" name="level_id" class="icon-pencil">
                                                    <?php
                                                    $i = 1;
                                                    $result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels`");
                                                    if ($i == 1) {
                                                        echo "<option selected value='nothing'>Level Name</option>";
                                                        $i += 1;
                                                    }
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='$row[Level_id]'>$row[level_name]</option>";
                                                    } ?>
                                                    </select>
                                                </ul>

                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Group Time</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                            <?php
                                                            // Safe handling of GroupTime when first loading the form
                                                            $postedGroupTime = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : NULL;
                                                            DisplayInterval($postedGroupTime);
                                                            ?>
                                                            <select id="GroupDay" name="GroupDay"
                                                                    class="icon-pencil">
                                                                <option selected value='nothing'>Group Day</option>
                                                                <option value='1'>1st</option>
                                                                <option value='15'>15th</option>
                                                            </select>
                                                            <select id="GroupMonth" name="GroupMonth" class="icon-pencil">
                                                                <option value = "nothing">Group Month</option>
                                                                <?php
                                                                echo "<option value = '".date('m', strtotime('first day of -3 months'))."'>".NameToMonth(date('m', strtotime('first day of -3 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of -2 months'))."'>".NameToMonth(date('m', strtotime('first day of -2 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of last month'))."'>".NameToMonth(date('m', strtotime('first day of last month')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of this month'))."'>".NameToMonth(date('m', strtotime('first day of this month')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +1 months'))."'>".NameToMonth(date('m', strtotime('first day of +1 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +2 months'))."'>".NameToMonth(date('m', strtotime('first day of +2 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +3 months'))."'>".NameToMonth(date('m', strtotime('first day of +3 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +4 months'))."'>".NameToMonth(date('m', strtotime('first day of +4 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +5 months'))."'>".NameToMonth(date('m', strtotime('first day of +5 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +6 months'))."'>".NameToMonth(date('m', strtotime('first day of +6 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +7 months'))."'>".NameToMonth(date('m', strtotime('first day of +7 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +8 months'))."'>".NameToMonth(date('m', strtotime('first day of +8 months')))."</option>";
                                                                ?>
                                                            </select>
                                                            <select id="GroupYear" name="GroupYear"
                                                                    class="icon-pencil">
                                                                <option value = "nothing">Group Year</option>
                                                                <?php for ($i=2017;$i <= date("Y")+3;$i++) {
                                                                    echo "<option>$i</option>"; }
                                                                ?>
                                                            </select>
                                                            <button name = "DeathCall" type="submit" class="btn btn-primary">+</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->

                                            </form>
                                            <?php
                                        } else {
                                            //the Second pressed !
                                            if ($RulesList == "MarkList"){
                                            ?>
                                        <form action="Markformcontrol.php" method="POST">
                                            <?php }
                                            if ($RulesList == "AttendList") { ?>
                                            <form action="attendformcontrol.php" method="POST">

                                                <?php }
                                                if ($RulesList == "PaymList") { ?>
                                                <form action="paymentlistformcontrol.php" method="POST">
                                                    <?php } ?>

                                                <ul style="float: left">
                                                    <label for="group_id">Which Level</label>
                                                    <select id="level_id" name="level_id" class="icon-pencil">
                                                        <?php
                                                        $result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels`");
                                                        $n = 0;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            if ((isset($_POST['level_id']) && $_POST['level_id'] == "nothing") && $n == 0 )
                                                                echo "<option selected value='nothing'>Level Name</option>";
                                                            if (isset($_POST['level_id']) && $row['Level_id'] == $_POST['level_id'])
                                                                echo "<option selected value='$row[Level_id]'>$row[level_name]</option>";
                                                            else
                                                                echo "<option value='$row[Level_id]'>$row[level_name]</option>";
                                                            $n++;} ?>
                                                    </select>
                                                </ul>

                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Group Time</label>
                                                    <div class="controls">
                                                        <div class="input-append">

                                                            <?php
                                                            $postedGroupTime = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : NULL;
                                                            DisplayInterval($postedGroupTime);
                                                            ?>

                                                            <select id="GroupDay" name="GroupDay"
                                                                    class="icon-pencil">
                                                                <?php if (!isset($_POST['GroupDay']) || $_POST['GroupDay'] == 'nothing') { ?>
                                                                    <option selected value='nothing'>Group Day
                                                                    </option>
                                                                    <option value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>
                                                                <?php if (isset($_POST['GroupDay']) && $_POST['GroupDay'] == 1) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option selected value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>

                                                                <?php if (isset($_POST['GroupDay']) && $_POST['GroupDay'] == 15) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option value=1>1st</option>
                                                                    <option selected value=15>15th</option>
                                                                <?php } ?>
                                                            </select>
                                                            <select id="GroupMonth" name="GroupMonth" class="icon-pencil">
                                                                <?php
                                                                $monthOptions = array(
                                                                    date('m', strtotime('first day of -3 months')),
                                                                    date('m', strtotime('first day of -2 months')),
                                                                    date('m', strtotime('first day of last month')),
                                                                    date('m', strtotime('first day of this month')),
                                                                    date('m', strtotime('first day of +1 months')),
                                                                    date('m', strtotime('first day of +2 months')),
                                                                    date('m', strtotime('first day of +3 months')),
                                                                    date('m', strtotime('first day of +4 months')),
                                                                    date('m', strtotime('first day of +5 months')),
                                                                    date('m', strtotime('first day of +6 months')),
                                                                    date('m', strtotime('first day of +7 months')),
                                                                    date('m', strtotime('first day of +8 months')),
                                                                );
                                                                foreach ($monthOptions as $m) {
                                                                    $selected = (isset($_POST['GroupMonth']) && $_POST['GroupMonth'] == $m) ? 'selected' : '';
                                                                    echo "<option value = '".$m."' $selected>".NameToMonth($m)."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <select id="GroupYear" name="GroupYear"
                                                                    class="icon-pencil">

                                                                <?php for ($i=2017;$i <= date("Y")+3;$i++) {
                                                                    $selected = (isset($_POST['GroupYear']) && $_POST['GroupYear'] == $i) ? 'selected' : '';
                                                                    echo "<option $selected>$i</option>"; }
                                                                ?>
                                                            </select>
                                                            <button name = "DeathCall" type="submit" class="btn btn-primary">+</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo isset($_POST['StudentCode']) ? $_POST['StudentCode'] : ''; ?>" class="login"/>
                                            </form>
                                            <?php
                                            }

                                       /*/ echo "!i love mom !";
                                        echo "<br>";
                                        print_r($_POST);
                                        echo "<br>";
                                       /*/
                                            $GT = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : '';

                                        //echo $GT;
                                        $levelcode = isset($_POST['level_id']) ? (int)$_POST['level_id'] : 0;
                                        echo "<br>";
                                        $Studocode = isset($_POST['StudentCode']) ? $_POST['StudentCode'] : '';
                                            $datafromfrom = '';
                                            if (isset($_POST['GroupDay']) && isset($_POST['GroupMonth']) && isset($_POST['GroupYear']) && $_POST['GroupDay'] !== 'nothing' && $_POST['GroupMonth'] !== 'nothing' && $_POST['GroupYear'] !== 'nothing') {
                                                $gd = $_POST['GroupDay'];
                                                $gm = $_POST['GroupMonth'];
                                                $gy = $_POST['GroupYear'];
                                                if (strlen($gd) == 1) { $gd = "0".$gd; }
                                                $datafromfrom = $gy . "-" . $gm . "-" . $gd;
                                            }
                                        // Only run query when inputs valid
                                        if (!empty($GT) && $levelcode > 0 && !empty($datafromfrom)) {
                                            $Sqlforall = "SELECT `group_id`,`group_teacher` ,`group_startday` FROM `group` where `group_time` like '"
                                            . $GT . "' and `level_id` =" . $levelcode
                                            . " and `group_startday` = '" . $datafromfrom
                                            . "' order by `group_C_date` ";
                                            $resultTGT = mysqli_query($link,$Sqlforall );
                                            $rowTGT = $resultTGT ? mysqli_fetch_assoc($resultTGT) : null;
                                            echo "<br>";
                                            $rowcount = array('countthis' => 0);
                                            if (isset($_POST['DeathCall'])){
                                             $SqlToCheck = "SELECT count(*) as countthis FROM `group` where `group_time` like '"
                                            . $GT . "' and `level_id` =" . $levelcode
                                            . " and `group_startday` = '" . $datafromfrom
                                            . "' order by `group_C_date` ";
                                            $rcount = mysqli_query($link,$SqlToCheck );

                                            if ($rcount) {
                                                $rowcount = mysqli_fetch_assoc($rcount);
                                            }

                                        if ($rowcount && (int)$rowcount['countthis'] > 0){

                                            ?>

                                            <form action="RuleController.php" method="POST">

                                                <input type="hidden" id="levelcode" name="levelcode"
                                                       value="<?php echo $levelcode; ?>" class="login"/>
                                                <input type="hidden" id="fromtotime" name="fromtotime"
                                                       value="<?php echo $GT; ?>" class="login"/>
                                                <input type="hidden" id="groupid" name="groupid"
                                                       value="<?php echo $rowTGT ? $rowTGT['group_id'] : ''; ?>" class="login"/>
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo isset($_POST['StudentCode']) ? $_POST['StudentCode'] : ''; ?>" class="login"/>

                                                <ul style="float: left">
                                                    <label for="CoruseStartDate">Coruse Start Date</label>
                                                    <input type="text" id="CoruseStartDate" name="CoruseStartDate"
                                                           value="<?php echo $rowTGT ? $rowTGT['group_startday'] : ''; ?>"
                                                           class="login"/>
                                                </ul>
                                                <div class="control-group"><label class="control-label"
                                                                                  for="radiobtns">Teacher</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                <?php
                                                if ((int)$rowcount['countthis'] > 1)
                                                {
                                                    $resultTGT = mysqli_query($link,$Sqlforall );
                                                    ?><select name = "GroupTeacher" class="icon-pencil">
                                                    <?php
                                                    if ($resultTGT) {
                                                        while($teacherListarray = mysqli_fetch_array($resultTGT))
                                                        {
                                                            ?>
                                                            <option value = <?php echo $teacherListarray['group_teacher']; ?> >
                                                                <?php echo $teacherListarray['group_teacher']; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                    <?php
                                                }else {
                                                    ?>
                                                            <input type="text" id="GroupTeacher" name="GroupTeacher"
                                                                   value="<?php echo $rowTGT ? $rowTGT['group_teacher'] : ''; ?>"
                                                                   required class="login"/>
                                                <?php
                                                }
                                                ?>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->
                                                <?php
                                                }else {
                                                echo "<h3>Sorry, We Dont have Registered Group This Time</h3>";
                                            }
                                            }//end for the first if
                                        } // end guard for inputs valid

                                            ?>
                                            <div class="form-actions">
                                                <?php 
                                                if (isset($rowcount) && (int)$rowcount['countthis'] > 0)
                                                {
                                                    if ($RulesList == "MarkList"){
                                                        ?>
                                                        <button Name = "ControlB" value = "MarkListB" type="submit" class="btn btn-primary">Marks List</button>
                                                    <?php }
                                                    if ($RulesList == "AttendList") {
                                                        ?>
                                                        <button Name = "ControlB" value = "AttendList" type="submit" class="btn btn-primary">Attendance</button>
                                                    <?php }
                                                    if ($RulesList == "PaymList") {
                                                        ?>
                                                        <button Name = "ControlB" value = "PaymList" type="submit" class="btn btn-primary">Payment List</button>
                                                    <?php }
                                                } ?>
                                            </div> <!-- /form-actions -->
                                        </form>
                                </div>
                            </div>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
</body>
</html>
<?php } ?>
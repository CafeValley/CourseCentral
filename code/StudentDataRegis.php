<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("RegisRemove");
if (isset($_POST['RegisterID'])) {
    $RegisterId = $_POST['RegisterID'];
    $COCO = 'D';
    mysqli_query($link, "DELETE FROM `registration` WHERE `regis_id` = $RegisterId");
    mysqli_query($link, "DELETE FROM `extra_fees_holder` WHERE `Regis_id` = $RegisterId");
}
?>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-remove"></i>
                            <h3>Student Register Delete </h3></div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <form action = "StudentDataRegis.php" method = "POST">
                                        <?php if (isset($_POST['StudentCode'])) { ?>
                                            <ul style = "float: left">
                                                <label for = "group_id">Student Code</label>
                                                <button type = "submit" class = "btn btn-primary">+</button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type = "text" id = "StudentCode" name = "StudentCode"
                                                       value = "<?php echo $_POST['StudentCode']; ?>"
                                                       class = "login"/>
                                            </ul>
                                        <?php }
                                        else {
                                            ?>
                                            <div class = "controls">
                                                <div class = "input-append"><label class = "control-label"
                                                                                   for = "radiobtns">Student
                                                        Code</label>
                                                    <input type = "text" id = "StudentCode" required
                                                           name = "StudentCode" placeholder = "Student Code"
                                                           value = '' class = "login"/>
                                                    <button type = "submit" class = "btn btn-primary">+</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                    <?php if (isset($_POST['StudentCode'])) {
                                        $resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1))
											, SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)),
 											  SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
                                            . $_POST['StudentCode'] . " ");
                                        $rowSNC    = mysqli_fetch_array ($resultSNC);
                                        $Fname     = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                        $Sirname   = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                    } ?>

                                    <?php //here to display Name
                                    if (isset($Fname)) {
                                        ?>
                                        <div class = "controls">
                                            <div class = "input-append">
                                                <input type = "text" id = "StudentName" readonly
                                                       name = "StudentName" value = "<?php echo $Fname; ?>"
                                                       class = "login"/>
                                                <input type = "text" id = "StudentName" readonly
                                                       name = "StudentName" value = "<?php echo $Sirname; ?>"
                                                       class = "login"/>
                                            </div>
                                        </div>
                                        <?php

                                        $StudentId = $_POST['StudentCode'];
                                        $SqlCerStudent = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` 
												          FROM `registration` 
												          WHERE `st_id` = ". $StudentId . " and `status` = 1";


                                        $regissql  = mysqli_query ($link ,$SqlCerStudent);
                                        $num_rows  = mysqli_num_rows ($regissql);
                                        ?>
                                        <table border = "2" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Level</th>
                                                <th>Group Date</th>
                                                <th>Group Time</th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $n = 1;
                                            while ( $regissqlarray = mysqli_fetch_array ($regissql))
                                            {
                                            $RegisId = $regissqlarray['regis_id'];

                                                ?>
                                                <form action = "StudentDataRegis.php" method = "POST">
                                                    <input type = "hidden" name ="StudentCode" value = "<?php echo $StudentId;?>">
                                                    <input type = "hidden" name ="RegisterID" value = "<?php echo $RegisId;?>">
                                                <?php
                                                $levelid = $regissqlarray['level_id'];
                                                $Groupid = $regissqlarray['group_id'];
                                                $levelsql        = "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `level_C_date` 
                                                FROM `levels` 
                                                WHERE `Level_id` = " . $levelid;
                                                $sqlReturnlevel  = mysqli_query ($link ,$levelsql);
                                                $returnlevelarray = mysqli_fetch_array ($sqlReturnlevel);

                                                $LevelName = $returnlevelarray['level_name'];
                                                $LevelSpace = $returnlevelarray['level_period'];


                                                $groupsql        = "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date` 
												FROM `group`  
                                                WHERE `group_id` = " . $Groupid;
                                                $sqlReturnGroup  = mysqli_query ($link ,$groupsql);
                                                $sqlGrouparray = mysqli_fetch_array ($sqlReturnGroup);

                                                $GroupStartedDay = $sqlGrouparray['group_startday'];
                                                $GroupTime = $sqlGrouparray['group_time'];

                                                ?>


                                                <tr>
                                                    <td width="2%"><?php echo $n . ".";
                                                        $n = $n + 1; ?> </td>
                                                    <td><?php echo $LevelName; ?></td>
                                                    <td><?php echo $GroupStartedDay; ?></td>
                                                    <td><?php echo $GroupTime; ?></td>
                                                    <td width="2%"><button type = "submit" class = "btn btn-primary">
                                                            <i class="icon-trash"></i>
                                                        </button></td>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php
                            if (isset($_POST['StudentCode'])) {
                            if ($num_rows == 0 && $COCO != "D" ) {
                                ?>
                                <div class="alert alert-info">
                                    <button type="button" class="close"
                                            data-dismiss="alert">&times;</button>
                                    <strong>This</strong> Student is not Registered to any level.
                                </div>
                            <?php
                            }?>

                            <?php if ($COCO == "D") {?>
                            <div class="control-group">
                                <div class="controls">
                                    <div class="alert alert-success">
                                        <button type="button" class="close"
                                                data-dismiss="alert">&times;</button>
                                        Data
                                        <strong>Deleted</strong>.
                                    </div>
                                </div>
                            </div>
<?php }}?>


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
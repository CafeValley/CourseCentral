<?php
require_once "config.php";
//print_r($_POST);
//echo "still here !!";
//Level Name , Group Time , Group Day
if (isset($_POST['LID']))
    $LevelCode = $_POST['LID'];
else
    $LevelCode = $_POST['levelcode'];

if (isset($_POST['timefrominside']))
    $GroupTime = $_POST['timefrominside'];
else
    $GroupTime = $_POST['fromtotime'];

if (isset($_POST['Gid']))
    $Gid       = $_POST['Gid']; // here is not the name i given it to it , past code , need to revisit it ^^
else
    $Gid       = $_POST['groupid']; // here is not the name i given it to it , past code , need to revisit it ^^

//$_POST['StudentCode'];

if (isset($_POST['DateInside']))
    $CoruseStartingDate = $_POST['DateInside'];
else {
    list($year, $month, $day) = explode("-", $_POST['CoruseStartDate']);
    $CoruseStartingDate = $day . "-" . $month . "-" . $year;
}
//$_POST['GroupTeacher'];
$ControlB = $_POST['ControlB'];

$resultNameL = mysqli_query($link, "SELECT  CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name FROM `levels` where Level_id = $LevelCode");
$rowNameL = mysqli_fetch_assoc($resultNameL);
$LevelName = isset($rowNameL['level_name']) ? $rowNameL['level_name'] : 'Unknown Level';

// Get teacher ID from group table
$resultTeacherID = mysqli_query($link, "SELECT `group_teacher` FROM `group` WHERE `group_id` = $Gid");
$rowTeacherID = mysqli_fetch_assoc($resultTeacherID);
$TeacherID = isset($rowTeacherID['group_teacher']) ? $rowTeacherID['group_teacher'] : null;

// Get teacher name from teachers table using the ID
$TeacherName = '';
if ($TeacherID && is_numeric($TeacherID)) {
    $resultTeacherN = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3` FROM `teachers` WHERE `id` = " . (int)$TeacherID);
    $rowTeacherN = mysqli_fetch_assoc($resultTeacherN);
    if ($rowTeacherN) {
        $Fname = $rowTeacherN['name'] . " " . $rowTeacherN['name2'];
        $Sirname = " " . $rowTeacherN['name3'];
        $TeacherName = trim($Fname . " " . $Sirname);
        if (empty($TeacherName)) {
            $TeacherName = "Teacher ID: " . $TeacherID;
        }
    } else {
        $TeacherName = "Teacher ID: " . $TeacherID;
    }
} else {
    $TeacherName = $TeacherID ? $TeacherID : "Unknown";
}


$RulesDisplay = "Teacher: $TeacherName <br>Course ".$LevelName." Time: ".$GroupTime."  Starting on the  ".$CoruseStartingDate;
echo "<br>";

/*
 * in this if(s) to know which one to come too
 * when its done */

if (isset($_POST['WhichOne']))
{
    if($_POST['WhichOne'] == "MarkListB")
        $ControlB ="MarkListB";
    if($_POST['WhichOne'] == "AttendList" )
        $ControlB ="AttendList";
    if($_POST['WhichOne'] == "PaymList" )
        $ControlB ="PaymList";
}
//--ending for the control if(s)
if ($ControlB == "MarkListB")
{
    require_once "MainBarAfterLoginIn.php";
    maincheck("MarkControl");

    if (isset($_POST['iamblue']))
        echo "to edit";

    if (isset($_POST['savedindb'])) {
        //print_r($_POST);

        $POSTedGid = $Gid;
        $POSTedLid = $_POST['LID'];

        foreach ($_POST as $key => $value) {
            $key1 = preg_replace('/[0-9]+/', '', $key);
            $key2 = preg_replace("/[^0-9]/", "", $key);
            if ($key1 == "s_Name") {
                $Names[ $key2 ] = $value;
            }
            if ($key1 == "Mark") {
                if ($value != "")
                    $Marks[ $key2 ] = $value;
                else
                    $Marks[ $key2 ] = -1;
            }
        }

        $max = sizeof($Names);
        for ($z = 1; $z <= $max; $z++) {
            $AllowToGetMark =  (CalRem($Names[$z],$Gid));
            $AllowToGetMark[0];//total fees
            if ($AllowToGetMark[1] == 0)
            {
            $sql = mysqli_query($link, "SELECT count(mark) FROM `mark` WHERE `s_id` = " . $Names[ $z ] . " and `level_id` =" . $POSTedLid . " and `group_id` =" . $POSTedGid . " ");
            // If result matched $username and $password.
            $count = mysqli_fetch_array($sql);
            if ($count[0] > 0)
                echo "Sorry, Ask admin to change old Marks.";
            else
                mysqli_query($link, $changedSQL = "INSERT INTO `mark`(`mark_id`, `s_id`, `level_id`, `group_id`, `mark`,`M_created_date`) 
VALUES (NULL,$Names[$z],$POSTedLid,$POSTedGid,$Marks[$z],NOW())");
            //$rowLmark = mysql_fetch_array($resultmark);

            //////
            mysqli_query($link, $statusSQL = "UPDATE `registration` SET `status`=0 WHERE `st_id` = " . $Names[ $z ] . " and `level_id` =" . $POSTedLid . " and `group_id` =" . $POSTedGid . " ");
            //////
            //$gotmark = $rowLmark['mark'];

            //
        }else
            {
                echo "<br>";
                spacingformat(12);
                echo " Sorry , ".StudentName($Names[$z]).
                    "needs to pay ".$AllowToGetMark[1];
            }
        }
    }
    ?>

    <style type="text/css">

        input, textarea {
            height :40px;
            width: 120px;
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

    </style>
    <div class="main">
        <div class="main-inner">
            <div id="printableArea" class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">
                            <div class="widget-header"><i class="icon-user"></i>
                                <h3>Marks List</h3></div>
                            <form action="RuleController.php" method="POST">
                                <?php //print_r($_POST);
                                //Array (
                                $thislevelid =  $_POST['levelcode'];
                                $thisgroupid =  $_POST['groupid'];
                                //
                                ?>
                                <input type = "hidden" name = "Gid" value="<?php echo $Gid; ?>">
                                <input type = "hidden" name = "WhichOne" value = "MarkListB">
                                <input type = "hidden" name = "timefrominside" value = "<?php echo $GroupTime; ?>">
                                <input type = "hidden" name = "DateInside" value = "<?php echo $CoruseStartingDate; ?>">
                                <?php
                                $resultsgs = mysqli_query($link, "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `st_id` not in (SELECT  `s_id` FROM `freeze` where `level_id` = $thislevelid and `group_id` = $thisgroupid and `status` = 1 ) and `group_id` = " . $Gid  );
                                ?>
                                <table class="table table-striped table-bordered">
                                    <thead><tr>
                                        <th>No</th>
                                        <th> Student Name</th>
                                        <th> Degree</th>
                                        <th> ID</th>
                                        <th> Telephone</th>
                                    </tr></thead>
                                    <tbody>
                                    <?php
                                    $i = 0; $n = 1;
                                    while ($rowsgs = mysqli_fetch_array($resultsgs)) {
                                        /***************************
                                         * here to get the name for each studnet starting with the name
                                         ***************************/
                                        $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = " . $rowsgs['st_id'] . "");
                                        $rowSNC    = mysqli_fetch_array($resultSNC);
                                        // Check if query returned results before accessing array
                                        if (!$rowSNC) {
                                            continue; // Skip this iteration if student not found
                                        }
                                        $Fname     = (isset($rowSNC['S_firstname']) ? $rowSNC['S_firstname'] : '') . " " . (isset($rowSNC['S_midname1']) ? $rowSNC['S_midname1'] : '');
                                        $Sirname   = " " . (isset($rowSNC['S_midname2']) ? $rowSNC['S_midname2'] : '') . " " . (isset($rowSNC['S_lastname1']) ? $rowSNC['S_lastname1'] : '');
                                        $fullName  = $Fname . " " . $Sirname;
										$phonepace = (isset($rowSNC['S_phone1']) ? $rowSNC['S_phone1'] : '') . " " . (isset($rowSNC['S_phone2']) ? $rowSNC['S_phone2'] : '');
                                        $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name , `level_fees` , `level_book` , `level_period` , `level_C_date` FROM `levels` WHERE `Level_id` = " . $rowsgs['level_id'] . "");
                                        $rowLinfo    = mysqli_fetch_array($resultLinfo);
                                        //here to have the main display for the form
                                        if ($i == 0) {
                                            echo "<br>";
                                            echo  $RulesDisplay;
                                            echo "<br>";
                                            $i += 1;
                                        }
                                        //$levelfullFees = $rowLinfo['level_fees'] + $rowLinfo['level_book'] - $rowsgs['discount'];
                                        //$feesleft      = $levelfullFees - $rowsgs['paid_fees'];

                                        $resultmark = mysqli_query($link, "SELECT `mark` FROM `mark` WHERE `s_id` = " . $rowsgs['st_id'] . " and `level_id` =" . $rowsgs['level_id'] . " and `group_id` =" . $Gid . " ");
                                        $rowLmark   = mysqli_fetch_array($resultmark);
                                        // Check if query returned results before accessing array
                                        $gotmark = ($rowLmark && isset($rowLmark['mark'])) ? $rowLmark['mark'] : null;
                                        $levelid = $rowsgs['level_id'];
                                        ?>
                                        <tr>
                                            <td width="2%"><?php echo $n.".";?></td>
                                            <td width="30%"><h4><?php echo $fullName ?></h4></td>
                                            <input type="hidden" value= <?php echo $rowsgs['st_id']; ?> name = "s_Name<?php echo $n; ?>" >
                                            <td><input  type="text" name="Mark<?php echo $n; ?>" value="<?php
                                                if (isset($gotmark))
                                                    if ($gotmark != -1)
                                                        echo $gotmark;
                                                    else
                                                        echo "";
                                                else
                                                    echo "0";
                                                ?>" style="
  height: 30px;
  padding: 5px 10px;
  font-size: 12px;
                                                ">
                                            </td>
											<td><?php echo $rowsgs['st_id'];?></td>
											<td><?php echo $phonepace;?></td>

											</tr>
                                        <?php
                                        $n = $n + 1;
                                    } ?>
                                    <input type="hidden" name="LID" value="<?php echo $levelid; ?>">
                                    </tbody>
                                </table>
								<div class="form-actions">
            <script>
                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;
                }
            </script>
            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!" />
       
                                    <button type="submit" name="savedindb" class="btn btn-primary"> Save </button>
                                </div> <!-- /form-actions -->
                            </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="extra">
        <div class="extra-inner">
            <div class="container">
                <div class="row"></div>
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
<?php }
if ($ControlB == "AttendList")
{
    require_once "MainBarAfterLoginIn.php";
    maincheck("AttendControl"); ?>
    <div class="main">
        <div class="main-inner">
            <div id="printableArea" class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">
                            <!--
                            **********************************
                            Here for the for input
                            **********************************
                            -->
                            <div class="widget-header"><i class="icon-user"></i>
                                <h3>Attendance List</h3></div> <!-- Form Naming -->
                            <div class="widget-content">
                                <div class="tabbable">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="jscontrols">

                                            <form action="RuleController.php" method="POST">
                                                <input type="hidden" name="GID" value="<?php echo $Gid ?>">
                                                <input type = "hidden" name = "WhichOne" value = "AttendList">
                                                <input type = "hidden" name = "timefrominside" value = "<?php echo $GroupTime; ?>">
                                                <input type = "hidden" name = "DateInside" value = "<?php echo $CoruseStartingDate; ?>">
                                                <?php
                                                $resultsgs = mysqli_query($link, "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `status` = 1 and `group_id` = " . $Gid . "");
                                                ?>
                                                <table border = "2" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <td>.</td>
                                                        <td>.</td>
                                                        <td>.</td>
                                                        <td>.</td>
                                                        <td>.</td>
                                                        <td>.</td>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0;
                                                    $Snames = array();
                                                    //$SlotsPerDay[] = $rowset['StartTime'];
                                                    $loc = 0 ;
                                                    $loc2 = 0;
                                                    while ($rowsgs = mysqli_fetch_array($resultsgs))
                                                    {
                                                        /***************************
                                                         * here to get the name for each studnet starting wtih the name
                                                         ***************************/
                                                        $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = " . $rowsgs['st_id'] . "");
                                                        $rowSNC    = mysqli_fetch_array($resultSNC);
                                                        // Check if query returned results before accessing array
                                                        if (!$rowSNC) {
                                                            continue; // Skip this iteration if student not found
                                                        }
                                                        $Fname     = (isset($rowSNC['S_firstname']) ? $rowSNC['S_firstname'] : '') . " " . (isset($rowSNC['S_midname1']) ? $rowSNC['S_midname1'] : '');
                                                        $Sirname   = " " . (isset($rowSNC['S_midname2']) ? $rowSNC['S_midname2'] : '') . " " . (isset($rowSNC['S_lastname1']) ? $rowSNC['S_lastname1'] : '');
                                                        $SPhoneN = isset($rowSNC['S_phone1']) ? $rowSNC['S_phone1'] : '';
                                                        $fullName  = $Fname . " " . $Sirname;
                                                        $Snames[$loc][] = $fullName;
                                                        $Snames[$loc2][] = $SPhoneN;
                                                        $loc +=1;
                                                        $loc2 +=1;
                                                        $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name , `level_fees` , `level_book` , `level_period` , `level_C_date` FROM `levels` WHERE `Level_id` = " . $rowsgs['level_id'] . "");
                                                        $rowLinfo    = mysqli_fetch_array($resultLinfo);
                                                        if ($i == 0) {
                                                            echo  $RulesDisplay;
                                                            $i += 1; }
                                                    }
                                                    sort($Snames);
                                                    $k=0;
                                                   while (isset($Snames[$k]))
                                                   {
                                                       ?>
                                                       <tr>
                                                           <td width="2%"><?php echo  $k+1;
                                                               echo ".";?></td>
                                                           <td width="30%"><h4><?php echo $Snames[$k][0]; ?></h4></td>
                                                           <input type="hidden" value= <?php echo $rowsgs['st_id']; ?> name
                                                           = "s_Name<?php echo $n; ?>" >
                                                           <td width="7%" height="15%"><?php echo $Snames[$k][1]; ?></td>
                                                           <td width="7%" height="15%">.</td>
                                                           <td width="7%" height="15%">.</td>
                                                           <td width="7%" height="15%">.</td>
                                                           <td width="7%" height="15%">.</td>
                                                           <td width="7%" height="15%">.</td>
                                                           <td width="7%" height="15%">.</td>
                                                       </tr>
                                                    <?php $k=$k+1; } ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <script>
                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;
                }
            </script>
            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!" />
        </div> <!-- /form-actions --></div>
    <div class="extra">
        <div class="extra-inner">
            <div class="container">
                <div class="row"></div>
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
<?php }
if ($ControlB == "PaymList")
{
    require_once "MainBarAfterLoginIn.php";
    maincheck("PayControl"); ?>
    <div class="main">
        <div class="main-inner">
            <div id="printableArea" class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">
                            <!--
                            **********************************
                            Here for the for input
                            **********************************
                            -->
                            <div class="widget-header"><i class="icon-user"></i>
                                <h3>Payment Group Details</h3></div> <!-- Form Naming -->
                            <div class="widget-content">
                                <div class="tabbable">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="jscontrols">

                                            <form action="RuleController.php" method="POST">
                                                <input type="hidden" name="GID" value="<?php echo $Gid ?>">
                                                <input type = "hidden" name = "WhichOne" value = "PaymList">
                                                <input type = "hidden" name = "timefrominside" value = "<?php echo $GroupTime; ?>">
                                                <input type = "hidden" name = "DateInside" value = "<?php echo $CoruseStartingDate; ?>">
                                                <?php
                                                $resultsgs = mysqli_query($link, "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` 
                                                                                  FROM `registration` WHERE `status` = 1 and `group_id` = " . $Gid );
                                                ?>
                                                <table border = "2" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>ID</th>
                                                        <th>Fees Paid</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0;
                                                    $Snames = array();
                                                    //$SlotsPerDay[] = $rowset['StartTime'];
                                                    $loc = 0 ;
                                                    $loc2 = 0;
                                                    $loc3 = 0;
                                                    $loc4 = 0;
                                                    while ($rowsgs = mysqli_fetch_array($resultsgs))
                                                    {
                                                        /***************************
                                                         * here to get the name for each studnet starting wtih the name
                                                         ***************************/
                                                        $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = " . $rowsgs['st_id'] . "");
                                                        $rowSNC    = mysqli_fetch_array($resultSNC);
                                                        // Check if query returned results before accessing array
                                                        if (!$rowSNC) {
                                                            continue; // Skip this iteration if student not found
                                                        }

                                                        $Student_Id = $rowsgs['st_id'];
                                                        $Group_Id = $rowsgs['group_id'];;
                                                        $SqltoLevel = mysqli_query($link, "SELECT `level_id` FROM `group` 
                                                        WHERE `group_id` = '$Group_Id' ");
                                                        $returntoLevel = mysqli_fetch_array($SqltoLevel);
                                                        // Check if query returned results before accessing array
                                                        if (!$returntoLevel || !isset($returntoLevel['level_id'])) {
                                                            continue; // Skip this iteration if group not found
                                                        }
                                                        $NLevelId = $returntoLevel['level_id'];
                                                        $resultLinfo = mysqli_query($link, "SELECT  `level_fees` , `level_book` , `level_period` , `level_C_date` 
                                                            FROM `levels` 
                                                            WHERE `Level_id` = '$NLevelId '");

                                                            $SqlCommandForCFe = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `group_id` = '"
                                                                . $Group_Id . "' and `level_id` = $NLevelId and `st_id` = $Student_Id and status = 1";
                                                            $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);

                                                            while ($rowsgs = mysqli_fetch_array($CheckIfHereInF)) {
                                                                $RegisID = $rowsgs['regis_id'];
                                                                /***************************
                                                                 * here to get the name for each studnet starting wtih the name
                                                                 ***************************/
                                                                $rowLinfo = mysqli_fetch_array($resultLinfo);
                                                                // Check if query returned results before accessing array
                                                                if (!$rowLinfo || !isset($rowLinfo['level_fees'])) {
                                                                    continue; // Skip this iteration if level info not found
                                                                }
                                                                $resultoldpayment = mysqli_query($link, "SELECT sum(payment) as payment FROM `paymenttwo` 
                                                                  WHERE `s_id` = "
                                                                    . $Student_Id . " and `level_id` =" . $rowsgs['level_id'] . " and `group_id` =" . $Group_Id );
                                                                $rowoldpayment = mysqli_fetch_array($resultoldpayment);
                                                                //if paid something
                                                                if (isset($rowoldpayment['payment']))
                                                                    $S_payment = $rowoldpayment['payment'];
                                                                else
                                                                    $S_payment = 0;
                                                                $sqlEarly = "SELECT `EFH_id`, `Regis_id`, `type`, `Amount`, `WhenEFH` FROM `extra_fees_holder`
                                                                where Regis_id = $RegisID";
                                                                $RetEarly = mysqli_query($link, $sqlEarly);
                                                                $FetchRetEarly   = mysqli_fetch_array ($RetEarly);
                                                                // Check if query returned results before accessing array
                                                                if ($FetchRetEarly && isset($FetchRetEarly['type'])) {
                                                                    switch ($FetchRetEarly['type'])
                                                                    {
                                                                        case "Early" :
                                                                            $ExFee = -$FetchRetEarly['Amount'];
                                                                            break;
                                                                        case "Penalty":
                                                                            $ExFee = -$FetchRetEarly['Amount'];
                                                                            break;
                                                                        default:
                                                                            $ExFee = 0;
                                                                    }
                                                                } else {
                                                                    $ExFee = 0;
                                                                }

                                                                $levelfullFees = CalaDiscount($rowLinfo['level_fees'],$rowsgs['discount']) ;

                                                                $feesleft =  $levelfullFees - (($rowsgs['paid_fees'] + $S_payment) ) + $ExFee;

                                                                /***************************
                                                                 * data about level
                                                                 ***************************/
                                                            }

                                                        $levelfullFees;

                                                        $Fname     = (isset($rowSNC['S_firstname']) ? $rowSNC['S_firstname'] : '') . " " . (isset($rowSNC['S_midname1']) ? $rowSNC['S_midname1'] : '');
                                                        $Sirname   = " " . (isset($rowSNC['S_midname2']) ? $rowSNC['S_midname2'] : '') . " " . (isset($rowSNC['S_lastname1']) ? $rowSNC['S_lastname1'] : '');
                                                        $SPhoneN = isset($rowSNC['S_phone1']) ? $rowSNC['S_phone1'] : '';
                                                        $SSID = $Student_Id;
                                                        $fullName  = $Fname . " " . $Sirname;
                                                        $Snames[$loc][] = $fullName;
                                                        $Snames[$loc2][] = $SPhoneN;
                                                        $Snames[$loc3][] = $SSID;
                                                        $Snames[$loc4][] = $levelfullFees;

                                                        $loc +=1;
                                                        $loc2 +=1;
                                                        $loc3 +=1;
                                                        $loc4 +=1;
                                                        $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name , `level_fees` , `level_book` , `level_period` , `level_C_date` FROM `levels` WHERE `Level_id` = " . $rowsgs['level_id'] . "");
                                                        $rowLinfo    = mysqli_fetch_array($resultLinfo);
                                                        if ($i == 0) {
                                                            echo  $RulesDisplay;
                                                            $i += 1; }
                                                    }
                                                    sort($Snames);
                                                    $k=0;
                                                    $TotalofPay = 0;
                                                    while (isset($Snames[$k]))
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td width="2%"><?php echo  $k+1;
                                                                echo ".";?></td>
                                                            <td width="30%"><h4><?php echo $Snames[$k][0]; ?></h4></td>
                                                            <input type="hidden" value= <?php echo $rowsgs['st_id']; ?> name
                                                            = "s_Name<?php echo $n; ?>" >
                                                            <td width="7%" height="15%"><?php echo $Snames[$k][1]; ?></td>
                                                            <td width="7%" height="15%"><?php echo $Snames[$k][2]; ?></td>
                                                            <td width="7%" height="15%"><?php echo $Snames[$k][3]; ?></td>
                                                            <?php
                                                            $TotalofPay += $Snames[$k][3];
                                                            ?>

                                                        </tr>
                                                        <?php $k=$k+1; } ?>
                                                    </tbody>
                                                </table>
                                                <table>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><strong><i><?php
                                                        echo $TotalofPay;
                                                        ?></i></strong></td>

                                                </tr>
                                                </table>
                                            </form>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <script>
                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                    window.print();

                    document.body.innerHTML = originalContents;
                }
            </script>
            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!" />
        </div> <!-- /form-actions --></div>
    <div class="extra">
        <div class="extra-inner">
            <div class="container">
                <div class="row"></div>
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
<?php } ?>
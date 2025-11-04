<?php
// Secure session configuration (MUST be before session_start())
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
// ini_set('session.cookie_secure', 1); // Uncomment when using HTTPS

session_start();
if (session_id() == "") {
    echo "Nothing works!";
    exit();
}
ob_start();

date_default_timezone_set("Africa/Khartoum");

// Global system name variable
$SYSTEM_NAME = "CourseCentral";

// Include helper functions
require_once __DIR__ . "/helpers.php";

if (isset($_SESSION['suser_name']))
    $suser_name = $_SESSION['suser_name'];

////$today = date("d/m/y",$today); in this convert !
$hostname = 'localhost';
//192.168.3.1
$dbusername = 'root';             // Your old database username.
//$dbpassword = 'WanthtcM8';
$dbpassword = 'oracleoracle';                 // Your old database password. If your database has no password, leave it empty.
$dbname = 'concor';                 // Your old database name.
//$dbname2nd = 'concor_fileholder';                 // Your old database name. (DISABLED - Second database not in use)
$today = date("Y-m-d");

//here to set the date , with the correct format
//$today = "2017-12-14";

list($Tyear, $Tmonth, $Tday) = explode("-", $today);

// Database connection with error handling
$link = new mysqli($hostname, $dbusername, $dbpassword, $dbname);

// Check connection
if ($link->connect_error) {
    // Log error but don't expose details to users
    error_log("Database connection failed: " . $link->connect_error);
    die("System temporarily unavailable. Please try again later.");
}

// Set charset to prevent character encoding issues
$link->set_charset("utf8");

//$link2nd = new mysqli("$hostname", "$dbusername", "$dbpassword", "$dbname2nd");



function spacingformat($i)
{
    for ($s = 0; $s < $i; $s++)
        echo "&nbsp;";
}
/*
 *
 * in this function will give the id and the value
 *  of the last active fees
 * (Student,registration,EarlyBird,Freeze,unfreeze)
 * example     print_r(FeesData("Student"));*/


function FeesData($Fee_C_Name)
{
    global $link;
    switch ($Fee_C_Name)
    {
        case "EarlyBird":
            $Fee_C_Name ="Early_Bird_Fees";
            break;
        case "Student":
            $Fee_C_Name ="Student_Fees";
            break;
        case "Registration":
            $Fee_C_Name ="Registration_Fees";
            break;
        case "Freeze":
            $Fee_C_Name ="Freeze_Fees";
            break;
        case "Unfreeze":
            $Fee_C_Name ="Unfreeze_Fees";
            break;
    }
    $SqlCommandForCFe = "SELECT `F_C_id`,`F_value`  FROM `fees_change` WHERE F_name = '$Fee_C_Name' and F_active = 1 ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

    //$CheckIfCount = mysqli_num_rows($CheckIfHereInF);
    $F_id_FR = $CheckIfReturnInF['F_C_id'];
    $F_V_FR  = $CheckIfReturnInF['F_value'];
    return array ($F_id_FR,$F_V_FR);
}
/*
 * takes the fees and the % of its discount and returns
 * the amount after the discount
  example echo CalaDiscount(300,50);
 * */
function CalaDiscount($DiscountValue,$DiscountPer)
{
    // Convert to numeric values to prevent string multiplication errors
    $DiscountValue = (float)$DiscountValue;
    $DiscountPer = preg_replace('/[^0-9]/', '', $DiscountPer);
    $DiscountPer = (float)$DiscountPer;
    if ($DiscountPer == 0)
    {
        return ($DiscountValue);
    }
    $DiscountMin = ( $DiscountValue * $DiscountPer ) / 100;
    $TotalPayAfterDis =$DiscountValue - $DiscountMin;
    return ($TotalPayAfterDis);
}

/*in this function input the student id , and gives back the
cash that required out of him ,

 <?php print_r (CalRem(17811,1));?>
example for the use
0 for he is free or cash money !!! */
function CalRem($Student_Id,$Group_Id)
{
    global $link;
    $SqltoLevel = mysqli_query($link, "SELECT `level_id` , `feesforgroup` , `feesforbookgroup` FROM `group` 
WHERE `group_id` = '$Group_Id' ");
    $returntoLevel = mysqli_fetch_array($SqltoLevel);

    // Check if query returned results
    if (!$returntoLevel) {
        return array(0, 0);
    }

    $ThisGroupFees = $returntoLevel['feesforgroup'];
    $ThisGroupBooksFees = $returntoLevel['feesforbookgroup'];

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

        $levelfullFees = CalaDiscount( $ThisGroupFees,$rowsgs['discount']) + $ThisGroupBooksFees;

          $feesleft =  $levelfullFees - (($rowsgs['paid_fees'] + $S_payment) ) + $ExFee;

            /***************************
             * data about level
             ***************************/
    }
return array ($levelfullFees,$feesleft);
}

function CalRemFromSelectedGroup($Student_Id,$Group_Id)
{
    global $link;
    $SqlOfGroup = "SELECT `level_id` , `feesforgroup` , `feesforbookgroup`  FROM `group` 
                    WHERE `group_id` = '$Group_Id' ";

    $SqltoLevel = mysqli_query($link, $SqlOfGroup);
    $returntoLevel = mysqli_fetch_array($SqltoLevel);

    // Check if query returned results
    if (!$returntoLevel) {
        return array(0, 0);
    }

    $ThisGroupFees = $returntoLevel['feesforgroup'];
    $ThisGroupBooksFees = $returntoLevel['feesforbookgroup'];

    $NLevelId = $returntoLevel['level_id'];
    $resultLinfo = mysqli_query($link, "SELECT  `level_fees` , `level_book` , `level_period` , `level_C_date` 
                                            FROM `levels` 
                                            WHERE `Level_id` = '$NLevelId '");

    $SqlCommandForCFe = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `group_id` = '"
        . $Group_Id . "' and `level_id` = $NLevelId and `st_id` = $Student_Id ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);

    while ($rowsgs = mysqli_fetch_array($CheckIfHereInF)) {
        $RegisID = $rowsgs['regis_id'];
        /***************************
         * here to get the name for each studnet starting wtih the name
         ***************************/
        $rowLinfo = mysqli_fetch_array($resultLinfo);
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

        $levelfullFees = CalaDiscount( $ThisGroupFees,$rowsgs['discount']) + $ThisGroupBooksFees;

        $feesleft =  $levelfullFees - (($rowsgs['paid_fees'] + $S_payment) ) + $ExFee;

        /***************************
         * data about level
         ***************************/
    }
    return array ($levelfullFees,$feesleft);
}


function StudentName($Student_Id)
{
    global $link;
    $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
        . $Student_Id . " ");
    $rowSNC = mysqli_fetch_array($resultSNC);
 //here need to add number of rows return !!!!!
    // if its less than 1 then return 0 !
    // Check if query returned results before accessing array
    if (!$rowSNC || !isset($rowSNC['S_firstname'])) {
        return '';
    }
    $Fname = (isset($rowSNC['S_firstname']) ? $rowSNC['S_firstname'] : '') . " " . (isset($rowSNC['S_midname1']) ? $rowSNC['S_midname1'] : '');
    $Sirname = " " . (isset($rowSNC['S_midname2']) ? $rowSNC['S_midname2'] : '') . " " . (isset($rowSNC['S_lastname1']) ? $rowSNC['S_lastname1'] : '');
    $FullName =$Fname." ".$Sirname;
    return ($FullName);
}
function StudentBirthday($Student_Id)
{
    global $link;
    $resultSNC = mysqli_query($link, "SELECT  `S_Birthdate` FROM `student` WHERE `ST_Gid` = "
        . $Student_Id . " ");
    $rowSNC = mysqli_fetch_array($resultSNC);
 //here need to add number of rows return !!!!!
    // if its less than 1 then return 0 !
    // Check if query returned results before accessing array
    if (!$rowSNC || !isset($rowSNC['S_Birthdate'])) {
        return '';
    }
    $Bday = $rowSNC['S_Birthdate'];
    return ($Bday);
}

function StudentName1to2($Student_Id)
{
    global $link;
    $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
        . $Student_Id . " ");
    $rowSNC = mysqli_fetch_array($resultSNC);
    //here need to add number of rows return !!!!!
    // if its less than 1 then return 0 !
    // Check if query returned results before accessing array
    if (!$rowSNC || !isset($rowSNC['S_firstname'])) {
        return '';
    }
    $Fname = (isset($rowSNC['S_firstname']) ? $rowSNC['S_firstname'] : '') . " " . (isset($rowSNC['S_midname1']) ? $rowSNC['S_midname1'] : '');
    $Sirname = " " . (isset($rowSNC['S_midname2']) ? $rowSNC['S_midname2'] : '') . " " . (isset($rowSNC['S_lastname1']) ? $rowSNC['S_lastname1'] : '');
    $FullName =$Fname;
    return ($FullName);
}

function Studenttelephone($Student_Id)
{
    global $link;
    $resultSNC = mysqli_query($link, "SELECT `S_phone1`, `S_phone2` FROM `student` WHERE `ST_Gid` = "
        . $Student_Id . " ");
    $rowSNC = mysqli_fetch_array($resultSNC);
    //here need to add number of rows return !!!!!
    // if its less than 1 then return 0 !
    // Check if query returned results before accessing array
    if (!$rowSNC) {
        return '';
    }
    $FullName = (isset($rowSNC['S_phone1']) ? $rowSNC['S_phone1'] : '') . " " . (isset($rowSNC['S_phone2']) ? $rowSNC['S_phone2'] : '');
   
    return ($FullName);
}

function LevelName($Level_Id)
{
    global $link;

    $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name  FROM `levels` 
                                        WHERE `Level_id` = " . $Level_Id . " ");
    $rowLinfo    = mysqli_fetch_array($resultLinfo);
    // Check if query returned results before accessing array
    if (!$rowLinfo || !isset($rowLinfo['level_name'])) {
        return '';
    }
    $LevelName = $rowLinfo['level_name'];
    return ($LevelName);
}

/*example $DaysSpentAF = dateDifference($today , $GroupStartedDay , $differenceFormat = '%a');
*/
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}

/*here created a funcation to from the registration id
to get level id , student id , level id */
function GetDataFromRegister($Regis_Id)
{
    global $link;
    $SqlToGetRegisData = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE  `regis_id`= $Regis_Id";
    $ReturnOfRegisData      = mysqli_query ($link , $SqlToGetRegisData);
    //$CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);
    //$CheckIfCount = mysqli_num_rows($CheckIfHereInF);
    $ArrayOfRegisData = mysqli_fetch_array($ReturnOfRegisData);
    $st_id    = $ArrayOfRegisData['st_id'];
    $group_id = $ArrayOfRegisData['group_id'];
    $level_id = $ArrayOfRegisData['level_id'];
    return array ($st_id,$group_id,$level_id);
}

function GetMaxID()
{
    global $link;
    $resultForSetID = mysqli_query($link, "SELECT `IDSet` FROM `placelastnumberincrement` order by `PlaceLastNumberIncrementID` DESC  ");
    $returnForSetID = mysqli_fetch_array($resultForSetID);
    // Check if result is null before accessing array offset
    if ($returnForSetID && isset($returnForSetID['IDSet'])) {
        return $returnForSetID['IDSet'];
    }
    return 1; // Return default value if no result found
}
function DisplayInterval($Par = NULL)
{
    // Initialize variables to prevent undefined array key warnings
    $n1 = null;
    $n2 = null;
    $n3 = null;
    $n4 = null;
    
    // Only explode if $Par is not null and is a string
    if ($Par !== NULL && is_string($Par) && trim($Par) !== '') {
        $parts = explode(" ", $Par);
        $n1 = isset($parts[0]) ? $parts[0] : null;
        $n2 = isset($parts[1]) ? $parts[1] : null;
        $n3 = isset($parts[2]) ? $parts[2] : null;
        $n4 = isset($parts[3]) ? $parts[3] : null;
    }
    
    // Convert $n1 to integer for safe arithmetic operations
    $n1 = $n1 !== null ? (int)$n1 : null;
    
    if ($n4 == "am" && $n1 !== null)
        $n1 += 0 ;
    if ($n4 == "pm" && $n1 !== null)
        $n1 += 12 ;
    global $link;
    ?>
    <select id="GroupTime" name="GroupTime" class="icon-pencil" required>
        <?php if (isset($Par)) { ?>
            <option value='nothing'>Group Time</option>
            <?php } else { ?>
            <option selected value='nothing'>Group Time</option>
        <?php }
        $SqlTime       = mysqli_query ($link , "SELECT `CorusesTimeId`, `TimeB`, `TimeSize` FROM `corusestime` order by `TimeB` ASC  ");
        $SqlTimeCount  = mysqli_num_rows($SqlTime);
        if ($SqlTimeCount > 0)
        {
            while($SqlTimeReturn = mysqli_fetch_array ($SqlTime))
            {
                $checked = 0; // Initialize checked variable
                $TimeSet = $SqlTimeReturn['TimeB'];
                if ($n1 !== null && $n1 == $TimeSet)
                {
                    $checked = 1;
                };
                $CTimeId = $SqlTimeReturn['CorusesTimeId'];
                if ($TimeSet < 12)
                    $AmorPm = "am";
                if ($TimeSet > 12)
                {
                    $AmorPm = "pm";
                    $TimeSet -= 12;
                }
                $TimeSetEnd = $TimeSet + $SqlTimeReturn['TimeSize'];
                if ($TimeSetEnd > 12)
                    $TimeSetEnd -= 12 ;

                if ($checked == 1)
                {
                    ?>
                    <option selected value='<?php echo $CTimeId;?>'><?php echo $TimeSet;?> - <?php echo $TimeSetEnd." ".$AmorPm;?></option>
                <?php
                    $checked = 0;
                }else {
                ?>
                <option value='<?php echo $CTimeId;?>'><?php echo $TimeSet;?> - <?php echo $TimeSetEnd." ".$AmorPm;?></option>
                    <?php
                }
            }
        } ?>
    </select> <?php
}
function GetTimefromID($id)
{
    global $link;
    
    // Return empty string if ID is null, empty, or not numeric
    if ($id === null || $id === '' || !is_numeric($id)) {
        return '';
    }
    
    // Sanitize the ID to prevent SQL injection
    $id = (int)$id;
    
    $resultGetTimefromID = mysqli_query($link, "SELECT `CorusesTimeId`, `TimeB`, `TimeSize` FROM `corusestime` WHERE `CorusesTimeId` = $id");
    
    // Check if query was successful and returned results
    if (!$resultGetTimefromID) {
        return '';
    }
    
    $returnGetTimefromID = mysqli_fetch_array($resultGetTimefromID);
    
    // Check if we got valid data
    if (!$returnGetTimefromID || !isset($returnGetTimefromID['TimeB'])) {
        return '';
    }

    $TimeSet = $returnGetTimefromID['TimeB'];
    if ($TimeSet < 12)
        $AmorPm = "am";
    if ($TimeSet > 12)
    {
        $AmorPm = "pm";
        $TimeSet -= 12;
    }
    $TimeSetEnd = $TimeSet + $returnGetTimefromID['TimeSize'];
    if ($TimeSetEnd > 12)
        $TimeSetEnd -= 12 ;

    $returnString = $TimeSet." - ".$TimeSetEnd." ".$AmorPm;
    return($returnString);
}
function NameToMonth($Number)
{
    switch($Number)
    {
        case 1:
        $RName = 'Jan';
        break;
        case 2:
        $RName = 'Feb';
        break;
        case 3:
            $RName = 'Mar';
            break;
        case 4:
            $RName = 'Apr';
            break;
        case 5:
            $RName = 'May';
            break;
        case 6:
            $RName = 'June';
            break;
        case 7:
            $RName = 'July';
            break;
        case 8:
            $RName = 'Aug';
            break;
        case 9:
            $RName = 'Sept';
            break;
        case 10:
            $RName = 'Oct';
            break;
        case 11:
            $RName = 'Nov';
            break;
        case 12:
            $RName = 'Dec';
            break;

    }
    return($RName);
}
function MonthToNumber($NameM)
{

    switch($NameM)
    {
        case "January":
            $RNum = 1;
            break;
        case "February":
            $RNum = 2;
            break;
        case "March":
            $RNum = 3;
            break;
        case "April":
            $RNum = 4;
            break;
        case "May":
            $RNum = 5;
            break;
        case "June":
            $RNum = 6;
            break;
        case "July":
            $RNum = 7;
            break;
        case "August":
            $RNum = 8;
            break;
        case "September":
            $RNum = 9;
            break;
        case "October":
            $RNum = 10;
            break;
        case "November":
            $RNum = 11;
            break;
        case "December":
            $RNum = 12;
            break;

    }
    return($RNum);
}
/**
 * @example truncate(-1.49999, 2); // returns -1.49
 * @example truncate(.49999, 3); // returns 0.499
 * @param float $val
 * @param int f
 * @return float
 */
function truncate($val, $f="0")
{
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}
function NoofregisterStudents($levelid , $grouptime , $groupstartingdate)
{
    global $link;
    $Sqlforall = "SELECT `group_id`,`group_teacher` ,`group_startday` FROM `group` where `group_time` like '"
        . $grouptime . "' and `level_id` =" . $levelid
        . " and `group_startday` = '" . $groupstartingdate
        . "' order by `group_C_date` ";
    $resultTGT = mysqli_query($link,$Sqlforall );
    $rowTGT = mysqli_fetch_assoc($resultTGT);
    $FoundedGroupId = $rowTGT['group_id'];


    $SqlforNo = "SELECT count(st_id) as STuNo FROM `registration` WHERE `group_id` = $FoundedGroupId ";
    $resultTNo = mysqli_query($link,$SqlforNo );
    $rowSNo = mysqli_fetch_assoc($resultTNo);

    $NoofStudents=$rowSNo['STuNo'];


    return($NoofStudents);

    // how many got this group_id
    //from the registeration table
    //and all good after !!! get the count


}

function discountfromnametonumber($discountname)
{
    $discountvalue = "0%";
    switch($discountname)
    {
        case "DisQuid":
            $discountvalue = "25%";
            break;
        case "DisHalf":
            $discountvalue = "50%";
            break;
        case "DisHeavy":
            $discountvalue = "90%";
            break;
        case "None":
            $discountvalue = "0%";
            break;
    }
       
    return($discountvalue);

    

}

//this function to check if the data , are in after the timed data


    $todayCheck = $Tyear."-".$Tmonth."-".$Tday;

    $SqlCommandForCFe = "SELECT `lock_password`, `current_time_check`, `Holder_date`, `active` FROM `checkingdataandkey` ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);

    $current_time_check = $CheckIfReturnInF['current_time_check'];


    if (strtotime($todayCheck) < strtotime($current_time_check))
    {
        //Shit happen someone or something
        //changed the time ~

        //update $current_time_check
        header("location:index.php?TimeChanged=");
        //return you are not a good person!
    }
    else {

        mysqli_query($link ,"UPDATE `checkingdataandkey` SET 
                         `current_time_check`='$todayCheck'
                         WHERE `id_controller` = 1");
        //return all good !!!

// sorry change back the time please
    }



function CallMainFees($GroupID)
{
    global $link;
    $SqlCommandForCFe = "SELECT  `feesforgroup`, `feesforbookgroup` FROM `group` WHERE `group_id` = $GroupID ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);

    return($CheckIfReturnInF['feesforgroup']);
}
function CallFeesBook($GroupID)
{
    global $link;
    $SqlCommandForCFe = "SELECT  `feesforgroup`, `feesforbookgroup` FROM `group` WHERE `group_id` = $GroupID ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);

    return($CheckIfReturnInF['feesforbookgroup']);
}

function GetMark($LevelID,$GroupID,$StudentID)
{
    global $link;
    $TheSql = "SELECT `mark_id`, `s_id`, `level_id`, `group_id`, `mark`, `M_created_date` FROM `mark` WHERE `s_id` = $StudentID and `level_id` = $LevelID and `group_id` = $GroupID";
    $CheckIfHereInF      = mysqli_query ($link , $TheSql);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

    if (isset($CheckIfReturnInF['mark']))
        return($CheckIfReturnInF['mark']);
    else
        return -1;
}

function checkiffreeze($LevelID,$GroupID,$StudentID)
{
    global $link;
    $TheSql = "SELECT `mark_id`, `s_id`, `level_id`, `group_id`, `mark`, `M_created_date` FROM `mark` WHERE `s_id` = $StudentID and `level_id` = $LevelID and `group_id` = $GroupID";
    $CheckIfHereInF      = mysqli_query ($link , $TheSql);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

    if (isset($CheckIfReturnInF['mark']))
        return($CheckIfReturnInF['mark']);
    else
        return -1;
}
?>
<style>
        

	@import "css/bootstrap.min.css" print; 

</style>

<?php
require_once "config.php";
$Rgisid = $_GET['Regisid'];

$regissql = mysqli_query($link,"SELECT `payment_id`, `s_id`, `level_id`, `group_id`, `payment`, `P_created_date` FROM `paymenttwo` order by payment_id desc LIMIT 1");

$regisreturn = mysqli_fetch_array($regissql);

$levelid = $regisreturn['level_id'];
$groupid = $regisreturn['group_id'];
$studentid = $regisreturn['s_id'];
$pay2ndtime = $regisreturn['payment'];


// Adding  date today ~ //
$resultSNC = mysqli_query($link,"SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,
                                  `S_phone1`, `S_phone2`, `S_Birthdate` , `ST_Gid` , `S_Regis_Fees` ,date(`S_date_On`) as DateofRegis
                                  FROM `student` WHERE `ST_Gid` = $studentid");

$rowSNC = mysqli_fetch_array($resultSNC);
$Studentregisterday = $rowSNC['DateofRegis'];
if(dateDifference( $Studentregisterday, $today , $differenceFormat = '%a') == 0)
    $Rfeed = $rowSNC['S_Regis_Fees'];
else
    $Rfeed = 0;


$Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
$Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];

$fullname = $Fname . $Sirname;

$levelsql = mysqli_query($link,"SELECT `Level_id`, CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name, `level_period`, `level_fees`, `level_book`, `level_C_date` 
                                FROM `levels` WHERE Level_id =$levelid");
$levelreturn = mysqli_fetch_array($levelsql);
$level_name = $levelreturn['level_name'];
$level_period = $levelreturn['level_period'];
$level_Book = $levelreturn['level_book'];

$groupsql = mysqli_query($link,"SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date` FROM `group` WHERE group_id = $groupid");
$groupreturn = mysqli_fetch_array($groupsql);
$grouptime = $groupreturn['group_time'];

$groupdate = $groupreturn['group_startday'];

list($year, $month, $day) = explode("-", $groupdate);

$months_mapping = array("01" => "JAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAY", "06" => "JUN", "07" => "JUL", "08" => "AUG", "09" => "SEP",
    "10" => "OCT",
    "11" => "NOV",
    "12" => "DEC");
$newmonth = $months_mapping[$month];

$fixeddate = $day . "-" . $month . "-" . $year;

//echo $fixeddate = $fixeddate -86400;

$discountvalue = discountfromnametonumber($regisreturn['discount']);


/*/
         $cashSPayed = $FetchRetRegis['paid_fees'] - $FetchRetBookFees['level_book'];;

        $discountvalue = discountfromnametonumber($FetchRetRegis['discount']);

        $HolderOfAll[$numberOfEntry]["Name"] = StudentName1to2($FetchRetRegis['st_id']);
        $HolderOfAll[$numberOfEntry]["1st"] =
/*/
$Paided = $regisreturn['paid_fees'] - $level_Book;
//$totalWanted = $levelreturn['level_fees'] + $levelreturn['level_book'];
//
$totalWanted = (CalaDiscount($Paided , $discountvalue)) + $level_Book;

//$totalWanted = $levelreturn['level_fees'] + $levelreturn['level_book'] - $discountvalue;

$Wewant =  $totalWanted - $Paided;

$AllowToGetMark =  (CalRem($studentid,$groupid));

/*
if paid 60 if not full 30
+30
+60
*/

//if ($Wewant == 0)
 //   $validtill = date("d-m-Y", strtotime("$fixeddate +60 day"));
//else
list($LP_Number, $LP_BigSize) = explode(" ", $level_period);
if ($LP_BigSize == "Month")
    $Mult = 30;
if ($LP_BigSize == "Week")
    $Mult = 7;

$PlusVTime = $LP_Number * $Mult;

$validtill = date("d-m-Y", strtotime("$fixeddate + $PlusVTime day"));
//----- fees --
//print_r($_GET);
//data i have $level_name; for the level name .
?>
<script language="javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<div id="printableArea" class="container">
    <h4>Entrance Card</h4>
<table width='50%' border = '1'>
    <tr><td><center><h3><?php echo $SYSTEM_NAME; ?></h3></center></td></tr>
    <tr><td><center><h4>Short Courses</h4></center></td></tr>
    <tr><td><?php echo "No: ".$studentid; ?></td></tr>
    <tr><td><?php echo "Issued on: ".$fixeddate; ?></td></tr>
    <tr>
        <td><h3>Name: <?php echo $fullname; ?></h3></td>
    </tr>
    <tr>
    <tr>
        <td>
            Level: <i><?php echo $level_name;?></i>
        </td>
        </tr>
        <td>Time: <?php echo $grouptime; ?></td></tr>
    <tr><td>
        </td></tr>
    <br>
    <tr>
        <td><h3>Valid Till: <?php echo $validtill; ?></h3></td>
    </tr>
    <tr><td>Fees Payed: <?php echo $pay2ndtime;?></td></tr>



</table>


    <p>
        هذا الكرت يسمح لك بالدراسة في الفترة المزكورة اعلاه. لا يوجد استرداد للامولال .

        لحفظ اي اموال الرجاء استخراج كرت بالتاجيل. يسري من تاريخ استخراج الكرت.
    </p>


    <p>
        This receipt valid only for the period indicated above . No refund is possible .

        To save any amounts - please issue a freeze.
    </p>

</div>

<div class="form-actions">
    <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!" />

</div> <!-- /form-actions --></div>
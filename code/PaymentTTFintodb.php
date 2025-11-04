<?php
require_once "config.php";
//echo "<br>";
//print_r ($_POST);
//echo "<br>";
$StudentName = $_POST['StudentName'];
$Amount      = $_POST['StudentFees'];

if ($Amount == 0 || $_POST['feestype'] == "Nothing") 
    header ('Location:OtherPayment.php?FeesError=' . 1 );
else
{
    
    if ($_POST['feestype'] == "certif") $type = "Cert";
    if ($_POST['feestype'] == "placem") $type = "PorT";
    if ($_POST['feestype'] == "testi") $type = "PorT";
    if ($_POST['feestype'] == "dele") $type = "dele";
    
    $query = "INSERT INTO `paymentttf`(`payment_id`, `Studentname`, `Fees` , `type` , `P_created_date`) 
              VALUES (null,'$StudentName',$Amount,'$type',NOW())";

    //echo "<br>";
    //echo $query;
    //echo "<br>";
mysqli_query ($link , $query);
header ('Location:PaymentTTF.php?FeesError=' . 0 );
}
?>